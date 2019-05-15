<?php


class Router
{
    private  $rootURl="/php/resto/index.php";
    private  $wwwPath="/php/resto/www";
    private $allUrls=[];
    private $localHostPath = ABSOLUTE_ROOT_PATH;


    private $allRoutes=
                [
                    "/"
                    =>[
                        "controller"=>"Home",
                        "method"=>"main",
                        "name"=>'resto_home'
                    ],

                    "/user/inscription"
                    =>[
                        "controller"=>"User",
                        "method"=>"signUp",
                        "name"=>'resto_user_inscription'
                    ],

                    "/user/profil"
                    =>[
                        "controller"=>"User",
                        "method"=>"showByUser",
                        "name"=>'resto_user_profil'
                    ],
                    "/user/login"
                    =>[
                        "controller"=>"User",
                        "method"=>"login",
                        "name"=>'resto_user_login'
                    ],

                    "/user/logout"
                    =>[
                        "controller"=>"User",
                        "method"=>"logout",
                        "name"=>'resto_user_logout'
                    ],

                    "/user/cancelled"
                    =>[
                        "controller"=>"User",
                        "method"=>"updateCancelled",
                        "name"=>'resto_user_update'
                    ],



                    "/contact"
                    =>[
                        "controller"=>"Contact",
                        "method"=>"main",
                        "name"=>'resto_contact'
                    ],

                    "/plat"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"showAll",
                        "name"=>"resto_plat_showAll"
                    ],

                    "/plat/detail"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"showDetail",
                        "name"=>'resto_plat_detail',

                    ],

                    "/plat/add"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"create",
                        "name"=>'resto_plat_add',

                    ],
                    "/plat/remove-ajax"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"removeAjax",
                        "name"=>'resto_plat_removeAjax',

                    ],
                    "/plat/remove"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"remove",
                        "name"=>'resto_plat_remove',

                    ],



                    "/plat/update"
                    =>[
                        "controller"=>"Plat",
                        "method"=>"update",
                        "name"=>'resto_plat_update',

                    ],


                    "/booking"
                    =>[
                        "controller"=>"Booking",
                        "method"=>"create",
                        "name"=>'resto_booking',

                    ],
                    "/booking/allBooking"
                    =>[
                        "controller"=>"Booking",
                        "method"=>"show",
                        "name"=>'resto_booking_all',

                    ],


                    "/menu"
                    =>[
                        "controller"=>"Menu",
                        "method"=>"showAll",
                        "name"=>'resto_menu',

                            ],

                    "/menu/update"
                    =>[
                        "controller"=>"Menu",
                        "method"=>"update",
                        "name"=>'resto_menu_update',

                    ],

                    "/menu/add"
                    =>[
                        "controller"=>"Menu",
                        "method"=>"create",
                        "name"=>'resto_menu_create',

                    ],
                "/menu/delete"
                =>[
                    "controller"=>"Menu",
                    "method"=>"delete",
                    "name"=>'resto_menu_delete',

                ],
                "/menu/removeAjax"
                =>[
                    "controller"=>"Menu",
                    "method"=>"removeAjax",
                    "name"=>'resto_menu_remove',

                    ],
                "/menu/showOne"
                =>[
                    "controller"=>"Menu",
                    "method"=>"showOne",
                    "name"=>'resto_menu_showOne',

                ],

                    "/reviews"
                    =>[
                        "controller"=>"Reviews",
                        "method"=>"show",
                        "name"=>'resto_reviews',

                    ],

                    "/reviews/create"
                    =>[
                        "controller"=>"Reviews",
                        "method"=>"create",
                        "name"=>'resto_reviews_create',

                    ],


                    "/user/cart"
                    =>[
                        "controller"=>"User",
                        "method"=>"removeCart",
                        "name"=>'resto_remove_cart',

                    ],

                    "/mon-panier"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "showAllByUser",
                        "name"       => "resto_order_showAll",
                    ],
                    "/order/ajouter"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "addOrderLine",
                        "name"       => "resto_order_add",
                    ],
                    "/order/update-item-quantity"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "updateItemQuantity",
                        "name"       => "resto_order_updateItemQuantity",
                    ],
                    "/order/remove-item"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "removeItem",
                        "name"       => "resto_order_removeItem",
                    ],
                    "/order/empty-basket"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "emptyBasket",
                        "name"       => "resto_order_emptyBasket",
                    ],
                    "/order/confirm"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "confirmBasket",
                        "name"       => "resto_order_confirmBasket",
                    ],
                    "/order/confirmByUser"
                    => [
                        "controller" => "Order", //Menus
                        "method"     => "confirmByUser",
                        "name"       => "resto_profil",
                    ],





                ];

    public function __construct()
    {
        $nbrSlashes =substr_count($this->rootURl,"/");
        $this->localHostPath=dirname($this->localHostPath,$nbrSlashes-1);
        foreach ($this->allRoutes as $url=>$route)
        {
            $this->allUrls[$route["name"]]=
                ["url"=>$url,
                    "route"=>["controller"=>$route['controller'],
                             "method"=>$route["method"]
                             ]
                ];
        }
    }

    public function getRoute($requestedPath)
    {
        if(isset($this->allRoutes[$requestedPath]))
        {
            return $this->allRoutes[$requestedPath];
        }
        // a renplacé par des execptions
        die("Erreurs url inconnu");
    }

    public function getWwwPath($absolute=false)
    {
        if($absolute)
        {
            return realpath($this->localHostPath.$this->wwwPath);
        }
        else {
            return $this->wwwPath;
        }

    }

    public function generatePath($routeName)
    {

       return $this->rootURl.$this->allUrls[$routeName]["url"];
    }
}