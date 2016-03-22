<div class="row">
    <div class="col-md-6">
        <div class="section">
            <h4 class="section_header">Информация о файле</h4>

            <?php
            $this->renderPartial('_form/info-params', array(
                'formWidget' => $formWidget,
                'infoParams' => $movieFileForm->itemAt('infoParams')
            ));
            ?>
        </div>

        <div class="section">
            <h4 class="section_header">Параметры файла</h4>

            <?php
            $this->renderPartial('_form/main-params', array(
                'formWidget' => $formWidget,
                'mainParams' => $movieFileForm->itemAt('mainParams')
            ));
            ?>
        </div>

        <div class="section">
            <h4 class="section_header">Параметры видео</h4>
            <?php
            $this->renderPartial('_form/video-params', array(
                'formWidget' => $formWidget,
                'videoParams' => $movieFileForm->itemAt('videoParams')
            ));
            ?>
        </div>

        <div class="section">
            <h4 class="section_header">Параметры аудио</h4>

            <?php
            $audioParams = $movieFileForm->itemAt('audioParams');

            // Важно сбросить ключи, чтобы номера начинались с 0
            $audioParamsItems = array_values($audioParams->items->toArray());
            $audioParamsItemsCount = count($audioParamsItems);

            foreach ($audioParamsItems as $n => $audioParamsItem) {
                $this->renderPartial('_form/audio-params', array(
                    'formWidget' => $formWidget,
                    'paramsItem' => $audioParamsItem,
                    'paramsItemIndex' => $n,
                    'hideRemoveBtn' => $audioParamsItemsCount === 1,
                ));
            }
            ?>
        </div>
    </div>
</div>
