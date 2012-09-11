<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return new Template(function (\Axelarge\TempPlate\ViewContext $view) {
    $view->block('title', "Hello {$view['name']}!");
    $view->block('deep', 'overriden deep stuff');
}, 'hello');
