<?php
$this->beginContent('/layouts/base');
?>

    <h3 class="page_title">
        <?= $this->pageTitle; ?>

        <?php if ($this->pageTitleIconClass): ?>
            <?= $this->getViewHelper('UI\Icon')->icon($this->pageTitleIconClass); ?>
        <?php endif; ?>

    </h3>
    <hr>

<?= $content; ?>

<?php
$this->endContent();
