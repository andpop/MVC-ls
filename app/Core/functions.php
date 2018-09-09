<?php

/**
 * Проверяем, является ли файл изображением
 * @param $filename - путь к проверяемому файлу
 * @return bool
 */
function checkImageFile($filename)
{
    $contentType = substr(mime_content_type($filename), 0, 5);
    return ($contentType == 'image');
}
