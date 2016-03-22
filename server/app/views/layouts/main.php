<?php
$this->beginContent('/layouts/base');
?>

    <h3 class="page_title">
        <?= $this->pageTitle; ?>

        <!-- X-TODO: Сделать через clip c html разметкой-->
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
