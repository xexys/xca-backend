<div class="section game-card_movies">

    <h4 class="section_header">Ролики</h4>

    <div class="section_content">
        <?php
        $this->widget(
            '\app\components\grid\BaseView',
            array(
                'dataProvider' => $gameMovieDataProvider,
                'templateWidget' => true,
                'columns' => array(
                    array(
                        'name' => 'id',
                    ),
                    array(
                        'class' => 'app\components\grid\DataColumn\Movie',
                        'name' => 'title',
                        'value' => '$this->title($data)',
                    ),
                    array(
                        'name' => 'issue_year',
                    ),
                    array(
                        'class' => '\app\components\grid\CrudButtonColumn',
                    )
                )
            )
        );
        ?>

        <div class="game-card_movies-buttons">
            <?= $linkHelper->crudAddLink(array('label' => 'Добавить ролик', 'url' => $createMovieUrl)); ?>
        </div>
    </div>
</div>

