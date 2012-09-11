<?php
namespace Axelarge\TempPlate;

use Closure;

class Template
{
    /** @var Closure */
    protected $closure;
    /** @var string */
    protected $parent;
    /** @var Closure[] */
    protected $macros = array();
    protected $imports = array();


    public function __construct(Closure $closure, $parent = null)
    {
        $this->closure = $closure;
        $this->parent = $parent;
    }

    public static function create(Closure $closure)
    {
        return new self($closure);
    }

    public static function extend($parentName, Closure $closure)
    {
        return new self($closure, $parentName);
    }

    /**
     * @return Closure
     */
    public function getClosure()
    {
        return $this->closure;
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function addMacro($name, Closure $macro)
    {
        $this->macros[$name] = $macro;
        return $this;
    }

    public function importFrom($sourceTemplate, $name = null)
    {
        $this->imports[] = array($sourceTemplate, $name);
        return $this;
    }

    public function getMacros()
    {
        return $this->macros;
    }

    public function getImports()
    {
        return $this->imports;
    }
}
