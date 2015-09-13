<?php

$uiHelper = $this->getViewHelper('UI');
$btnHelper = $uiHelper->getButtonHelper();
$iconHelper = $uiHelper->getIconHelper();
$linkHelper = $uiHelper->getLinkHelper();

$gameLinkHelper = $this->getViewModelLinkHelper('Game');

$editGamePlatformsInfoUrl = $gameLinkHelper->getEditPlatformsInfoUrl($game);

$statusIcons = array(

)

?>

<div class="section game-card_platforms-info">

    <span class="section_edit-btn">
        <?= $btnHelper->linkButton(array('label' => '', 'gl-icon' => 'pencil', 'context' => 'default', 'size'=>'small', 'url' => $editGamePlatformsInfoUrl)); ?>
<!--        --><?//= $linkHelper->crudEditLink(array('label' => 'Редактировать', 'url' => $editGamePlatformsInfoUrl)); ?>
    </span>

    <h4 class="section_header">Выход на платформах</h4>
    <div class="section_content">
        <? foreach ($game->platformsInfo as $platformInfo): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $platformInfo->platform->full_name; ?>
                </div>
                <div class="col-md-1">
                    <span class="game-card_platform-info-status-icon">
                        <?= $iconHelper->gameIssueStatusIcon($platformInfo->issue_status_id, array(
                            'data-toggle'=> 'tooltip',
                            'title' => $platformInfo->issueStatus->name
                            ));
                        ?>
                    </span>
                </div>
                <div class="col-md-8">
                    <?php if ($platformInfo->issue_date || $platformInfo->comment): ?>
                        <div class="game-card_platform-info-status-date">
                            <?= Yii::app()->getDateFormatter()->formatDateTime($platformInfo->issue_date, 'long', null); ?>
                        </div>
                        <div class="game-card_platform-info-status-comment">
                            <?= nl2br(Chtml::encode($platformInfo->comment)); ?>
                        </div>
                    <?php else: ?>
                        &mdash;
                    <?php endif; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>
