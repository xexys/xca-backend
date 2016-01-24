<?php

$mainFile = null;

$createMovieMainFileUrl = '#';

?>

<div class="section">

    <h4 class="section_header">Основной файл</h4>

    <div class="section_content">
        <?php if (!$mainFile): ?>
            <?= $linkHelper->crudAddLink(array('label' => 'Добавить файл', 'url' => $createMovieMainFileUrl)); ?>

        <?php endif; ?>
    </div>
</div>