<?php

$uiHelper = $this->getViewHelper('UI');
$btnHelper = $uiHelper->getButtonHelper();
$iconHelper = $uiHelper->getIconHelper();
$linkHelper = $uiHelper->getLinkHelper();

$gameLinkHelper = $this->getViewModelLinkHelper('Game');

$getEditIssuesInfoUrl = $gameLinkHelper->getEditIssuesInfoUrl($game);

$statusIcons = array(

)

?>

<div class="section game-card_issues-info">

    <span class="section_edit-btn">
        <?= $btnHelper->linkButton(array('label' => '', 'gl-icon' => 'pencil', 'context' => 'default', 'size'=>'small', 'url' => $getEditIssuesInfoUrl)); ?>
<!--        --><?//= $linkHelper->crudEditLink(array('label' => 'Редактировать', 'url' => $getEditIssuesInfoUrl)); ?>
    </span>

    <h4 class="section_header">Выход на платформах</h4>
    <div class="section_content">
        <?php foreach ($game->issuesInfo as $issueInfo): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $issueInfo->platform->name; ?>
                </div>
                <div class="col-md-1">
                    <span class="game-card_issue-info-status-icon">
                        <?= $iconHelper->gameIssueStatusIcon($issueInfo->status_id, array(
                            'data-toggle'=> 'tooltip',
                            'title' => $issueInfo->status->name
                            ));
                        ?>
                    </span>
                </div>
                <div class="col-md-8">
                    <?php if ($issueInfo->status_date || $issueInfo->comment): ?>
                        <div class="game-card_issue-info-status-date">
                            <?= Yii::app()->getDateFormatter()->formatDateTime($issueInfo->status_date, 'long', null); ?>
                        </div>
                        <div class="game-card_issue-info-status-comment">
                            <?= nl2br(Chtml::encode($issueInfo->comment)); ?>
                        </div>
                    <?php else: ?>
                        &mdash;
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
