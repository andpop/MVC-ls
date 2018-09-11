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
        $this->view->twigRender('logon_form', []);
    }

    /**
     * Вывод формы для регистрации
     * Если GET-параметр reg_type == user, то пользователь регистрируется самостоятельно (по умолчанию)
     * Если GET-параметр reg_type == admin, то пользователя заводит администратор

     */
    public function register_form()
    {
        $registrationType = 'user';
        if (isset($_GET['reg_type']) && $_GET['reg_type'] == 'admin') {
            $registrationType = 'admin';
        };

        $data = [];
        $data['message'] = '';
        $data['login'] = '';
        $data['name'] = '';
        $data['age'] = '';
        $data['description'] = '';
        $data['reg_type'] = $registrationType;

        $this->view->twigRender('register_form', $data);
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
     */
    public function authorization()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $isAuthorized = true;
        if (!User::loginExists($login)) {
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
     * Запись в БД данных из формы регистрации нового пользователя
     * Если GET-параметр reg_type == user, то пользователь регистрируется самостоятельно (по умолчанию)
     * Если GET-параметр reg_type == admin, то пользователя заводит администратор
     */
    public function registration()
    {
        $login = $_POST['login'];
        $email = $_POST['email'];
        if (User::loginExists($login)) {
            $message = "Пользователь {$login} уже зарегистрирован в системе, выберите другой логин.";
            $this->view->twigRender('registration_error', ['message' => $message]);
            return;
        };
        if (User::emailExists($email)) {
            $message = "Почтовый ящик {$email} уже зарегистрирован в системе, выберите другой email.";
            $this->view->twigRender('registration_error', ['message' => $message]);
            return;
        };

        $errorMessage = '';
        $isBadParameters = false;
        if (empty($_POST['login'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указан логин. ";
        };
        if (empty($_POST['name'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указано имя. ";
        };
        if (empty($_POST['email'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указан email. ";
        };
        if (empty($_POST['age'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указан возраст. ";
        };
        if ($_FILES['avatar_file']['tmp_name']) {
            if (!checkImageFile($_FILES['avatar_file']['tmp_name'])) {
                $isBadParameters = true;
                $errorMessage .= "Можно загружать только изображения. ";
            }
        };

        if ($isBadParameters) {
            $data = [];
            $data['status'] = 'VALIDATE_ERROR';
            $data['message'] = $errorMessage;
            $data['login'] = $_POST['login'];
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['age'] = $_POST['age'];
            $data['description'] = $_POST['description'];

            $this->view->twigRender('register_form', $data);
            return;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $description = $_POST['description'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $avatar = 'NO_AVATAR';
        if (isset($_FILES) && $_FILES['avatar_file']['error'] == 0) {
            $avatarPath = APPLICATION_PATH . AVATAR_DIR . $_FILES['avatar_file']['name'];
            $avatar = AVATAR_DIR . $_FILES['avatar_file']['name'];
            move_uploaded_file($_FILES['avatar_file']['tmp_name'], $avatarPath);
        };

        $user = User::createUser($login, $passwordHash, $name, $email, $age, $description, $avatar);

        $registrationType = 'user';

        if (isset($_GET['reg_type']) && $_GET['reg_type'] == 'admin') {
            $registrationType = 'admin';
        };

        if ($registrationType == 'admin') {
            header("Location: {$_SERVER['HTTP_ORIGIN']}/admin/users");
        };

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
        $data = [];
        $data['message'] = '';
        $data['id'] = $user->id;
        $data['login'] = $login;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['age'] = $user->age;
        $data['description'] = $user->description;
        $data['avatar_path'] = $user->avatar_path;

        $this->view->twigRender('user_profile', $data);
    }

    /**
     * Сохранение в БД данных из формы редактирования профиля пользователя
     */
    public function save_profile()
    {
        if (isset($_POST['id'])) {
            $userId = $_POST['id'];
        } else {
            $userId = 0;
        };

        $errorMessage = '';
        $isBadParameters = false;
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указан идентификатор пользователя. ";
        };
        if (!isset($_POST['login']) || empty($_POST['login'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указан логин. ";
        };
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указано имя. ";
        };
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указано имя. ";
        };
        if (!isset($_POST['age']) || empty($_POST['age'])) {
            $isBadParameters = true;
            $errorMessage .= "Не указано возраст. ";
        };
        if ($_FILES['avatar_file']['tmp_name']) {
            if (!checkImageFile($_FILES['avatar_file']['tmp_name'])) {
                $isBadParameters = true;
                $errorMessage .= "Можно загружать только изображения. ";
            }
        };
        $userWithEmail = User::getByEmail($_POST['email']);
        if ($userWithEmail && ($userWithEmail->id != $userId)) {
            $isBadParameters = true;
            $errorMessage .= "Почтовый ящик {$_POST['email']} уже зарегистрирован в системе, выберите другой email.";
        };

        if ($isBadParameters) {
            $data = [];
            $data['status'] = 'VALIDATE_ERROR';
            $data['error_message'] = $errorMessage;
            $data['info_message'] = '';
            $data['id'] = $_POST['id'];
            $data['login'] = $_POST['login'];
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['age'] = $_POST['age'];
            $data['description'] = $_POST['description'];

            $this->view->twigRender('user_profile', $data);
            return;
        };

        $isAvatarChanged = false;
        if (isset($_FILES) && $_FILES['avatar_file']['error'] == 0) {
            $avatarPath = APPLICATION_PATH . AVATAR_DIR . $_FILES['avatar_file']['name'];
            $avatar = AVATAR_DIR . $_FILES['avatar_file']['name'];
            move_uploaded_file($_FILES['avatar_file']['tmp_name'], $avatarPath);
            $isAvatarChanged = true;
        };

        $user = User::find($userId);
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->age = $_POST['age'];
        $user->description = $_POST['description'];
        if ($isAvatarChanged) {
            $user->avatar_path = $avatar;
        }
        $user->save();

        header("Location: {$_SERVER['HTTP_ORIGIN']}/users/profile?login={$_POST['login']}");
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
            $fileLink = '/img/' . $user->id . '/'. $_FILES['upload_file']['name'];
            $fileRecord = File::add($user->id, $fileLink);
        };

        header("Location: {$_SERVER['HTTP_ORIGIN']}/users/upload?login={$login}");
    }
}