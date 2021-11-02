<?php
  
  namespace Source\Controllers;

use Source\Models\User;

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
  }

?>