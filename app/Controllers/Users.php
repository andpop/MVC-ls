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
     * @param $parameters
     */
    public function register_form($parameters)
    {
        $this->view->twigRender('register_form', []);
    }

    /**
     * Авторизация пользователя на сайте
     * @param $parameters
     */
    public function authorization($parameters)
    {
        $login = $parameters['login'];
        $password = $parameters['password'];
        $isAuthorized = true;
        if (!User::isUserExists($login)) {
            $isAuthorized = false;
        };
        $passwordinDB = User::getUserPassword($login);
        if ($passwordinDB != $password) {
            $isAuthorized = false;
        }
        if ($isAuthorized) {
            $this->showProfile($login);
        } else {
            $this->view->twigRender('authorization_error', []);
        };
    }

    /**
     * Регистраация пользователя на сайте
     * @param $params
     */
    public function registration($params)
    {
        $login = $params['login'];
        if (User::isUserExists($login)) {
            $message = "Пользователь <b>{$login}</b> уже зарегистрирован в системе, выберите другой логин.";
            $this->view->twigRender('registration_error', ['message' => $message]);
            return;
        };
        $user = User::createUser($params['login'], $params['name'], $params['password'], $params['age'], $params['description']);
        if ($user) {
            $this->view->twigRender('registration_success', ['login' => $login]);
        } else {
            $message = "При регистрации пользователя <b>{$login}</b> возникла ошибка.";
            $this->view->twigRender('registration_error', ['message' => $message]);
        };
    }

    protected function showProfile($login)
    {
        $user = User::getUserByLogin($login);
        $name = $user->name;
        $age = $user->age;
        $description = $user->description;
        $userId = $user->id;

        $this->view->twigRender('user_profile', ['id' => $userId, 'login' => $login, 'name' => $name, 'age' => $age, 'description' => $description]);
//        echo "Пользователь $login, $name успешно авторизован";
    }

}