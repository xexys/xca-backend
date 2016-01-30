<?php

$cssHelper = $this->getViewUIHelper('Css');

?>

<div class="movie-file-card_audio">
    <?php if ($paramsItemIndex !== 0): ?>
        <hr>
    <?php endif; ?>

    <?php foreach ($paramsKeys as $key) {
        $cssClass = 'movie-file-card_audio-param_' . $cssHelper->fixCssName($key);
        $name = '[' . $paramsItemIndex . ']' . $key;
        $placeholder = $params->getAttributeLabel($key);

        if (in_array($key, array('formatId', 'bitRateMode', 'channels', 'languageId', 'sampleRate'))) {
            $options = array('widgetOptions' => array(
                'data'=> $params->getDictionary($key),
                'htmlOptions'=>array(
                    'placeholder' => $placeholder,
                    'class' => $cssClass,
                )
            ));
            echo $formWidget->dropDownListGroup($params, $name, $options);
        } else {
            $options = array('widgetOptions' => array(
                'htmlOptions'=>array(
                    'autocomplete' => 'off',
                    'placeholder' => $placeholder,
                    'class' => $cssClass
                )
            ));
            echo $formWidget->textFieldGroup($params, $name, $options);
        }
    }
    ?>
    <div class="movie-file-card_audio-btn-panel">
        <span class="movie-file-card_audio-btn movie-file-card_audio-btn_remove <?= $isHideRemoveBtn ? 'movie-file-card_audio-btn_hidden' : '' ?>">
            <span class="link link_crud-remove">
                <i class="fa fa-minus-circle"></i>
                <span class="link_text">Удалить</span>
            </span>
        </span>

        <span class="movie-file-card_audio-btn movie-file-card_audio-btn_add">
            <span class="link link_crud-add">
                <i class="fa fa-plus-circle"></i>
                <span class="link_text">Добавить</span>
            </span>
        </span>
    </div>
</div>
