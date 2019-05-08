<?php
class ReviewsModel
{
    public  function create($userId,$menu_id,$comment,$note)
    {

        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "INSERT INTO reviews (menu_id, user_id, comment, note, dateCreation)                      
                        VALUES  (:menu_id, :user_id, :comment, :note, NOW())");
        $query->execute(["comment" => $comment,
            "note" => $note,
            "menu_id"=>$menu_id,
            "user_id"=> $userId,


        ]);
        return $pdo->lastInsertId();
    }


    public function show()
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT dateCreation,FirstName,LastName,title,comment,note FROM `reviews`
                                            inner join user on user.id=reviews.user_id
                                            inner join menus on menus.menu_id=reviews.menu_id");
        $query->execute();
        return $query->fetchAll();
    }

    public function showByMenu($idMenu)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT dateCreation,FirstName,LastName,title,comment,note
                                            FROM `reviews`
                                            inner join user on user.id=reviews.user_id
                                            inner join menus on menus.menu_id=reviews.menu_id
                                            where  menus.menu_id=:menu_id");
        $query->execute(["menu_id"=>$idMenu]);
        return $query->fetchAll();
    }



//    public function findUserId($id)
//    {
//        $pdo = (new Database())->getPdo();
//        $query = $pdo->prepare(
//            "SELECT *
//                        FROM user
//                        where id=:id");
//        $query->execute(["id" => $id]);
//        return $query->fetch();
//
//
//    }
}