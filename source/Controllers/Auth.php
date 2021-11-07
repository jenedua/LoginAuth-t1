<?php
  
  namespace Source\Controllers;

use Source\Models\User;
use Source\Support\Email;

class auth extends Controller
  {
      public function __construct($router)
      {
          parent::__construct($router);
      }

      public function login($data): void
      {
          $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
          $passwd = filter_var($data["passwd"], FILTER_DEFAULT);
          if(!$email || !$passwd){
              echo $this->ajaxResponse("message",[
                  "type" =>"alert",
                  "message" => "Informe seu e-mail e senha parar logar"
              ]);
              return;
          }

          $user = (new User())->find("email= :e", "e={$email}")->fetch();
          if(!$user || !password_verify($passwd, $user->passwd))
          {
            echo $this->ajaxResponse("message",[
                "type" =>"error",
                "message" => "E-mail ou senha não conferem"
            ]);
            return;

          }

          $_SESSION["user"]= $user->id;
          echo $this->ajaxResponse("redirect", ["url"=> $this->router->route("app.home")]);

          
        


      }

      public function register ($data): void
      {
          $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
          if(in_array("", $data)){
              echo $this->ajaxResponse("message", [
                  "type" => "error",
                  "message" => "Preencha todos os campos para cadastrar-se.."
              ]);
              return;
          }
          /*
          if(!filter_var($data["email"],FILTER_VALIDATE_EMAIL))
          {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Favor informe um e-mail valida para continuar.."
            ]);
            return;

          }
           $check_user_email = (new User())->find("email = :e", "e={$data["email"]}")->count();

           if($check_user_email){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Já existe um usuario cadastrada com este e-mail.."
            ]);
            return;


           }
           */

          $user = new User();
          $user->first_name = $data["first_name"];
          $user->last_name = $data["last_name"];
          $user->email = $data["email"];
          $user->passwd = $data["passwd"];

          if(!$user->save()){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return;

          }

          $_SESSION["user"] = $user->id;
          echo $this->ajaxResponse("redirect", [
              "url" => $this->router->route("app.home")
          ]);
      
      }

      public function forget($data):void
      {

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);

        if(!$email){
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe a seu email para recuperar a senha"
            ]);
            return;
        }
            $user = (new User())->find("email = :e", "e={$email}")->fetch();
            if(!$user){
                echo $this->ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "O E-MAIL informado não é cadastrado"
                ]);
                return;
            }

            $user->forget = (md5(uniqid(rand(), true)));
            $user->save();

            $_SESSION["forget"] = $user->id;

            $email = new Email();
            $email->add(
                "Recuper a sua senha | ".site("name"),
                $this->view->render("emails/recover",[
                    "user" => $user,
                    "link" => $this->router->route("web.reset", [
                        "email" => $user->email,
                        "forget" => $user->forget
                    ])
                ]),
                "{$user->first_name} {$user->last_name}",
                $user->email
            )->send();

            flash("success", "Enviamos um link de recuperação para seu e-mail");

            echo $this->ajaxResponse("redirect", [
                "url" => $this->router->route("web.forget")
            ]);        

    }

    public function reset($data): void
    {
        if(empty($_SESSION["forget"]) || !$user = (new User())->findById($_SESSION["forget"])){
            flash("error", "Não foi possivel recuperar, tente novamente");
             echo $this->ajaxResponse("redirect", [
                "url"=> $this->router->route("web.forget")
             ]);
             return;

        }

        if(empty($data["password"]) || empty($data["password_re"])){
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe e repita sua nova senha"
            ]);
            return;
        }

        if($data["password"] != $data["password_re"]){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Senhas differentes"
            ]);
            return;
        }

        $user->passwd = $data["password"];
        $user->forget = null;

        if(!$user->save()){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return; 
        }

        unset($_SESSION["forget"]);
        flash("success", "Sua senha foi atualizar com sucesso");
        echo $this->ajaxResponse("redirect", [
            "url"=> $this->router->route("web.login")
        ]);
        //echo json_encode($data);
    }

  }

?>