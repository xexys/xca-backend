<?php
$platformInfoParams = $model->createPlatformInfoParams();
$platformInfoParamsKeys = $model->getPlatformInfoParamsKeys();
$paramsArrayIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$template = $this->renderPartial('_platform-info-params', array(
    'form' => $form,
    'params' => $platformInfoParams,
    'paramsKeys' => $platformInfoParamsKeys,
    'paramsArrayIndex' => $paramsArrayIndex,
    'isHideRemoveBtn' => false
), true);

?>

<script type="text/x-template" id="game-card_platform-info-template" data-index-placeholder="<?= $paramsArrayIndex; ?>">
<?= $template ?>
</script>
