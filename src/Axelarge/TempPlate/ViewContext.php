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
    private $engine;
    private $renderer;

    private $outputBlocks = false;

    /**
     * @param Engine $engine
     * @param array $data View variables
     */
    public function __construct(Engine $engine, Renderer $renderer, array $data)
    {
        $this->engine = $engine;
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
                $theContent($this);
            } else {
                echo $theContent;
            }

            return ob_get_clean();
        } else {
            return null;
        }
    }

    public function _setCurrentTemplate(Template $template)
    {
        $this->outputBlocks = !$template->hasParent();
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

    public function render($name, array $data = array())
    {
        return $this->renderer->render($this->engine->getTemplate($name), array_merge($this->data, $data));
    }
}
