<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return Template::extend('hello', function (ViewContext $view) {
    $view->block('title', "Hello {$view['name']}!");
    $view->block('deep', $view->macro->input('name', 'this is another macro'));
})
->importFrom('2column');
