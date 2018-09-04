<?php
namespace App\Controllers;

use App\Core\AController;

class Users extends AController
{

    public function save()
    {
        echo "Saving user \n";
        $this->view->twigRender('test', ['test' => 'asd', 'isTest' => true]);
    }
}