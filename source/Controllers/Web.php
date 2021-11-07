<?php

namespace Source\Controllers;

use Source\Models\User;


class Web extends Controller
{

        
    public function __construct($router)
    {
        parent::__construct($router);

        
        if(!empty($_SESSION["user"]))
        {
            $this->router->redirect("app.home");
        }
        

        
    }

    public function login(): void
    {
        $head = $this->seo->optimize(
             "Faça o seu login para continua |". site("name") ,
           site("desc"),
           $this->router->route("web.login"),
           routeImage("login")
        )->render();
        echo $this->view->render("theme/login", [
            "head"=>$head

        ]);
    }

    public function register(): void
    {
        $head = $this->seo->optimize(
            "Crie sua conta no". site("name") ,
          site("desc"),
          $this->router->route("web.register"),
          routeImage("Register")
       )->render();

       $form_user = new \stdClass();
       $form_user->first_name = null;
       $form_user->last_name = null;
       $form_user->email = null;

       echo $this->view->render("theme/register", [
           "head"=>$head,
           "user" => $form_user

       ]);

    }

    public function forget(): void
    {
        $head = $this->seo->optimize(
            "Recupere sua senha | ". site("name") ,
          site("desc"),
          $this->router->route("web.forget"),
          routeImage("Forget")
       )->render();

       echo $this->view->render("theme/forget", [
        "head"=>$head

    ]);



    }

    public function reset($data): void
    {
        if (empty($_SESSION["forget"])){

            /*
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe o seu E-MAIL para recuperar sua senha"
            ]);
            */
            flash("info", "Informe o seu E-MAIL para recuperar sua senha");
            $this->router->redirect("web.forget");

        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget= filter_var($data["forget"], FILTER_DEFAULT);

        $errForget = "Não foi possivel ,recuperar sua senha tente novamente";

        if(!$email || !$forget){
            flash("error", $errForget);
            $this->router->redirect("web.forget");

        }

        $user = (new User())->find("email= :e AND forget= :f", "e={$email}&f={$forget}")->fetch();
        if(!$user){
            flash("error", $errForget);
            $this->router->redirect("web.forget");
        }
       // var_dump($data); exit();
        $head = $this->seo->optimize(
            "Crie a sua nova senha | ". site("name") ,
          site("desc"),
          $this->router->route("web.reset"),
          routeImage("Reset")
       )->render();

       echo $this->view->render("theme/reset", [
        "head"=>$head

    ]);


    }

    public function error($data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);

        $head = $this->seo->optimize(
            "Ooopssss {error} | ". site("name") ,
          site("desc"),
          $this->router->route("web.error",["errcode" => $error]),
          routeImage("$error")
       )->render();

       echo $this->view->render("theme/error", [
        "head"=>$head,
        "error" => $error

    ]);

    }
}


?>