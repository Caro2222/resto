<?php
class PlatModel
{

    public function findAllIdandName()
    {

        $pdo = (new Database())->getPDO();
        $query = $pdo->query(
            "SELECT plates_id,product
                    FROM plates ");

        return $query->fetchAll();


    }
    public function findAll()

    {
        $pdo = (new Database())->getPDO();
        $result = $pdo->query(
                    "SELECT *
                    FROM plates
                    ORDER BY category
                    DESC ");
        return $result->fetchAll();
    }

    public function find($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "SELECT *
                        FROM plates
                         WHERE plates_id = :id");
        $query->execute(["id" => $id]);
        return $query->fetch();

    }

    public function findByMenu($idMenu)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "SELECT   product, plates.plates_id, `product`, `product_description`, `ingredient`, `price`, `photo`, `category`,menu_id,(plates.plates_id IS NOT NULL) AS checked
                        FROM plates
                        inner join plates_menus on plates_menus.plates_id=plates.plates_id
                        WHERE menu_id = :idMenu
                        ORDER BY category");
        $query->execute(["idMenu" => $idMenu]);
        return $query->fetchAll();

    }


    public function findAllOrderByMenu()
    {

        $pdo = (new Database())->getPDO();
        $result = $pdo->query(
            "SELECT menu_id, plates_menus.plates_id, product ,category
                        FROM plates 
                        INNER JOIN plates_menus ON plates_menus.plates_id=plates.plates_id 
                        ORDER By  menu_id ");

        return $result->fetchAll();
    }


    public  function create($product,$product_description,$ingredient,$price,$photo,$category)
    {

            $pdo = (new Database())->getPdo();
            $query = $pdo->prepare(
                "INSERT INTO plates(product,product_description,ingredient,price,photo,category) 
                        VALUES  (:product,:product_description,:ingredient,:price,:photo,:category) 
                        ");
            $query->execute(["product" => $product,
                "product_description" => $product_description,
                "ingredient" => $ingredient,
                "price" => $price,
                "photo" =>$photo,
                "category"=>$category
            ]);
        return $pdo->lastInsertId();
    }

    public function updateImg($id,$filename)
    {
        $pdo=(new Database())->getPdo();
        $query= $pdo->prepare("UPDATE plates
                                            SET photo = :filename
                                            WHERE plates_id = :id ");
        $query->execute([
            "filename" =>$filename,
            "id" =>$id,
        ]);
    }
    public function remove($id)
    {
        $pdo = (new Database())->getPdo();
        $query =$pdo->prepare("DELETE FROM plates
                                         WHERE plates_id = :id ");
        $query->execute(["id" => $id]);
    }

    public  function update($id,$product,$product_description,$ingredient,$price,$photo,$category)
    {
        $pdo =(new Database())->getPdo();

        $query=$pdo->prepare("UPDATE plates
                                        SET product= :product,
                                            product_description=:product_description,
                                             ingredient=:ingredient,
                                             price=:price,
                                             photo=:photo,
                                             category=:category
                                        WHERE plates_id = :id");
        $query->execute([
                            "id" => $id,
                            "product" => $product,
                            "product_description" => $product_description,
                            "ingredient" => $ingredient,
                            "price" => $price,
                            "photo" =>$photo,
                            "category"=>$category,

                        ]);


    }


    public function findOldPlats($menuId)
    {
        $pdo = (new Database())->getPdo();
        $query=$pdo ->prepare(
            "SELECT plates_id
                                            FROM plates_menus
                                            WHERE menu_id= :menuId"
        );
        $query->execute(["menuId"=>$menuId]);
        return  $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function deleteOldPlats($deletePlats,$idMenu)
    {
        $pdo=(new Database())->getPdo();
        $query =$pdo->prepare(
            "DELETE FROM plates_menus
                                          WHERE  menu_id=:menu_id AND plates_id=:plates_id "
        );
        foreach ($deletePlats as $idPlat)
        {
            $query->execute([
                "menu_id" => $idMenu,
                "plates_id" => $idPlat,
            ]);

        }

    }


}