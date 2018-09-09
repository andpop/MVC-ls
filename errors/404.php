Ошибка 404 - запрошенная страница не найдена на сервере
<br>
<a href="/">Вернуться на сайт</a>
<br>
<?php if (defined('MODE') && MODE == 'dev') : ?>
Error: <br><pre>
<?php
echo 'line:'. $e->getLine()."<br>";
echo 'File:'. $e->getFile() . "<br>";
echo $e->getMessage()."<br>";
echo $e->getTraceAsString();

endif;