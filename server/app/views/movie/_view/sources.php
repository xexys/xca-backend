<?php

$sourceFiles = array();

$createMovieSourceFileUrl = '#';

?>

<div class="section">

    <h4 class="section_header">Исходные файлы</h4>

    <div class="section_content">
        <?php if (!$sourceFiles): ?>
            <?= $linkHelper->crudAddLink(array('label' => 'Добавить файл', 'url' => $createMovieSourceFileUrl)); ?>
        <?php endif; ?>
    </div>
</div>