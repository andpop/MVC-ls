<?php
function checkImageFile($filename)
{
    $contentType = substr(mime_content_type($filename), 0, 5);
    return ($contentType == 'image');
}
