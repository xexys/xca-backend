<?php

$mainParams = $gameParams->itemAt('mainParams');
$issuesInfoParams = $gameParams->itemAt('issuesInfoParams');

?>

<div class="row">
    <div class="col-md-8">
        <?php if ($mainParams): ?>
            <div class="section">
                <h4 class="section_header">Информация об игре</h4>
                <div class="section_content">
                    <?php
                    $this->renderPartial('_form/main-params', array(
                        'formWidget' => $formWidget,
                        'mainParams' => $mainParams,
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($issuesInfoParams): ?>
            <div class="section game-card_issues-info">
                <h4 class="section_header">Выход на платформах</h4>
                <div class="section_content">
                    <?php
                    $this->renderPartial('_form/issues-info-params', array(
                        'formWidget' => $formWidget,
                        'issuesInfoParams' => $issuesInfoParams,
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="section_content">
            <?= CHtml::image('?=' . PHP_EGG_LOGO_GUID); ?>
        </div>
    </div>
</div>

