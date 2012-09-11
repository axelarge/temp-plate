<?php
namespace Axelarge\TempPlate;

class Renderer
{
    /** @var Engine */
    private $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function render(Template $template, array $context = array())
    {
        $ctx = new ViewContext($this->engine, $context);

        $currentTemplate = $template;
        $ctx->_setCurrentTemplate($currentTemplate);
        while ($currentTemplate->hasParent()) {
            $closure = $currentTemplate->getClosure();
            $closure($ctx);
            $currentTemplate = $this->engine->getTemplate($currentTemplate->getParent());
            $ctx->_setCurrentTemplate($currentTemplate);
        }

        // Now arrived at topmost template (no parent)
        $closure = $currentTemplate->getClosure();

        return $closure($ctx);
    }

}
