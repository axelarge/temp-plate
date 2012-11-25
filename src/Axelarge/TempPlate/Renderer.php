<?php
namespace Axelarge\TempPlate;

use Closure;
use ReflectionFunction;
use ReflectionParameter;

class Renderer
{
    const VIEW_CONTEXT_CLASS = 'Axelarge\\TempPlate\\ViewContext';
    const HELPER_INTERFACE = 'Axelarge\\TempPlate\\Helpers\\HelperInterface';

    /** @var Environment */
    private $environment;


    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function render(Template $template, array $data = array())
    {
        $viewContext = new ViewContext($this->environment, $this, $data);

        $currentTemplate = $template;
        while ($currentTemplate->hasParent()) {
            $viewContext->setOutputBlocks(false);
            $this->renderAndOutputClosure($currentTemplate->getClosure(), $viewContext);
            $currentTemplate = $this->environment->getTemplate($currentTemplate->getParent());
        }

        // Now arrived at topmost template (no parent)
        ob_start();
        $viewContext->setOutputBlocks(true);
        $this->renderAndOutputClosure($currentTemplate->getClosure(), $viewContext);
        return ob_get_clean();
    }

    public function renderAndOutputClosure(Closure $closure, ViewContext $context)
    {
        call_user_func_array($closure, $this->getArgsForClosure($closure, $context));
    }

    private function getArgsForClosure(Closure $closure, ViewContext $context)
    {
        $ref = new ReflectionFunction($closure);
        $params = $ref->getParameters();
        $args = array();
        foreach ($params as $refParam) {
            /** @var $refParam ReflectionParameter */
            $reflectionClass = $refParam->getClass();

            if (!$reflectionClass) {
                $args[] = null;
            } else if ($reflectionClass->getName() === self::VIEW_CONTEXT_CLASS) {
                $args[] = $context;
            } else if ($reflectionClass->implementsInterface(self::HELPER_INTERFACE)) {
                // Helper
                $args[] = $reflectionClass->newInstance($context, $this->environment);
            } else {
                throw new Exception("Don't know how to inject arg of class {$reflectionClass->getName()}");
            }
        }
        return $args;
    }
}
