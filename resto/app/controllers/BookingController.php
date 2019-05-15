<?php


class BookingController
{
    private $seatMax = 80;
    public $seatDispo=0;

    public function createAction()
    {

        $userSession = new UserSession();
        $flashBag = new Flashbag();
        if(!$userSession->isAuthenticated())
        {
            $flashBag->addMessage("Veuillez vous connecter pour réserver une table") ;
            return ["redirect" => "resto_user_login"];
        }


        if($_POST) {
            $error = false;
            if (!isset($_POST['place']) || (trim($_POST["place"])) == "") {

                $flashBag->addMessage("Veuillez entrer le nombre de client");
                $error = true;

            }
            if (!isset($_POST['date']) || (trim($_POST["date"])) == "") {

                $flashBag->addMessage("Veuillez entrer la date");
                $error = true;

            }
//            if($_POST['date']) {
//                $endTab = explode('-', ($_POST['date']));
//                $end = mktime(0, 0, 0, $endTab[1], $endTab[2], $endTab[0]);
//                $now = mktime(0, 0, 0, date('n'), date('j'), date('y'));
//
//                if ($now > $end) {
//                    $flashBag->addMessage("la date que vous avez entrer est depassée");
//                    $error = true;
//
//                }
//            }
            if ($error) {

                return ["redirect" => "resto_booking"];
            } else {

                $userId = $userSession->getId();
                $model = new BookingModel();

                $seatTaken = $model->findByDateAndService($_POST['date'], $_POST['service']);


                $this->seatDispo = $this->seatMax - (intval($seatTaken) + intval($_POST['place']));
                if (($this->seatDispo) < 0) {
                    $flashBag = new Flashbag();
                    $flashBag->addMessage("pas assez de places disponible");
                } else {

                    $model->create($userId, $_POST['date'], $_POST['service'], $_POST['place']);


                    $flashBag = new Flashbag();
                    $flashBag->addMessage("Votre reservation a bien été enregistrée ! À bientôt!");

                }

             }
            }

        return[
            'template'=>[
                            'folder'=>"Booking",
                            "file"=>'create',
                          ],
            "title"=>'reservation',
        ];


    }




    public function showAction()
    {
        $redirect= null;

        $model =new UserModel();
        $allResa = $model->show();

        return [
            'template'=>['folder'=>"Booking",
                "file"=>'allBooking',
            ],
             "allResa"=>$allResa,
            "title"=>"reservation",
            "redirect" =>$redirect,
        ];
    }



}