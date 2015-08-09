<div class="game-card_section">
    <div class="row">
        <div class="col-md-6">
            <div class="game-card_section">
                <div>
                    <?php
                    foreach ($model->getMainParamsKeys() as $key) {
                        $cssClass = 'game-card_main-param_' . $model->fixCssName($key);
                        $options = array('widgetOptions' => array(
                            'htmlOptions'=>array(
                                'autocomplete' => 'off',
                                'class' => $cssClass
                            )
                        ));
                        echo $form->textFieldGroup($model->mainParams, $key, $options);
                    }
                    ?>
                </div>
            </div>
            <div class="game-card_section">
                <h4 class="game-card_title">Выход на платформах</h4>
                <div class="game-card_platforms-info">
                    <?php
                        $platformInfoParamsKeys = $model->getPlatformInfoParamsKeys();
                        // Важно сбросить ключи, чтобы номера начинались с 0
                        $platformInfoParamsArray = array_values($model->platformInfoParamsCollection->toArray());
                        $platformInfoParamsArrayCount = count($platformInfoParamsArray);

                        foreach ($platformInfoParamsArray as $n => $platformInfoParams) {
                            $this->renderPartial('_platform-info-params', array(
                                'form' => $form,
                                'params' => $platformInfoParams,
                                'paramsKeys' => $platformInfoParamsKeys,
                                'paramsArrayIndex' => $n,
                                'isHideRemoveBtn' => $platformInfoParamsArrayCount === 1,
                            ));
                        }
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