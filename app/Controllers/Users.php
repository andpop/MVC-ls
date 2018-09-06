<?php
namespace App\Controllers;

use App\Core\AController;
use App\Models\User as User;

class Users extends AController
{
    /**
     * Вывод начальной формы для выбора типа входа в систему (авторизация или регистрация)
     */
    public function entrance()
    {
        $this->view->twigRender('entrance', []);
    }

    /**
     * Вывод формы для авторизации
     */
    public function logon_form()
    {
        $this->view->twigRender('logon_form', []);
    }

    /**
     * Вывод формы для регистрации
     */
    public function register_form()
    {
        $this->view->twigRender('register_form', []);
    }

    /**
     * Авторизация пользователя на сайте
     * @param $parameters
     */
    public function authorization()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $isAuthorized = true;
        if (!User::isExists($login)) {
            $isAuthorized = false;
        };
        $passwordinDB = User::getUserPassword($login);
        if ($passwordinDB != $password) {
            $isAuthorized = false;
        }
        if ($isAuthorized) {
            header('Location: http://mvc/users/profile?login='.$login);
            die();

            $this->showProfile($login);
        } else {
            $this->view->twigRender('authorization_error', []);
        };
    }

    /**
     * Регистрация пользователя на сайте
     * @param $params
     */
    public function registration()
    {
        $login = $_POST['login'];
        if (User::isExists($login)) {
            $message = "Пользователь {$login} уже зарегистрирован в системе, выберите другой логин.";
            $this->view->twigRender('registration_error', ['message' => $message]);
            return;
        };

        $avatar = 'NO_AVATAR';
        if (isset($_FILES) && $_FILES['avatar_file']['error'] == 0) {
//            TODO Нужно добавить проверку типа загружаемого файла - только картинки
            $avatarPath = APPLICATION_PATH . AVATAR_DIR . $_FILES['avatar_file']['name'];
            $avatar = AVATAR_DIR . $_FILES['avatar_file']['name'];
            move_uploaded_file($_FILES['avatar_file']['tmp_name'], $avatarPath);
        };
        $user = User::createUser($_POST['login'], $_POST['password'], $_POST['name'], $_POST['age'], $_POST['description'], $avatar);
        if ($user) {
            $this->view->twigRender('registration_success', ['login' => $login]);
        } else {
            $message = "При регистрации пользователя {$login} возникла ошибка.";
            $this->view->twigRender('registration_error', ['message' => $message]);
        };
    }

    /**
     * Вывод формы с профилем пользователя
     * Логин пользователя передается через GET-параметр login
     */
    public function profile()
    {
        $login = $_GET['login'];
        $user = User::getByLogin($login);
        $name = $user->name;
        $age = $user->age;
        $description = $user->description;
        $userId = $user->id;
        $avatarPath = '/' . $user->avatar_path;

        $this->view->twigRender(
            'user_profile',
            [
                'id' => $userId,
                'login' => $login,
                'name' => $name,
                'age' => $age,
                'description' => $description,
                'avatar_path' => $avatarPath
            ]
        );

    }

}