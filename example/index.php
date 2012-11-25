<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/TestHelper.php';

use Axelarge\TempPlate\Renderer;
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\Environment;

const TEMP_PLATE_DEBUG = true;

$environment = new Environment(__DIR__.'/templates');
$renderer = new Renderer($environment);
echo $renderer->render($environment->getTemplate('deep'), array('name' => 'Mikelis'));
