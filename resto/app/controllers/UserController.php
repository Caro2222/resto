<?php
 class UserController
 {






     public function signUpAction()
     {
         $redirect=null;
         $error = false ;

         $model = new UserModel();
         if($_POST) {
             $flashBag = new Flashbag();


             if(! isset($_POST['FirstName']) || empty(trim($_POST['FirstName'])))
             {
                 $flashBag->addMessage("Veuillez entrer un prénom") ;
                 $error = true ;
             }

             if(! isset($_POST['LastName']) || empty(trim($_POST['LastName'])))
             {
                 $flashBag->addMessage("Veuillez entrer un nom") ;
                 $error = true ;
             }


             if(! isset($_POST['email']) || empty(trim($_POST['email'])))
             {
                 $flashBag->addMessage("Veuillez entrer un émail") ;
                 $error = true ;
             }
             if(! isset($_POST['phone']) || empty(trim($_POST['phone'])))
             {
                 $flashBag->addMessage("Veuillez entrer un numéro de télèphone") ;
                 $error = true ;
             }
             if(! isset($_POST['address']) || empty(trim($_POST['address'])))
             {
                 $flashBag->addMessage("Veuillez entrer une addresse") ;
                 $error = true ;
             }
             if(! isset($_POST['city']) || empty(trim($_POST['city'])))
             {
                 $flashBag->addMessage("Veuillez entrer votre ville") ;
                 $error = true ;
             }
             $password =$_POST["password"];
             if(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $password))
             {
                 $flashBag = new Flashbag();
                 $flashBag->addMessage("Votre mot de passe doit contenir une majuscule,une minuscule et un chiffre");
                 $error = true;
             }

             else
             {

                 if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                 {
                     $flashBag->addMessage("L'addresse email n'est pas valide") ;
                     $error = true ;
                 }
                 if($model->isEmailTaken($_POST['email']))
                 {
                     $flashBag->addMessage("Email déjà pris") ;
                     $error = true ;
                 }
             }
             if($error)
             {
                 return ["redirect" => "resto_user_inscription"] ;
             }


             $hashedPassWord=password_hash($_POST["password"],PASSWORD_BCRYPT);
             $model->create($_POST["FirstName"],$_POST["LastName"],$_POST["email"],
                 $_POST["phone"],$_POST["address"],$_POST["postCode"],$_POST["city"],$hashedPassWord);
             $flashBag = new Flashbag();
             $flashBag->addMessage("Votre compte a été crée");
             $redirect="resto_home";


         }
         return[
             'template'=>['folder'=>"User",
                 "file"=>'inscription',
             ],
             "title" => "ajouter des plats",

             "redirect" => $redirect

         ];

     }
    public function loginAction()
    {
        $redirect=null;

        if(isset($_POST['email']) &&  isset($_POST['password']))
        {
            $user= null;
            $model = new UserModel();
            try {

                $user = $model->findByEmailandCheckPwd($_POST['email'], $_POST['password']);
            }
            catch (DomainException $exception)
            {
                $fashbag = new Flashbag();
                //$fashbag->addMessage($exception->getMessage());
                $fashbag->addMessage("Email ou mot de passe incorrect");

                return ["redirect"=>"resto_user_login"];
            }
           // die(var_dump());
            $model->updateLoginDate($user["id"]);
            $userSession = new UserSession();
            $userSession ->create($user['id'],$user["LastName"],$user["FirstName"],$user["email"],$user["admin"]);

            return ["redirect" =>"resto_home"];

        }
        return[
            'template'=>['folder'=>"User",
                "file"=>'login',
            ],


            "redirect" => $redirect

        ];
    }


    public function logoutAction()
    {
        $userSession = new  UserSession();
        $userSession->destroy();

        return ["redirect" => "resto_home"] ;
    }


    public function updateCancelledAction()
    {
        if(isset($_GET['booking_id'])&& ctype_digit($_GET["booking_id"]))
        {
            $model =new BookingModel();
            $model->updateCancelled($_GET['booking_id']);

        }


        return [ "redirect" => "resto_user_profil" ];
    }






 }