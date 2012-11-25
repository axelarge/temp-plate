<?php
namespace Axelarge\TempPlate\Helpers;

use Axelarge\TempPlate\ViewContext;
use Axelarge\TempPlate\Engine;

interface HelperInterface
{
    public function __construct(ViewContext $viewContext, Engine $engine);
}
