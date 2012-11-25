<?php
namespace Axelarge\TempPlate\Helpers;

use ArrayAccess;
use Axelarge\TempPlate\ViewContext;
use Axelarge\TempPlate\Engine;

abstract class Helper implements HelperInterface, ArrayAccess
{
    /** @var \Axelarge\TempPlate\ViewContext */
    protected $viewContext;
    /** @var \Axelarge\TempPlate\Engine */
    protected $engine;


    public function __construct(ViewContext $viewContext, Engine $engine)
    {
        $this->viewContext = $viewContext;
        $this->engine = $engine;
    }

    //
    // ArrayAccess implementation - forward to ViewContext
    //

    /**
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->viewContext->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->viewContext->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->viewContext->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->viewContext->offsetUnset($offset);
    }
}
