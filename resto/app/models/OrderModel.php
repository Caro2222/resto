<?php
class OrderModel
{

    function createOrderDetail($order_id,$quantityOrdered,$menu_id)
    {

        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "INSERT INTO order_details (order_id, quantityOrdered,menu_id)                      
                        VALUES  (:order_id, :quantityOrdered,:menu_id");
        $query->execute(["order_id" => $order_id,
            "quantityOrdered" => $quantityOrdered,
            "menu_id"=>$menu_id,

        ]);
        return $pdo->lastInsertId();
    }

    function createOrder($user_id,$deliveryDate,$payed)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare(
            "INSERT INTO orders (user_id,DeliveryDate,OrdersDate,payed)                      
                        VALUES  ( :user_id,:deliveryDate,NOW(),:payed");
        $query->execute([
            "user_id"=>$user_id,
            "deliveryDate" =>$deliveryDate,
            "payed"=>$payed

        ]);
        return $pdo->lastInsertId();

    }




    function showCart($cart)
    {
        $pdo = (new Database())->getPdo();
        $whereIn = implode(',',$cart);
        $query = $pdo->prepare("SELECT * FROM menus
                                        WHERE menu_id IN($whereIn)");
        $query->execute();

        return $query->fetchAll();
    }

}