<div class="row">
    <div class="col-md-6">
        <div class="movie-card_section">
            <?php
            $this->renderPartial('_form/main-params', array(
                'formWidget' => $formWidget,
                'mainParams' => $movieParams->itemAt('mainParams'),
            ));
            ?>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры файла</h4>
            <div>
                <?php
                $this->renderPartial('_form/file-params', array(
                    'formWidget' => $formWidget,
                    'fileParams' => $movieParams->itemAt('fileParams'),
                ));
                ?>
            </div>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры видео</h4>
            <div class="">
                <?php
                $this->renderPartial('_form/video-params', array(
                    'formWidget' => $formWidget,
                    'videoParams' => $movieParams->itemAt('videoParams'),
                ));
                ?>
            </div>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры звука</h4>
            <div class="">
                <?php
                    $audioParams = $movieParams->itemAt('audioParams');
                    $audioParamsKeys = $audioParams->getFormKeys();
                    // Важно сбросить ключи, чтобы номера начинались с 0
                    $audioParamsItems = array_values($audioParams->items->toArray());
                    $audioParamsItemsCount = count($audioParamsItems);

                    foreach ($audioParamsItems as $n => $audioParamsItem) {
                        $this->renderPartial('_form/audio-params', array(
                            'formWidget' => $formWidget,
                            'params' => $audioParamsItem,
                            'paramsKeys' => $audioParamsKeys,
                            'paramsItemIndex' => $n,
                            'isHideRemoveBtn' => $audioParamsItemsCount === 1,
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>
