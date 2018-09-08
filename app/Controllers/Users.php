<?php
namespace App\Controllers;

use App\Core\AController;
use App\Models\File;
use App\Models\User as User;

class Users extends AController
{
    /**
     * Проверка авторизованности пользователя по его логину
     * @param $login
     * @return bool
     */
    protected function checkRights($login)
    {
        return (isset($_SESSION['logged_user']) && $_SESSION['logged_user'] == $login);
    }

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
//        TODO Сделать сохранение введенных в форму значений при повторном открытии формы
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
     * Вывод меню для авторизованного пользователя. Логин передается через POST-параметер
     */
    public function menu()
    {
        $login = $_GET['login'];
        if (! $this->checkRights($login)) {
            $this->view->twigRender('rights_error', []);
            return;
        };

        $this->view->twigRender('menu', ['login' => $login]);
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
        } else {
            $passwordHash = User::getPasswordHash($login);
            if (!password_verify($password, $passwordHash)) {
                $isAuthorized = false;
            };
        };
        if ($isAuthorized) {
            $_SESSION['logged_user'] = $login;
            header("Location: {$_SERVER['HTTP_ORIGIN']}/users/menu?login={$login}");
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

//        TODO нужно сделать проверку на непустые значения атрибутов пользователя и очистить их
        $name = $_POST['name'];
        $age = $_POST['age'];
        $description = $_POST['description'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $avatar = 'NO_AVATAR';
        if (isset($_FILES) && $_FILES['avatar_file']['error'] == 0) {
//            TODO Нужно добавить проверку типа загружаемого файла - только картинки
            $avatarPath = APPLICATION_PATH . AVATAR_DIR . $_FILES['avatar_file']['name'];
            $avatar = AVATAR_DIR . $_FILES['avatar_file']['name'];
            move_uploaded_file($_FILES['avatar_file']['tmp_name'], $avatarPath);
//            TODO Нужно делать имя аватарки уникальным для пользователей - префиск с логином, например
        };

        $user = User::createUser($login, $passwordHash, $name, $age, $description, $avatar);
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
        if (! $this->checkRights($login)) {
            $this->view->twigRender('rights_error', []);
            return;
        };

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

    /**
     * Вывод формы для загрузки файлов пользователем и списка его загруженных файлов.
     * Логин пользователя передается GET-параметром.
     */
    public function upload()
    {
        $login = $_GET['login'];
        if (! $this->checkRights($login)) {
            $this->view->twigRender('rights_error', []);
            return;
        };

        $userId = User::getIdByLogin($login);
        $files = File::getByUserId($userId);

        $this->view->twigRender('upload_form', ['login' => $login, 'files' => $files]);
    }

    /**
     * Перемещение загруженного файла в каталог пользователя и запись информации о загруженном файле в таблицу file.
     */
    public function save_file()
    {
        $login = $_POST['login'];
        // Проверяем, на свою ли страницу заходит пользователь
        if (! $this->checkRights($login)) {
            $this->view->twigRender('rights_error', []);
            return;
        };

        $user = User::getByLogin($login);
        if (!$user) {
            return;
        };

//        Создаем каталог для файлов пользователя
        $imagePath = APPLICATION_PATH . 'img/' . $user->id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath);
        };
        //Копируем загруженный файл в каталог пользователя
        if (isset($_FILES) && $_FILES['upload_file']['error'] == 0) {
//            TODO Нужно добавить проверку типа загружаемого файла - только картинки
//            Так не работает
//            $isValidFile = \GUMP::is_valid($_FILES, array('upload_file' => 'required_file|extension,png;jpg'));
//            if (!$isValidFile) {
//                echo "ERROR!!!!!";
//                die();
//            }
            $uploadFilePath = $imagePath . '/' . $_FILES['upload_file']['name'];
            move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadFilePath);
            $fileLink = 'img/' . $user->id . '/'. $_FILES['upload_file']['name'];
            $fileRecord = File::add($user->id, $fileLink);
        };

        header("Location: {$_SERVER['HTTP_ORIGIN']}/users/upload?login={$login}");
    }
}