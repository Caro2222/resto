<?php
class OrderController
{



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
             $model->createOrderDetail($order_id, $_POST['quantity'], $_GET['id']);

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