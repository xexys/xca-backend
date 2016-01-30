<h3>Меню</h3>
<hr>
<ul class="menu">
    <li>
        <?= CHtml::link('Игры', Yii::app()->createUrl('game')); ?>
    </li>
    <li>
        <?= CHtml::link('Ролики', Yii::app()->createUrl('movie')); ?>
    </li>
    <li>
        <?= CHtml::link('Файлы', Yii::app()->createUrl('movieFile')); ?>
    </li>
</ul>

