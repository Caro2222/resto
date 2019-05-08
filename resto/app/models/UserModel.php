<?php
class UserModel
{
    public function create($firstName,$lastName,$email,$phone,$address,$postalCode,$city,$password)
    {

            $pdo = (new Database())->getPdo();
            $query = $pdo->prepare("INSERT INTO user(FirstName,LastName,email,phone,address,postalCode,city,password,inscriptionDate, admin)
                                            VALUES  (:FirstName,:LastName,:email,:phone,:address,:postalCode,:city,:password,NOW(), 0)");
            $query->execute(["FirstName"=>$firstName,
                            "LastName"=>$lastName,
                            "email"=>$email,
                            "phone"=>$phone,
                            "address"=>$address,
                             "postalCode"=>$postalCode,
                              "city"=>$city,
                             "password"=>$password
            ]);

    }

    public function show()
    {
        $pdo = (new Database()) ->getPdo();
        $result = $pdo->query(
            "SELECT *
                    FROM booking
                   order by dateResa
                   desc 
                    ");
        return $result->fetchAll();
    }

    public function isEmailTaken($email)
    {
        $pdo = (new Database()) ->getPdo();
        $query = $pdo->prepare(
                        "SELECT COUNT(*) AS nbr
                                   FROM user
                                   WHERE email = :email
                                    ");
        $query->execute(["email" =>$email]);
        $result = $query->fetch();

        return $result["nbr"] > 0 ;
    }


    public function findByEmailandCheckPwd($email,$password)
    {
        $pdo = (new Database()) ->getPdo();
        $query =$pdo ->prepare("SELECT *
                                            FROM user
                                            WHERE email = :email
                                         ");
        $query->execute(["email"=>$email]);
        $user =  $query->fetch();
        if(empty($user))
        {
            throw new DomainException("email inconnu");
        }
        if(!password_verify($password,$user["password"]))
        {
            throw new DomainException("mot de passe incorrect");
        }
        return $user;
    }

    public function updateLoginDate($id)
    {
        $pdo = (new Database()) ->getPdo();
        $query =$pdo->prepare("UPDATE user
                                         SET lastLoginDate=NOW()
                                         WHERE id= :id ");
        $query->execute(["id"=>$id]);
    }



}