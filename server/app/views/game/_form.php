<?php

// Важно сбросить ключи, чтобы номера начинались с 0
$platformInfoParamsArray = array_values($model->platformInfoParamsCollection->toArray());
$platformInfoParamsArrayCount = count($platformInfoParamsArray);

?>

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
                        foreach ($platformInfoParamsArray as $n => $platformInfoParams):
                    ?>
                        <div class="game-card_platform-info">
                            <?php foreach ($platformInfoParamsKeys as $key) {
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
                            ?>
                            <div class="game-card_platform-info-btn-panel">
                                <span class="game-card_platform-info-btn game-card_platform-info-btn_remove <?= $platformInfoParamsArrayCount === 1 ? 'game-card_platform-info-btn_hidden' : '' ?>">
                                    <span class="link link_crud-remove">
                                        <i class="fa fa-minus-circle"></i>
                                        <span href="#" class="link_text">Удалить</span>
                                    </span>
                                </span>

                                <span class="game-card_platform-info-btn game-card_platform-info-btn_add">
                                    <span class="link link_crud-add">
                                        <i class="fa fa-plus-circle"></i>
                                        <span class="link_text">Добавить</span>
                                    </span>
                                </span>
                            </div>
                            <hr>
                        </div>
                    <?php endforeach; ?>
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