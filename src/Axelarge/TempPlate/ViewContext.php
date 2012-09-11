<?php
namespace Axelarge\TempPlate;

use Closure;
use InvalidArgumentException;
use ArrayAccess;

class ViewContext implements ArrayAccess
{
    /** @var array */
    private $blocks = array();
    private $blockSources = array();

    /** @var array */
    private $data;
    private $engine;
    /** @var MacroProxy */
    private $macro;

    private $outputBlocks = false;

    /**
     * @param Engine $engine
     * @param array $data View variables
     */
    public function __construct(Engine $engine, array $data)
    {
        $this->engine = $engine;
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
            $this->blockSources[$name] = $this->macro;
        }

        if ($this->outputBlocks) {
            ob_start();
            $theContent = $this->blocks[$name];
            $prevMacro = $this->macro;
            $this->macro = $this->blockSources[$name];
            if ($theContent instanceof Closure) {
                $theContent($this);
            } else {
                echo $theContent;
            }
            $this->macro = $prevMacro;

            return ob_get_clean();
        } else {
            return null;
        }
    }

    public function _setCurrentTemplate(Template $template)
    {
        $this->macro = new MacroProxy($this, $this->engine);
        foreach ($template->getImports() as $import) {
            $this->macro->import($import[0], $import[1]);
        }
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

    public function __get($name)
    {
        if ($name === 'macro') {
            return $this->macro;
        }
        throw new InvalidArgumentException("Property $name does not exist");
    }
}
