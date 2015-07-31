<?php

echo __FILE__;
echo '<br>';

?>

Вы должны авторизоваться!<br>
Имя пользователя: <?= $webUser->getName(); ?><br>
Роль: <?= $webUser->getRole() ?>
