<?php


class Cart
{



    public function __construct()
    {
        if(session_status()== PHP_SESSION_NONE)
        {
            session_start();
        }

    }

    public function addCart($id)
    {
        if (empty($_SESSION['cart'])) {
         $_SESSION['cart'] = [];
        }

        array_push($_SESSION['cart'], $id);
        return $_SESSION['cart'];


    }
    public function getQuantity($quantity)
    {
        array_push($_SESSION['cart']['quantity'], $quantity);
        return $_SESSION["cart"]["quantity"];
    }

    public function count(){
        return array_sum($_SESSION['panier']);
    }
    public function del($menu_id){
        unset($_SESSION['panier'][$menu_id]);
    }
}




