<?php

class OrderDetailModel
{
    public function find($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT *
								FROM orders_details 
								WHERE orderDetails_id = :id");

        $query->execute([
            "id" => $id,
        ]) ;


        return $query->fetchAll() ;
    }

    public function findBasketByOrder($idOrder)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT orders_details.orderDetails_id, QuantityOrdered, priceEach, title ,order_id
								FROM orders_details 
								INNER JOIN menus 
								ON menus.menu_id = Orders_details.menu_id
								WHERE order_id = :idOrder");

        $query->execute([
            "idOrder" => $idOrder,
        ]) ;


        return $query->fetchAll() ;
    }




    public function addOrCreateToMenu($idOrder, $idMenu, $quantity, $priceEach)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("INSERT INTO orders_details
								(`order_id`, `menu_id`, `quantityOrdered`, `priceEach`)
                                VALUES (:idOrder, :idMenu, :quantity, :priceEach)
                                ON DUPLICATE KEY UPDATE 
                                quantityOrdered = QuantityOrdered + :quantity");

        $query->execute([
            "idOrder" => $idOrder,
            "idMenu" => $idMenu,
            "quantity" => $quantity,
            "priceEach" => $priceEach,
        ]) ;
    }


    public function setOrCreateToMenu($idOrder, $idMenu, $quantity, $priceEach)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("INSERT INTO orders_details
								(`order_id`, `menu_id`, `quantityOrdered`, `priceEach`)
                                VALUES (:idOrder, :idMenu, :quantity, :priceEach)
                                ON DUPLICATE KEY UPDATE 
                                quantityOrdered = :quantity");

        $query->execute([
            "idOrder" => $idOrder,
            "idMenu" => $idMenu,
            "quantity" => $quantity,
            "priceEach" => $priceEach,
        ]) ;
    }

    public function updateQuantity($id, $quantity)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("UPDATE orders_details
								SET quantityOrdered = :quantity
								WHERE orderDetails_id = :id");

        $query->execute([
            "id" => $id,
            "quantity" => $quantity,
        ]) ;

    }

    public function removeByOrder($idOrder)
    {

        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("DELETE FROM orders_details
								WHERE order_id = :idOrder");

        $query->execute([
            "idOrder" => $idOrder,
        ]) ;
    }

    public function remove($id)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("DELETE FROM orders_details
								WHERE orderDetails_id = :id");

        $query->execute([
            "id" => $id,
        ]) ;
    }
}