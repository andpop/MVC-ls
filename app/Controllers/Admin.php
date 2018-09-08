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
}
