<?php
$this->beginContent('/layouts/base');
?>

    <h3 class="page_title">
        <?= $this->pageTitle; ?>

        <?php
            if ($this->pageTitleIconClass) {
                echo $this->getViewHelper('UI\Icon')->icon(array(
                    'htmlOptions' => array(
                        'class' => $this->pageTitleIconClass
                    )
                ));
            }
        ?>

    </h3>
    <hr>

<?= $content; ?>

<?php
$this->endContent();
