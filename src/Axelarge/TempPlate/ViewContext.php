<?php
namespace Axelarge\TempPlate;

use Closure;
use ArrayAccess;

class ViewContext implements ArrayAccess
{
    /** @var array */
    private $blocks = array();
    /** @var array */
    private $data;

    private $outputBlocks = false;

    /**
     * @param array $data View variables
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @param Closure|string $content
     * @return string
     */
    public function block($name, $content)
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = $content;
        }

        if ($this->outputBlocks) {
            ob_start();
            $theContent = $this->blocks[$name];
            if ($theContent instanceof Closure) {
                $theContent($this);
            } else {
                echo $theContent;
            }

            return ob_get_clean();
        } else {
            return null;
        }
    }

    public function _setOutputMode($mode)
    {
        $this->outputBlocks = $mode;
    }

    /**
     * @return boolean true
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
