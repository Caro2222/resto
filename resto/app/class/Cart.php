<?php


class Cart
{



    public function __construct()
    {
        if(session_status()== PHP_SESSION_NONE)
        {
            session_start();
        }

        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

    }



    public function addMenu($menu_id, $quantity)
    {

        $_SESSION['cart'][$menu_id] += $quantity;
        return $_SESSION['cart'];
    }

    public function del($menu_id)
    {
        unset($_SESSION['panier'][$menu_id]);
    }

    public function delAll()
    {
        $_SESSION['cart'] = [];
    }

    public function format()
    {
        $orderTab = [];
        foreach ( $_SESSION['cart'] as $menu_id => $quantity)
        {
            $orderTab[] ['menu'=>$id, "quantity"=>$quantity] ;
        }

    }
}




