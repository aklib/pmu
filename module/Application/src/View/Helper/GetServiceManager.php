<?php /** @noinspection PhpUnused */

/**
 * View helper to get service manager in a view
 */
namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceManager;

class GetServiceManager extends AbstractHelper {
    protected ServiceManager $sm;
    /**
     * Constructor
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm) {
        $this->sm = $sm;
    }
    
    /**
     * Gets a ServiceManager
     * @return ServiceManager
     */
    public function __invoke(): ServiceManager
    {
        return $this->sm;
    }
}
