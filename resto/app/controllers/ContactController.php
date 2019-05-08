<?php
class ContactController
{
    public function mainAction()
    {

        return [
            'template' => ['folder' => "Contact",
                "file" => 'contact',
            ],
            "title" => "Au petit resto",
           ];

    }
}