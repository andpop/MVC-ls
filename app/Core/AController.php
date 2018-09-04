<?php
namespace App\Core;

class AController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

}