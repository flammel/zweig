<?php

namespace Flammel\Zweig\Renderer;

use Flammel\Zweig\Exception\ZweigException;
use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\Presenter\Presenter;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Template;

class ComponentRenderer
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $openComponents;

    /**
     * @var Presenter
     */
    private $presenter;

    /**
     * @param Environment $twig
     * @param Presenter $presenter
     */
    public function __construct(Environment $twig, Presenter $presenter)
    {
        $this->twig = $twig;
        $this->presenter = $presenter;
        $this->openComponents = [];
    }

    /**
     * @param ComponentName $name
     * @param ComponentArguments $arguments
     * @return string
     * @throws ZweigException
     */
    public function render(ComponentName $name, ComponentArguments $arguments): string
    {
        try {
            $presentable = $this->presenter->present($name, $arguments);
            return $this->twig->render(
                $presentable->getPath()->getPath(),
                $presentable->getContext()->toContextArray()
            );
        } catch (LoaderError $e) {
            throw new ZweigException(
                'A loader error occured while trying to render component ' . $name->getName(),
                1576234772,
                $e
            );
        } catch (RuntimeError $e) {
            throw new ZweigException(
                'A runtime error occured while trying to render component ' . $name->getName(),
                1584348561,
                $e
            );
        } catch (SyntaxError $e) {
            throw new ZweigException(
                'A syntax error occured while trying to render component ' . $name->getName(),
                1568433417,
                $e
            );
        }
    }

    /**
     * @param string $name
     * @param string $lineno
     * @param array $props
     * @param array $fills
     * @param array $context
     * @param Template $template
     * @return string
     * @throws ZweigException
     */
    public function renderComponent(
        string $name,
        string $lineno,
        array $props,
        array $fills,
        array $context,
        Template $template
    ): string {
        array_unshift($this->openComponents, [
            'name' => $name,
            'lineno' => $lineno,
            'fills' => $fills,
            'context' => $context,
            'template' => $template
        ]);
        $result = $this->render(new ComponentName($name), new ComponentArguments($props));
        array_shift($this->openComponents);
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function fills(string $name): bool
    {
        if (empty($this->openComponents)) {
            return false;
        }
        return isset($this->openComponents[0]['fills']) && in_array($name, $this->openComponents[0]['fills']);
    }

    /**
     * @param string $slotName
     * @param array $context
     * @return string
     */
    public function getFill(string $slotName, array $context): string
    {
        // We have to remove the open component from the stack because the fill could contain another slot.
        // We have to add it again because it is removed at the end of renderComponent, and to make sure
        // that the `fills` method returns the correct value for subsequent fills.
        ob_start();
        $openComponent = array_shift($this->openComponents);
        /** @var mixed $template */
        $template = $openComponent['template'];
        $template->getFill(
            $openComponent['name'],
            $openComponent['lineno'],
            $slotName,
            array_merge($openComponent['context'], ['parent' => $context])
        );
        array_unshift($this->openComponents, $openComponent);
        return ob_get_clean() ?: '';
    }
}
