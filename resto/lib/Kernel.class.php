<?php


class Kernel
{
    private $applicationPath = "app";
    private $controllerPath = "app/controllers/";
    private $modelPath ="app/models/";
    private $viewPath="www/views/";
    private $viewData;

    public function __construct()
    {
        $this->viewData=["variable"=>[]];
    }

    public function bootstrap()
    {
        spl_autoload_register([$this,"loadClass"]);
        error_reporting(E_ALL);
        set_error_handler(function($code,$message,$filename,$lineNumber)
        {
          throw new ErrorException($message,$code,1,$filename,$lineNumber);
        });
        return $this;
    }




    public function loadClass($class)
    {
        if(substr($class,-10)== "Controller")
        {
            $filename=$this->controllerPath.$class.".php";
        }
        elseif(substr($class,-5)== "Model")
        {
            $filename=$this->modelPath.$class.".php";
        }
        else
        {
            $filename=$this->applicationPath."/class/".$class.".php";
        }
        if(file_exists($filename))
        {
            include $filename;
        }
        else{
            die("le dossier <strong>".$filename."</strong> n'exite pas");
        }
    }


    public function run()
    {
        $requestedPath= $_SERVER['PATH_INFO'];
        if($requestedPath)
        {

            $router = new Router();
            $requestedRoute= $router->getRoute($requestedPath);
            $controllerName=$requestedRoute["controller"]."Controller";
            $controller = new $controllerName();


            $methodName= $requestedRoute["method"]."Action";
            if(method_exists($controller,$methodName))
            {
                $this->viewData["variable"]["router"]=$router;

                $this->viewData['variable']=
                    array_merge((array) $this->viewData['variable'],
                        (array)$controller->$methodName());
                $this->renderResponse();
            }
            else{
                die("erreur: ".$methodName." introuvable dans ".$controllerName );
            }
        }
    }

    public function renderResponse()
    {
        if(isset($this->viewData["variable"]["redirect"]))
        {
            $redirectUrl=$this->viewData["variable"]["router"]->generatePath($this->viewData["variable"]["redirect"]);
            header("Location:".$redirectUrl);
            exit();
        }
        //si template
        elseif (isset($this->viewData['variable']['template']))
        {
            $templatePath = $this->viewPath;
            $templatePath.= $this->viewData['variable']['template']['folder']."/";
            $templatePath.= $this->viewData['variable']['template']['file'];
            $templatePath.= 'View.phtml';
            extract($this->viewData["variable"],EXTR_OVERWRITE);
            if (isset($this->viewData['variable']['template']['_raw']))
            {
                include $templatePath;
            }
            else
            {

                $flashBag= new Flashbag();
                $userSession = new UserSession();
                include $this->viewPath."LayoutView.phtml";

            }

        }

        elseif (isset($this->viewData['variable']['jsonResponse'])) {
                echo $this->viewData['variable']['jsonResponse'];
            }

    }

    public function renderError($errorMessage)
    {
        extract($this->viewData["variable"],EXTR_OVERWRITE);
        include "errorView.phtml";
        die();
    }

}