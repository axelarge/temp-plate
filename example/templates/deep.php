<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return Template::extend('hello', function (ViewContext $view) {
    $view->block('title', "Hello {$view['name']}!");
    $view->block('deep', 'overriden deep stuff');
});
