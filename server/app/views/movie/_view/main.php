<div class="section">

    <h4 class="section_header">Информация о ролике</h4>

    <div class="section_content">
        <? foreach ($movie->attributes as $key => $val): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $movie->getAttributeLabel($key); ?>
                </div>
                <div class="col-md-9">
                    <?= $val; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>

</div>