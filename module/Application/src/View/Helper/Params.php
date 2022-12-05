<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

/**
 * View helper to get route params in a view
 */

namespace Application\View\Helper;

use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\RequestInterface;
use Laminas\View\Helper\AbstractHelper;

class Params extends AbstractHelper
{
    protected RequestInterface $request;
    protected MvcEvent $event;
    protected array $params;

    public function __construct(RequestInterface $request, MvcEvent $event)
    {
        $this->request = $request;
        $this->event = $event;
    }

    public function __invoke($name = null, $default = null)
    {
        if (empty($this->params)) {
            $routeMatch = $this->event->getRouteMatch();
            if($routeMatch === null){
                return '';
            }
            $this->params = array_replace_recursive(
                (array)$this->request->getQuery(),
                (array)$this->request->getPost(),
                $routeMatch->getParams() ?? []
            );
        }
        if ($name === null) {
            return $this->params;
        }
        return empty($this->params[$name]) ? $default : $this->params[$name];
    }
}
