<?php
namespace Axelarge\TempPlate;

use Closure;

class Template
{
    /** @var Closure */
    protected $closure;
    /** @var string */
    protected $parent;


    public function __construct(Closure $closure, $parent = null)
    {
        $this->closure = $closure;
        $this->parent = $parent;
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
}
