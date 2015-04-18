<?php
$letters = array_merge(array('0-9'), range('A', 'Z'), array('А-Я'));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xexys cinematic archive - tmpl</title>
    <link href="css/cssreset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div class="inner">
            <div id="logo">
                <h1><a href="index.php">Xexys cinematic archive</a></h1>
            </div>
        </div>
    </div>
    <div id="top-movies">
        <div class="inner">
            <img src="img/1.jpg">
            <img src="img/2.jpg">
            <img src="img/3.jpg">
            <img src="img/4.jpg">
            <img src="img/5.jpg">
            <img src="img/6.jpg">
            <img src="img/7.jpg">
        </div>
    </div>
    <div class="inner clearfix">
        <div id="sidebar">
            <ul>
                <li class="item">
                    <h2 class="title">Меню</h2>
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="games.php">Все игры</a></li>
                        <li><a href="#">Тор 100</a></li>
                        <li><a href="#">О сайте</a></li>
                    </ul>
                </li>
                <li class="item clearfix">
                    <h2 class="title">По алфавиту</h2>
                    <ul class="fleft">
                    <?php foreach ($letters as $letter): ?>
                        <li><a href="games.php"><?= $letter ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </li>
                <li class="item clearfix">
                    <h2 class="title">По годам</h2>
                    <ul class="fleft">
                    <?php foreach (range(1998, 2014) as $year): ?>
                        <li><a href="games.php"><?= $year ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </li>
            </ul>


        </div>
        <div id="content">