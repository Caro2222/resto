<?php
class HomeController
{
    public function mainAction()
    {

        return [
            'template' => ['folder' => "Home",
                "file" => 'home',
            ],
            "title" => "Au petit resto",
            ];

    }
}