<?php


class UserSession
{
    public function __construct()
    {
        if(session_status()== PHP_SESSION_NONE)
        {
            session_start();
        }

    }

    public function create($id,$lastName,$firstName,$email,$admin)
    {
        $_SESSION['user']=["id" =>$id,
                            "LastName" =>$lastName,
                            "FirstName" =>$firstName,
                            "email"=>$email,
                            "admin"=>$admin];
    }

    public function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function isAuthenticated()
    {
        return isset($_SESSION["user"]);
    }

    public function isAdmin()
    {
       if(!$this->isAuthenticated())
       {
           return false;
       }
       return $_SESSION['user']["admin"];
    }

    public function getId()
    {
        if(!$this->isAuthenticated())
        {
            return null;
        }
        return $_SESSION["user"]["id"];
    }

    public function getFirstName()
    {
        if(!$this->isAuthenticated())
        {
            return null;
        }

        return $_SESSION["user"]["FirstName"];
    }

    public function getLastName()
    {
        if(!$this->isAuthenticated())
        {
            return null;
        }
        return $_SESSION["user"]["LastName"];
    }

    public function getEmail()
    {
        if(!$this->isAuthenticated())
        {
            return null;
        }
        return $_SESSION["user"]["email"];
    }



}