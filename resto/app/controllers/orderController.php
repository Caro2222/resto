<?php
class OrderController
{
    public function CreateAction()
    {
        //  function createOrderDetail($order_id,$quantityOrdered,$menu_id)
        //   function createOrder($deliveryDate,$user_id,$payed)
        if ($_POST) {

            $userSession = new UserSession();

            $flashBag = new Flashbag();
            if (!$userSession->isAuthenticated()) {
                $flashBag->addMessage("Veuillez vous connecter pour réserver une table");
                return ["redirect" => "resto_user_login"];
            }

            if ($_POST) {

                $model = new OrderModel();
                $userId = $userSession->getId();

                $order_id = $model->createOrder($userId, $_POST['delivery'], $_POST['payed']);
               // $model->createOrderDetail($order_id, $_POST['quantity'], $_GET['id']);

            }
        }
        return [
            'template' => [
                'folder' => "Order",
                "file" => 'Create',

            ],


        ];
    }


    public function AddAction()
    {
        $userSession = new UserSession();
        if (!$userSession->isAuthenticated()) {
            $flashBag = new Flashbag();
            $flashBag->addMessage("Vous devez etre enregistrer");
            $error = true;
            return ["redirect" => "resto_home"];
        }

        if(isset($_GET['id']) && ctype_digit($_GET["id"]))
        {
            $modelCart = new Cart();
            $modelOrder = new OrderModel();
            $carts = $modelCart->addCart($_GET['id']);
            $orders = $modelOrder->showCart($carts);

        }

        if ($_POST) {

            $model = new OrderModel();
            $userId = $userSession->getId();
            
            $order_id = $model->createOrder($userId, $_POST['delivery'], $_POST['payed']);
            // $model->createOrderDetail($order_id, $_POST['quantity'], $_GET['id']);

        }


        return [
            'template' => [
                'folder' => "Order",
                "file" => 'Create',

            ],
             "carts" => $carts,
            "orders" => $orders,

        ];
    }
}