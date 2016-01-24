<div class="row">
    <div class="col-md-6">
        <div class="movie-card_section">
            <?php
            $this->renderPartial('_form/main-params', array(
                'formWidget' => $formWidget,
                'movieForm' => $movieForm,
            ));
            ?>
        </div>
    </div>
</div>
