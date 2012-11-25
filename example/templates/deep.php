<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return Template::extend('hello', function (ViewContext $view, TestHelper $helper) {
    $view->block('title', "Hello {$view['name']}!");
    $view->block('deep', $helper->input('name', 'This is another macro'));
});
