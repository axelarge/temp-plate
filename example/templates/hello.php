<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return Template::extend('2column', function (ViewContext $view) {
    $view->block('content-center', function (ViewContext $view) { ?>
        hello i am overridden content and <?= $view->block('deep', 'deep stuff') ?>

        <p>
            This is a macro: Macro goes here
        </p>

            <p>
                This is a partial:
                <?= $view->render('partial') ?>
            </p>
    <?php });
});
