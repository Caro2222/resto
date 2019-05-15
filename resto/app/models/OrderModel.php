<?php
class OrderModel
{

//    function createOrderDetail($order_id,$quantityOrdered,$menu_id)
//    {
//
//        $pdo = (new Database())->getPdo();
//        $query = $pdo->prepare(
//            "INSERT INTO orders_Details (order_id, quantityOrdered,menu_id)
//                        VALUES  (:order_id, :quantityOrdered,:menu_id)");
////        foreach ($quantityOrdered as $quantity ) {
//            $query->execute(["order_id" => $order_id,
//
//                "quantityOrdered" => $quantityOrdered,
//
//                "menu_id" => $menu_id,
//
//            ]);
////        }
//        return $pdo->lastInsertId();
//    }
//
//    function createOrder($user_id,$deliveryDate,$payed)
//    {
//        $pdo = (new Database())->getPdo();
//        $query = $pdo->prepare(
//            "INSERT INTO orders (user_id,DeliveryDate,OrdersDate,payed)
//                        VALUES  ( :user_id,:deliveryDate,NOW(),:payed)");
//        $query->execute([
//            "user_id"=>$user_id,
//            "deliveryDate" =>$deliveryDate,
//            "payed"=>$payed
//
//        ]);
//        return $pdo->lastInsertId();
//
//    }
//
//
//
//
//    function showCart($cart)
//    {
//        $pdo = (new Database())->getPdo();
//        $whereIn = implode(',',$cart);
//        $query = $pdo->prepare("SELECT * FROM menus
//                                        WHERE menu_id IN($whereIn)");
//        $query->execute();
//
//        return $query->fetchAll();
//    }
//
    function showAll($userId)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT OrdersDate,DeliveryDate,user_id,Status ,SUM(quantityOrdered * priceEach )AS total,orders.order_id ,title,quantityOrdered,priceEach,orderDetails_id FROM `orders`
        inner join orders_Details on orders_Details.order_id=orders.order_id
        inner join menus on menus.menu_id=orders_Details.menu_id
        GROUP BY orders.order_id
        having user_id=:userId
        and Status ='confirm'");
        $query->execute(["userId"=>$userId]);
        return $query->fetchAll();
    }

    function showAllMenuByOrder($userId)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT OrdersDate,DeliveryDate,user_id,Status ,orders.order_id ,title,quantityOrdered,priceEach,orderDetails_id 
                                        FROM `orders` 
                                        inner join orders_Details on orders_Details.order_id=orders.order_id 
                                        inner join menus on menus.menu_id=orders_Details.menu_id 
                                        where user_id=4 and Status='confirm'");
        $query->execute(["userId"=>$userId]);
        return $query->fetchAll();
    }

    public function getUserBasketId($idUser)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT order_id 
								FROM orders
                                WHERE user_id = :idUser 
                                AND status = 'basket'");

        $query->execute(["idUser" => $idUser]) ;

        $result = $query->fetch() ;
        if($result)
        {
            return $result['order_id'] ;
        }
        else
        {
            $query = $pdo->prepare("INSERT INTO orders
								(user_id, OrdersDate, Status)
                                VALUES (:idUser, NOW(), 'basket')");

            $query->execute(["idUser" => $idUser]) ;

            return $pdo->lastInsertId() ;

        }
    }


    public function getUserBasketConfirmId($orderId)
    {
        $pdo = (new Database())->getPdo();
        $query = $pdo->prepare("SELECT *
								FROM orders
                                WHERE order_id = :orderId 
                                AND status = 'confirm'");

        $query->execute(["orderId" => $orderId]);

        $result = $query->fetchAll();
    }
    public function confirmBasket($DeliveryDate,$orderId)
    {
        $pdo = (new Database())->getPdo();
        $query =$pdo->prepare("UPDATE orders
                       SET DeliveryDate= :DeliveryDate,status='confirm'
                        WHERE order_id=:orderId");
        $query->execute([
                            'DeliveryDate'=>$DeliveryDate,
                           'orderId'=>$orderId,
                        ]);


    }


}