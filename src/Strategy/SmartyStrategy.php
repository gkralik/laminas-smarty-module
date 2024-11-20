<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GKralik\SmartyModule\Strategy;

use GKralik\SmartyModule\Renderer\SmartyRenderer;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\ViewEvent;

class SmartyStrategy extends AbstractListenerAggregate
{
    /** @var SmartyRenderer */
    private $renderer;

    /**
     * SmartyStrategy constructor.
     */
    public function __construct(SmartyRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Attach one or more listeners.
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param int $priority
     *
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    /**
     * Check if the renderer can load the requested template.
     *
     * @return bool|SmartyRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();

        if ($model === null || !$this->renderer->canRender($model->getTemplate())) {
            return false;
        }

        return $this->renderer;
    }

    /**
     * Inject the response from the renderer.
     */
    public function injectResponse(ViewEvent $e): void
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            // not our renderer
            return;
        }

        $result = $e->getResult();
        $response = $e->getResponse();

        if ($response === null) {
            return;
        }

        $response->setContent($result);
    }
}
