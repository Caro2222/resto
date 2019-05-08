<?php


class MenuModel
{
public function findAll()
{

        $pdo = (new Database())->getPDO();
        $result = $pdo->query(
            "SELECT *
                        FROM menus");
        return $result->fetchAll();


}

    public function find($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "SELECT *
                        FROM menus
                         WHERE menu_id = :id");
        $query->execute(["id" => $id]);
        return $query->fetch();

    }

public function create($title,$content,$price_menu,$startDate,$endDate)
{

    $pdo = (new Database())->getPdo();
    $query = $pdo->prepare("INSERT INTO menus
                                     (title,content,price_menu,startDate,endDate)
                                     VALUES (:title,:content,:price_menu,:startDate,:endDate)  ");
    $query->execute(["title" => $title,
        "content" => $content,
        "price_menu" => $price_menu,
        "startDate" => $startDate,
        "endDate" => $endDate]);

    return $pdo->lastInsertId();

}

public function addPlatToMenu($idMenu, $idPlats)
{
    $pdo =(new Database())->getPdo();
    $query = $pdo->prepare("INSERT INTO plates_menus(menu_id,plates_id)
                                      VALUES (:menu_id, :plates_id) ");
    foreach ($idPlats as $idPlat)
    {
        $query->execute([
                            "menu_id" => $idMenu,
                            "plates_id" => $idPlat,
                        ]);

    }
}



    public function delete($id)
    {
        $pdo = (new Database())->getPdo();
        $query =$pdo->prepare("DELETE FROM menus
                                         WHERE menu_id = :id ");
        $query->execute(["id" => $id]);
    }



    public  function update($menuId,$title,$content,$price_menu,$startDate,$endDate)
    {
        $pdo =(new Database())->getPdo();

        $query=$pdo->prepare("UPDATE menus
                                        SET title= :title,
                                            content=:content,
                                             price_menu=:price_menu,
                                             startDate=:startDate,
                                             endDate=:endDate                                           
                                        WHERE menu_id =:id ");
        $query->execute([
            "id" => $menuId,
            "title" => $title,
            "content" => $content,
            "price_menu" => $price_menu,
            "startDate" =>$startDate,
            "endDate"=>$endDate,

        ]);

    }

    public function checkedPlats($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "SELECT plates.plates_id, product, (menu_id IS NOT NULL) AS checked
            FROM `plates`
            LEFT JOIN plates_menus ON plates_menus.plates_id= plates.plates_id AND menu_id= :id
            ORDER BY product");
        $query->execute(["id" => $id]);
        return $query->fetchAll();

    }

    public function findMenuByPlate($platesId)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT   product, plates.plates_id, `product`, `product_description`, `ingredient`, `price`, `photo`, `category`,title,content
                        FROM plates
                        inner join plates_menus on plates_menus.plates_id=plates.plates_id
                        INNER join menus on menus.menu_id=plates_menus.menu_id
                        where plates.plates_id=:plateId");
        $query->execute(["plateId"=>$platesId]);
        return $query->fetchAll();

    }



}