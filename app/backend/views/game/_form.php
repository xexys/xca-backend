<div class="game-card_section">
    <div class="row">
        <div class="col-md-6">
            <h4 class="game-card_title">Информация об игре</h4>
            <div class="game-card_info">
                <?= $form->textFieldGroup($game, 'text_id'); ?>
                <?= $form->textFieldGroup($game, 'title'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="game-card_picture">
                <?= CHtml::image('?=' . PHP_EGG_LOGO_GUID); ?>
            </div>
        </div>
    </div>
</div>