<div class="game-card_section">
    <div class="row">
        <div class="col-md-6">
            <div class="game-card_section">
                <div>
                    <?php
                    $this->renderPartial('_form/main-params', array(
                        'formWidget' => $formWidget,
                        'mainParams' => $gameParams->itemAt('mainParams'),
                    ));
                    ?>
                </div>
            </div>
            <div class="game-card_section">
                <h4 class="game-card_title">Выход на платформах</h4>
                <div class="game-card_platforms-info">
                    <?php
                    $this->renderPartial('_form/platforms-info-params', array(
                        'formWidget' => $formWidget,
                        'platformsInfoParams' => $gameParams->itemAt('platformsInfoParams'),
                    ));
                    ?>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="game-card_picture">
                <?= CHtml::image('?=' . PHP_EGG_LOGO_GUID); ?>
            </div>
        </div>
    </div>
</div>
