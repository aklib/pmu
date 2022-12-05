<?php /** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection MissingService */

/**
 * Class AddTranslationFile
 * @package Application\View\Helper
 *
 * since: 27.11.2022
 * author: alexej@kisselev.de
 */

namespace Application\View\Helper;

use Laminas\I18n\Translator\Loader\PhpArray;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Helper\AbstractHelper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AddTranslationFile extends AbstractHelper
{
    protected ServiceManager $sm;

    /**
     * Constructor
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    /**
     * Add a translation file. See sections
     * @param string $domain
     * @param string $dir
     * @return void
     */
    public function __invoke(string $domain, string $dir): void
    {
        try {
            $translator = $this->sm->get('translator');
            $file = $dir . '/translation/' . $translator->getLocale() . '.php';
            if (file_exists($file)) {
                $translator->addTranslationFile(PhpArray::class, $file, $domain);
            }
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }
    }
}