<?php
namespace App\Controllers;

use App\Core\AController;
use App\Models\User as User;

class Users extends AController
{
    /**
     * Вывод начальной формы для выбора типа входа в систему (авторизация или регистрация)
     * @param $requestParameters
     */
    public function entrance($requestParameters)
    {
        $this->view->twigRender('entrance', []);
    }

    /**
     * Вывод формы для авторизации
     * @param $requestParameters
     */
    public function logon_form($requestParameters)
    {
        $this->view->twigRender('logon_form', []);
    }

    /**
     * Вывод формы для регистрации
     * @param $requestParameters
     */
    public function register_form($requestParameters)
    {
        $this->view->twigRender('register_form', []);
    }

    /**
     * Авторизация пользователя на сайте
     * @param $requestParameters
     */
    public function authorization($requestParameters)
    {
        echo "Попытка авторизации: user={$requestParameters['login']}, password={$requestParameters['password']}";

    }

    /**
     * Регистраация пользователя на сайте
     * @param $params
     */
    public function registration($params)
    {
        echo "Попытка регистрации: user={$params['login']}, password={$params['password']}";
        $user = User::createUser($params['login'], $params['name'], $params['password'], $params['age'], $params['description']);
    }

    public function save()
    {
        echo "Saving user \n";
        $this->view->twigRender('test', ['test' => 'asd', 'isTest' => true]);
    }
}