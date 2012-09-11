<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return new Template(function (ViewContext $view) {
    $view->block('content-center', function (ViewContext $view) { ?>
        hello i am overridden content and <?= $view->block('deep', 'deep stuff') ?>
    <?php });
}, '2column');
