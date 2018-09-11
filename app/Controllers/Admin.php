<?php
namespace App\Controllers;

use App\Core\AController;
use App\Models\User;

class Admin extends AController
{
    /**
     * Админ-панель для управления пользователями.
     * Порядок сортировки по возрасту задается GET-параметром (sort_age=asc/desc)
     */
    public function users()
    {
        // По умолчанию сортируем по возрастанию
        $sortAge = 'asc';
        if (isset($_GET['sort_age']) && strtolower($_GET['sort_age']) == 'desc') {
            $sortAge = 'desc';
        }
        $users = User::getUsersSortByAge($sortAge);

        $this->view->twigRender('admin', ['users' => $users]);
    }

    /**
     * Вывод формы для редактирования данных пользователя.
     * Id пользователя приходит в GET-параметре
     */
    public function edit_user()
    {
        $id = (int)$_GET['id'];
        $user = User::find($id)->toArray();
        $data = array_merge($user, ['message' => '']);
        $this->view->twigRender('edit_user_form', ['data' => $data]);
    }

    /**
     * Вывод формы для ввода нового пользователя.
     */
    public function new_user()
    {
        $this->view->twigRender('register_form', []);
    }

    /**
     * Сохранение в БД данных о существующем пользователе.
     * Данные приходят из формы в POST-параметрах
     */
    public function save_user()
    {
        $id = (int)$_POST['id'];
        $user = User::find($id);
        if (!$user) {
            $message = "Идентификатор пользователя не найден в базе данных.";
            $this->view->twigRender('edit_profile_error', ['message' => $message]);
            return;
        };

        if (!User::checkLoginUnique($id, $_POST['login'])) {
            $message = "Логин {$_POST['login']} уже есть в базе.";
            $this->view->twigRender('edit_profile_error', ['message' => $message]);
            return;
        }
        if (!User::checkEmailUnique($id, $_POST['email'])) {
            $message = "Почтовый ящик {$_POST['email']} уже зарегистрирован в системе.";
            $this->view->twigRender('edit_profile_error', ['message' => $message]);
            return;
        }

        if (!empty($_POST['login'])) {
            $user->login = $_POST['login'];
        };
        if (!empty($_POST['name'])) {
            $user->name = $_POST['name'];
        };
        if (!empty($_POST['email'])) {
            $user->email = $_POST['email'];
        };
        if (!empty($_POST['age'])) {
            $user->age = $_POST['age'];
        };
        if (!empty($_POST['description'])) {
            $user->age = $_POST['age'];
        };


        $user->save();

        header("Location: {$_SERVER['HTTP_ORIGIN']}/admin/users");
    }
}
