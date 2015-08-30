<?php

$cssHelper = $this->getViewUIHelper('Css');
$linkHelper = $this->getViewUIHelper('Link');

?>

<div class="game-card_platform-info">
    <?php if ($paramsItemIndex !== 0): ?>
        <hr>
    <?php endif; ?>

    <?php foreach ($paramsKeys as $key) {
        $cssClass = 'game-card_platform-info-param_' . $cssHelper->fixCssName($key);
        $name = '[' . $paramsItemIndex . ']' . $key;
        $placeholder = $params->getAttributeLabel($key);

        if (in_array($key, array('platformId', 'issueStatusId'))) {
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
                    'class' => $cssClass,
                    'rows' => 3,
                )
            ));
            echo $formWidget->textAreaGroup($params, $name, $options);
        }
    }
    ?>

    <div class="game-card_platform-info-btn-panel">
        <span class="game-card_platform-info-btn game-card_platform-info-btn_remove <?= $isHideRemoveBtn ? 'game-card_platform-info-btn_hidden' : '' ?>">
            <?= $linkHelper->crudRemoveLink(array('label' => 'Удалить')); ?>
        </span>

        <span class="game-card_platform-info-btn game-card_platform-info-btn_add">
            <?= $linkHelper->crudAddLink(array('label' => 'Добавить')); ?>
        </span>
    </div>
</div>
