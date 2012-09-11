<?php
namespace Axelarge\TempPlate;

use Closure;
use InvalidArgumentException;

class MacroProxy
{
    private $context;
    /** @var Engine */
    private $engine;

    private $macros = array();


    public function __construct(ViewContext $context, Engine $engine)
    {
        $this->context = $context;
        $this->engine = $engine;
    }

    public function __set($name, $macro)
    {
        if (!$macro instanceof Closure) {
            throw new InvalidArgumentException("Macros must be closures!");
        }

        $this->macros[$name] = $macro;
    }

    public function __call($name, $args)
    {
        if (!isset($this->macros[$name])) {
            throw new InvalidArgumentException("Macro $name doesn't exist or is not imported!");
        }

        ob_start();
        array_unshift($args, $this->context);
        call_user_func_array($this->macros[$name], $args);
        return ob_get_clean();
    }

    public function import($sourceTemplate, $name = null)
    {
        $macros = $this->engine->getTemplate($sourceTemplate)->getMacros();
        if ($name === null) {
            $this->macros = array_merge($this->macros, $macros);
        } else if (is_array($name)) {
            foreach ($name as $key => $value) {
                if (is_numeric($key)) {
                    $key = $value;
                }
                $this->macros[$value] = $macros[$key];
            }
        } else {
            $this->macros[$name] = $macros[$name];
        }
    }

}
