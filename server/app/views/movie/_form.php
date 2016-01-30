<div class="row">
    <div class="col-md-6">
        <div class="section">
            <?php
            $this->renderPartial('_form/main', array(
                'formWidget' => $formWidget,
                'movieForm' => $movieForm,
            ));
            ?>
        </div>
    </div>
</div>
