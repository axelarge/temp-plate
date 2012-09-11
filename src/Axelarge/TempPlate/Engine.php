<?php
namespace Axelarge\TempPlate;

class Engine
{
    /** @var string */
    protected $basePath;
    /** @var Template[] */
    protected $templates = array();

    public function __construct($basePath)
    {
        $this->basePath = realpath($basePath).'/';
    }

    private function fullPath($shortName)
    {
        return $this->basePath.$shortName.'.php';
    }

    public function getTemplate($templateName)
    {
        if (!isset($this->templates[$templateName])) {
            // try finding and registering
            $fullPath = $this->fullPath($templateName);
            if (!@is_readable($fullPath)) {
                throw new \InvalidArgumentException("Template $templateName not found!");
            }

            $this->templates[$templateName] = require $fullPath;
        }

        return $this->templates[$templateName];
    }

}
