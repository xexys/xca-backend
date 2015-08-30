<div class="game-card_main-info">
    <h4 class="game-card_header">Информация об игре</h4>
    <div class="game-card_content">
        <? foreach ($game->attributes as $key => $val): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $game->getAttributeLabel($key); ?>
                </div>
                <div class="col-md-9">
                    <?= $val; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>
