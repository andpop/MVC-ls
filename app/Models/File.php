<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = ['user_id', 'file_path'];

    /**
     * Добавляет информацию о загруженном файле и пользоателе, который его загрузил
     * @param $userId
     * @param $filePath
     * @return mixed
     */
    public static function add($userId, $filePath)
    {
        $file = File::create([
            'user_id' => $userId,
            'file_path' => $filePath
        ]);
        return $file;
    }

    /**
     * Возвращает массив с информацие о файлах, загруженных пользователем с идентификатором $userId
     * @param $userId
     * @return mixed
     */
    public static function getByUserId($userId)
    {
        $files = File::where('user_id', '=', $userId)->get()->toArray();
        return $files;
    }

}
