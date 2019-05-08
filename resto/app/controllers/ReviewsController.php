<?php


class ReviewsController
{
    public function showAction()
    {

        $model =new ReviewsModel();
        $allReviews= $model->show();

        return[
            'template'=>['folder'=>"Reviews",
                "file"=>'reviews',
            ],
             "allReviews"=>$allReviews
        ];


    }

    public function createAction()
    {

        $flashBag = new Flashbag();
            $userSession = new UserSession();
        $model = new ReviewsModel();

        if(!$userSession->isAuthenticated())
        {
            $flashBag->addMessage("Veuillez vous connecter pour commenter ce menu") ;
            return ["redirect" => "resto_user_login"];
        }

        $userId = $userSession->getId();

        if(isset($_GET['id']) && ctype_digit($_GET["id"])) {
            $model = new MenuModel ();
            $menu = $model->find($_GET["id"]);
            if (!$menu) {
                return ["redirect" => "resto_menu"];
            }


            if (isset($_POST['comment'])) {
                $model = new ReviewsModel();
                $model->create($userId,$_GET["id"], $_POST['comment'], $_POST['note']);
                $flashBag->addMessage("Votre commentaire a bien été enregistrer ");
                return ["redirect" => "resto_menu"];
            }
        }
            return [
                'template' => ['folder' => "Reviews",
                    "file" => 'create',
                ],
                'menu'=>$menu,
                "userId"=>$userId
            ];


        }




}