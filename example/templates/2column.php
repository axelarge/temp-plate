<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return new Template(function (ViewContext $view) {
    $view->block('content', function (ViewContext $view) { ?>
        <div style="width: 200px; float:left; border: 1px solid #ccc">
            <?= $view->block('sidebar', 'sidebar!') ?>
        </div>
        <div style="margin-left: 210px; border: 1px solid #ccc">
            <?= $view->block('content-center', 'center content!') ?>
        </div>
    <?php });
}, 'layout');
