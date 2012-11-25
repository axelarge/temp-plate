<?php
namespace Axelarge\TempPlate;

use Closure;
use ArrayAccess;

final class ViewContext implements ArrayAccess
{
    /** @var array */
    private $data;
    private $environment;
    /** @var Renderer */
    private $renderer;

    /** @var array */
    private $blocks = array();
    private $outputBlocks = false;

    /**
     * @param Environment $environment
     * @param Renderer $renderer
     * @param array $data View variables
     */
    public function __construct(Environment $environment, Renderer $renderer, array $data)
    {
        $this->environment = $environment;
        $this->renderer = $renderer;
        $this->data = $data;
    }

    /**
     * @param string $name
     * @param Closure|string $content
     * @return string
     */
    public function block($name, $content = '')
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = $content;
        }

        if ($this->outputBlocks) {
            ob_start();
            $theContent = $this->blocks[$name];
            if ($theContent instanceof Closure) {
                $this->renderer->renderAndOutputClosure($theContent, $this);
            } else {
                echo $theContent;
            }

            return ob_get_clean();
        } else {
            return null;
        }
    }

    public function setOutputBlocks($outputBlocks)
    {
        $this->outputBlocks = $outputBlocks;
    }

    /**
     * @param mixed $offset
     * @return boolean
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

    public function render($name, array $data = array())
    {
        return $this->renderer->render($this->environment->getTemplate($name), array_merge($this->data, $data));
    }
}
