<div class="section">

    <h4 class="section_header">Параметры видео</h4>

    <div class="section_content">
        <div class="row">
            <div class="col-md-3">Формат</div>
            <div class="col-md-9">
                <?= $viewDataHelper->getVideoFormatStr($video->format_id); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Разрешение</div>
            <div class="col-md-9">
                <?= $video->width; ?> х <?= $video->height; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">Битрейт</div>
            <div class="col-md-9">
                <?= $video->bit_rate; ?> Кбит
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Частота кадров</div>
            <div class="col-md-9">
                <?= $video->frame_rate; ?> (<?= $viewDataHelper->getVideoFrameRateModeStr($video->frame_rate_mode); ?>)
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Качество кадра</div>
            <div class="col-md-9">
                <?= $video->frame_quality; ?>
            </div>
        </div>
    </div>

</div>