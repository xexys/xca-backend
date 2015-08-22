<div class="game-card_platform-info">
    <?php if ($paramsItemIndex !== 0): ?>
        <hr>
    <?php endif; ?>

    <?php foreach ($paramsKeys as $key) {
        $cssClass = 'game-card_platform-info-param_' . $params->fixCssName($key);
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
            <span class="link link_crud-remove">
                <i class="fa fa-minus-circle"></i>
                <span class="link_text">Удалить</span>
            </span>
        </span>

        <span class="game-card_platform-info-btn game-card_platform-info-btn_add">
            <span class="link link_crud-add">
                <i class="fa fa-plus-circle"></i>
                <span class="link_text">Добавить</span>
            </span>
        </span>
    </div>
</div>
