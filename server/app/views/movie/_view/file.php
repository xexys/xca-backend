<div class="section">

    <h4 class="section_header">Параметры файла</h4>

    <div class="section_content">
        <div class="row">
            <div class="col-md-3">Имя</div>
            <div class="col-md-9">
                <?= $file->name ?: '&mdash;' ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Формат</div>
            <div class="col-md-9">
                <?= $file->format->name; ?> (<?= strtoupper($file->format->extension) ?>)
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Размер</div>
            <div class="col-md-9">
                <?= $file->size ? $viewDataHelper->formatBytes($file->size) : '&mdash;'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">Продолжительность</div>
            <div class="col-md-9">
                <?= $file->duration ? $viewDataHelper->formatDuration($file->duration) : '&mdash;'; ?>
            </div>
        </div>
    </div>

</div>