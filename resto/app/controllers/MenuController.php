<?php


class MenuController
{
    public function showAllAction()
    {
        $menuModel = new MenuModel();
        $allMenus = $menuModel->findAll();
        $platModel = new PlatModel();
        $allPlatsByMenu = $platModel->findAllOrderByMenu() ;


        $allPlats = [] ;


        foreach ($allPlatsByMenu as $plat)
        {
                $allPlats[$plat['menu_id']][] = [
                                                    "plates_id" => $plat['plates_id'],
                                                    "product" => $plat['product'],
                                              ] ;
        }



        return [
            'template' => ['folder' => "Menu",
                "file" => 'menu',
            ],

            "title" => "Tous nos menus",

            "allMenus" => $allMenus,
            "allPlats"=> $allPlats,
        ];


    }

    public function showOneAction()
    {
        if(isset($_GET['id']) && ctype_digit($_GET["id"]))
        {
            $menuModel= new MenuModel();
            $platModel = new PlatModel();
            $reviewsModel = new ReviewsModel();
            return [
                'template'=>[
                    'folder'=>"Menu",
                    "file"=>'menuDetail',

                ],
                "title"=>"Detail de nos menu",

             "menu"=>$menuModel->find($_GET["id"]),
             "plats"=>$platModel->findByMenu($_GET["id"]),
                "allReviews"=>$reviewsModel->showByMenu($_GET["id"])
            ];
        }
        else
        {
            return [ "redirect" => "resto_menu" ] ;
        }

    }




    public function createAction()
    {




            $redirectURl = null;
            $platModel = new PlatModel();
            $allPlats = $platModel->findAllIdandName();

            $error = false;
            $userSession = new UserSession();

            if (!$userSession->isAdmin()) {
                $flashBag = new Flashbag();
                $flashBag->addMessage("Vous devez etre admin");
                $error = true;
                return ["redirect" => "resto_home"];
            }


            if ($_POST) {
                $flashBag = new Flashbag();
                if (!isset($_POST['title']) || (trim($_POST["title"])) == "") {
                    $flashBag->addMessage("Veuillez entrer le titre du menu");
                    $error = true;

                }
                if (!isset($_POST['plates[]'])  == "") {
                    $flashBag->addMessage("Veuillez selectionner les plats");
                    $error = true;

                }


                if (!isset($_POST['content']) || (trim($_POST["content"])) == "") {

                    $flashBag->addMessage("Veuillez entrer la description du menu");
                    $error = true;

                }
                if (!isset($_POST['price_menu']) || (trim($_POST["price_menu"])) == "") {

                    $flashBag->addMessage("Veuillez entrer le prix du menu");
                    $error = true;

                }
                if (!isset($_POST['startDate']) || (trim($_POST["startDate"])) == "") {


                    $flashBag->addMessage("Veuillez entrer la date de début");
                    $error = true;

                }
            if (!isset($_POST['endDate']) || (trim($_POST["endDate"])) == "") {


                $flashBag->addMessage("Veuillez entrer la date de fin");
                $error = true;

            }

                $startDate=explode('-',($_POST['startDate'])) ;
                $start =mktime(0,0,0,$startDate[1],$startDate[2],$startDate[0]);
                $endDate=explode('-',($_POST['endDate'])) ;
                $end =mktime(0,0,0,$endDate[1],$endDate[2],$endDate[0]);

                if($start>$end)
                {

                    $flashBag->addMessage("la date de debut est superieure à la date de fin  ");
                    $error = true;
                }
                if ($error) {
                    return ["redirect" => "resto_menu_create"];
                } else {


                    $model = new MenuModel();

                    $idMenu = $model->create($_POST['title'], $_POST['content'], $_POST['price_menu'], $_POST['startDate'], $_POST['endDate']);
                    $model->addPlatToMenu($idMenu, $_POST['plates']);

                    $flashBag = new Flashbag();
                    $flashBag->addMessage("Menu crée avec succés");
                    $redirectURl = "resto_menu";
                }
            }
            return [
                'template' => [
                    'folder' => "Menu",
                    "file" => 'menuAdd',

                ],

                "title" => "ajouter des menu",

                "redirect" => $redirectURl,
                "allPlats" => $allPlats,

            ];

    }
    public function deleteAction()
    {
        $userSession = new UserSession();
        if (!$userSession->isAdmin()) {
            $flashBag = new Flashbag();
            $flashBag->addMessage("Vous devez etre admin");
            $error = true;
            return ["redirect" => "resto_home"];
        }

        if(isset($_GET['id']) && ctype_digit($_GET["id"]))
        {

            $model = new MenuModel();
            $model->delete($_GET["id"]) ;
        }

        return [ "redirect" => "resto_menu" ] ;
    }

    public function  removeAjaxAction()
    {
        $userSession = new UserSession();
        if (!$userSession->isAdmin()) {
            $flashBag = new Flashbag();
            $flashBag->addMessage("Vous devez etre admin");
            $error = true;
            return ["redirect" => "resto_home"];
        }

        if (isset($_GET["id"]) && ctype_digit($_GET["id"]))
        {
            $model = new MenuModel() ;
            $model->delete($_GET["id"]);
        }

        return["jsonResponse"=>json_encode(true)];

    }

    public function updateAction()
    {
        $redirect=null;
        $menu=null;
        $menuPlats=null;

        $userSession = new UserSession();
        if (!$userSession->isAdmin()) {
            return ["redirect" => "resto_home"];
        }


        if(isset($_GET['id']) && ctype_digit($_GET["id"]))
        {
            $model = new MenuModel ();
            $menu = $model->find($_GET["id"]);
            if (!$menu)
            {
                return ["redirect" => "resto_menu"];
            }

            $menuPlats=$model->checkedPlats($_GET["id"]);



        }
        elseif(isset($_POST['title']))
        {

            $model = new MenuModel();
            $modelPlat = new PlatModel();

            $model->update($_POST["id"], $_POST['title'], $_POST['content'], $_POST['price_menu'], $_POST['startDate'], $_POST['endDate']);
            $oldPlats = $modelPlat->findOldPlats($_POST["id"]);

            if(!isset($_POST['products']))
            {
                $newPlats=[];
            }
            else
            {
                $newPlats=$_POST['products'];
            }

            $deletePlats = array_diff($oldPlats,$newPlats);
            $addPlats = array_diff($newPlats,$oldPlats);
            $modelPlat ->deleteOldPlats($deletePlats,$_POST["id"]);
            $model->addPlatToMenu($_POST["id"],$addPlats);
            $redirect="resto_menu";
        }
        else
        {
            $redirect ="resto_menu";
        }

        return [
            'template'=>[
                'folder'=>"Menu",
                "file"=>'menuUpdate',
            ],
            "title"=>"Modifier les menus",
            "redirect"=>$redirect,
            "menu"=>$menu,
            "menuPlats"=>$menuPlats

        ];

    }
}