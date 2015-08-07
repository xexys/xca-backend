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
                <h4 class="game-card_title">Выход игры на платформах</h4>
                <div>
                    <?php
                    $platformInfoParamsKeys = $model->getPlatformInfoParamsKeys();
                    foreach ($model->platformInfoParamsArray as $n => $platformInfoParams) {
                        foreach ($platformInfoParamsKeys as $key) {
                            $cssClass = 'game-card_platform-info-param_' . $model->fixCssName($key);
                            $name = '[' . $n . ']' . $key;
                            $placeholder = $platformInfoParams->getAttributeLabel($key);

                            if (in_array($key, array('platformId', 'status'))) {
                                $options = array('widgetOptions' => array(
                                    'data'=> $platformInfoParams->getDictionary($key),
                                    'htmlOptions'=>array(
                                        'placeholder' => $placeholder,
                                        'class' => $cssClass,
                                    )
                                ));
                                echo $form->dropDownListGroup($platformInfoParams, $name, $options);
                            } else {
                                $options = array('widgetOptions' => array(
                                    'htmlOptions'=>array(
                                        'autocomplete' => 'off',
                                        'placeholder' => $placeholder,
                                        'class' => $cssClass,
                                        'rows' => 3,
                                    )
                                ));
                                echo $form->textAreaGroup($platformInfoParams, $name, $options);
                            }
                        }
                        echo '<hr>';
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