<?php
class PlatController

{

    private  $allowedExtensions =[".jpg",".jpeg",".png"];

    public function showAllAction()

    {
        $model = new PlatModel();

        return [
            'template'=>[
                            'folder'=>"Plat",
                            "file"=>'showAll',

                         ],

            "title"=>"Tous nos plats",

            "allPlats"=>$model->findAll(),
            ];
    }

    public function showDetailAction()
    {
        if(isset($_GET['id']) && ctype_digit($_GET["id"]))
        {
            $model= new PlatModel();
            $plat= $model->find($_GET["id"]);
            $model = new MenuModel();
            $allMenu =$model->findMenuByPlate($_GET['id']);

            $allMenu =[];
            foreach ($allMenu as $menu)
            {
                $plat[$plat['plates_id']][] = [
                    "menu_id" => $menu['plates_id'],
                    "product" => $menu['product'],
                ] ;
            }


            return [
                'template'=>[
                    'folder'=>"Plat",
                    "file"=>'showDetail',

                ],
                "title"=>"Detail de nos plats",

                "plat"=>$plat,
                "allMenu"=>$allMenu


            ];
        }
        else
        {
            return [ "redirect" => "resto_plat_showAll" ] ;

        }

    }


    public function createAction()

    {
       $redirectURl=null;
        $error = false ;
        if($_POST) {
            $model = new PlatModel();
            $flashBag = new Flashbag();

            $userSession = new UserSession();
            if (!$userSession->isAdmin()) {
                $flashBag->addMessage("Vous devez etre admin");
                $error = true;

                return ["redirect" => "resto_home"];
            }

            if (!$userSession->isAuthenticated()) {
                $flashBag->addMessage("Vous devez etre enregistrer");
                $error = true;

                return ["redirect" => "resto_user_login"];
            }


            if (!isset($_POST['product']) || (trim($_POST["product"])) == "") {
                $flashBag->addMessage("Veuillez entrer le nom du plat");
                $error = true;

            }

            if (!isset($_POST['product_description']) || (trim($_POST["product_description"])) == "") {
                $flashBag->addMessage("Veuillez entrer la description du plat");
                $error = true;


            }
            if (!isset($_POST['ingredient']) || (trim($_POST["ingredient"])) == "") {
                $flashBag->addMessage("Veuillez entrer les ingredients");
                $error = true;


            }
            if (!isset($_POST['price']) || (trim($_POST["price"])) == "") {
                $flashBag->addMessage("Veuillez entrer le prix du plat");
                $error = true;


            }


            if ($error) {
                return ["redirect" => "resto_plat_add"];
            } else {
              $idPlat = $model->create($_POST['product'], $_POST['product_description'], $_POST['ingredient'], $_POST['price'], $_POST['photo']= null, $_POST['category']);


                if(isset($_FILES["photo"]) && $_FILES["photo"]["error"]>=0)
                {

                    $extension= (substr($_FILES['photo']['name'],
                        strpos($_FILES["photo"]["name"],'.',strlen($_FILES['photo']['name'])-5)));
                    if(in_array($extension,$this->allowedExtensions))
                    {


                        $filename = "plat_" . $idPlat . $extension;

                        $router = new Router();
                        $filePath = $router->getWwwPath(true)."/upload/photosPlats/";
                        move_uploaded_file($_FILES['photo']['tmp_name'],$filePath . $filename);
                        $model->updateImg($idPlat,$filename);
                    }
                }
                $flashBag = new Flashbag();
                $flashBag->addMessage("Plat crée avec succés");
                $redirectURl = "resto_plat_showAll";
            }

        }
            return [
                'template' => [
                    'folder' => "Plat",
                    "file" => 'addPlat',

                ],

                "title" => "ajouter des plats",
                "redirect" => $redirectURl

            ];



     // return ["redirect" => "resto_plat_showAll"];
    }



    public function updateAction()
    {
        $redirect=null;
        $plat=null;

        $userSession = new UserSession();
        if (!$userSession->isAdmin()) {
            $flashBag = new Flashbag();
            $flashBag->addMessage("Vous devez etre admin");
            $error = true;
            return ["redirect" => "resto_home"];
        }


        if(isset($_GET['id']) && ctype_digit($_GET["id"])) {
            $model = new PlatModel();

            $plat = $model->find($_GET["id"]);

            if (!$plat) {
                $redirect = "resto_plat_showAll";
            }
        }

        elseif(isset($_POST['product']))
        {
            $router = new Router();
            $model = new PlatModel();
             $model->update($_POST["id"], $_POST['product'], $_POST['product_description'], $_POST['ingredient'], $_POST['price'], $_POST['photo']=NULL, $_POST['category']);
            if(isset($_FILES["photo"]) && $_FILES["photo"]["size"] > 0 && $_FILES["photo"]['error']>= 0)
            {
                $plat = $model->find($_POST['id']) ;
                $filePath = $router->getWwwPath(true) . "/upload/photosPlats/";
                if($plat['photo'])
                {
                    $fileName = $plat['photo'];
                    $fullFilePath = $filePath . $fileName;
                    if (file_exists($fullFilePath)) {
                        unlink($fullFilePath);
                    }
                }

                $extension = substr($_FILES["photo"]["name"], strpos($_FILES["photo"]["name"],".",strlen($_FILES["photo"]["name"]-5)));

                if (in_array($extension,$this->allowedExtensions))
                {
                    $filename = "plat_".$_POST['id'].$extension;

                    move_uploaded_file($_FILES["photo"]["tmp_name"],$filePath.$filename);
                    $model->updateImg($_POST['id'],$filename);

                }


            }
            elseif(isset($_POST["img-suppr"]) && $_POST["img-suppr"])
            {
                //effacer l'image existance et mettre img dans la BDD à NULL
                $plat = $model->find($_POST['id']) ;
                $filePath = $router->getWwwPath(true)."/upload/photosPlats/" ;
                $fileName = $plat['photo'] ;
                $fullFilePath = $filePath.$fileName ;
                if(file_exists($fullFilePath))
                {
                    unlink($fullFilePath) ;
                }
                $model->updateImg($_POST['id'],NULL);
            }
            $redirect="resto_plat_showAll";
        }
        else
        {
            $redirect ="resto_plat_showAll";
        }

            return [
                'template'=>[
                    'folder'=>"Plat",
                    "file"=>'updatePlat',

                ],
                "title"=>"Modifier les plats",
                "redirect"=>$redirect,
                "plat"=>$plat,


            ];

    }

    public function removeAction()
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

            $model = new PlatModel();
            $model->remove($_GET["id"]) ;
        }

        return [ "redirect" => "resto_plat_showAll" ] ;
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
            $model = new PlatModel() ;
            $model->remove($_GET["id"]);
        }

        return["jsonResponse"=>json_encode(true)];

    }



}
