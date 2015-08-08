<script type="text/x-template" id="game-card_platform-info-template">
<?php

//dd($form);

$platformInfoParams = new \app\models\Form\Game\PlatformInfoParams;
$platformInfoParamsKeys = $platformInfoParams->getSafeAttributeNames();
$n = 'xxxxx';

$formCssId = $form->htmlOptions['id'];

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
        <span class="game-card_platform-info-btn game-card_platform-info-btn_add">
            <span class="link link_crud-add">
                <i class="fa fa-plus-circle"></i>
                <span class="link_text">Добавить</span>
            </span>
        </span>

        <span class="game-card_platform-info-btn game-card_platform-info-btn_remove">
            <span class="link link_crud-remove">
                <i class="fa fa-plus-circle"></i>
                <span href="#" class="link_text">Удалить</span>
            </span>
        </span>
    </div>
    <hr>
</div>

</script>
