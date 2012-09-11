<?php

require __DIR__.'/../vendor/autoload.php';

use Axelarge\TempPlate\ViewContext;
use Axelarge\TempPlate\Renderer;
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\Engine;

const TEMP_PLATE_DEBUG = true;

$engine = new Engine(__DIR__.'/templates');
$renderer = new Renderer($engine);
echo $renderer->render($engine->getTemplate('deep'), array('name' => 'Mikelis'));
