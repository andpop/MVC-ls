<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['login', 'password', 'name', 'email', 'age', 'avatar_path', 'description'];

    /**
     * Возвращает массив с информацией о всех пользователях
     * @return array
     */
    public static function getAllUsers()
    {
        $users = User::all()->toArray();
        return $users;
    }

    /**
     * Возвращает массив с информацией о всех пользователях с сортировкой по возрасту.
     * @param $typeSort - строка 'asc' или 'desc'
     * @return array
     */
    public static function getUsersSortByAge($typeSort)
    {
        if ($typeSort != 'asc' && $typeSort != 'desc') {
            $typeSort = 'asc';
        }
        $users = User::where('id', '>', 1)->orderBy('age', $typeSort)->get()->toArray();
        return $users;
    }

    /**
     * Создает нового пользователя в базе данных
     * @param $login
     * @param $password
     * @param $name
     * @param $email
     * @param $age
     * @param $description
     * @param $avatarPath
     * @return mixed
     */
    public static function createUser($login, $password, $name, $email, $age, $description, $avatarPath)
    {
        $user = User::create([
            'login' => $login,
            'password' => $password,
            'name' => $name,
            'email' => $email,
            'age' => $age,
            'description' => $description,
            'avatar_path' => $avatarPath
        ]);
        return $user;
    }

    /**
     * Возвращает объект-пользователя по его логину
     * @param $login
     * @return mixed
     */
    public static function getByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        return $user;
    }

    /**
     * Возвращает объект-пользователя по его email
     * @param $email
     * @return mixed
     */
    public static function getByEmail($email)
    {
        $user = User::where('email', '=', $email)->first();
        return $user;
    }

    /**
     * Возвращае id пользователя по его логину
     * @param $login
     * @return int
     */
    public static function getIdByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->id;
        } else {
            return 0;
        };
    }

    /**
     * Проверка существования логина в базе (для регистрации нового пользователя)
     * @param $login
     * @return bool
     */
    public static function loginExists($login)
    {
        $user = User::getByLogin($login);

        if ($user) return true;
        return false;
    }

    /**
     * Проверка существования email в базе (для регистрации нового пользователя)
     * @param $email
     * @return bool
     */
    public static function emailExists($email)
    {
        $user = User::getByEmail($email);

        if ($user) return true;
        return false;
    }

    public static function getPasswordHash($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->password;
        };
        return '';
    }

    /**
     * Проверка, является ли уникальным в БД логин пользователя с идентификатором $userId
     * @param $userId
     * @param $login
     * @return bool
     */
    public static function checkLoginUnique($userId, $login)
    {
        $user = User::where('login', '=', $login)
            ->where('id', '!=', $userId)
            ->first();
        if ($user) return false;
        return true;
    }
    /**
     * Проверка, является ли уникальным в БД email пользователя с идентификатором $userId
     * @param $userId
     * @param $email
     * @return bool
     */
    public static function checkEmailUnique($userId, $email)
    {
        $user = User::where('email', '=', $email)
            ->where('id', '!=', $userId)
            ->first();
        if ($user) return false;
        return true;
    }
}
