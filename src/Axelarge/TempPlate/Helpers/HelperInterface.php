<?php
namespace Axelarge\TempPlate\Helpers;

use Axelarge\TempPlate\ViewContext;
use Axelarge\TempPlate\Environment;

interface HelperInterface
{
    public function __construct(ViewContext $viewContext, Environment $environment);
}
