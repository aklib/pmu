<?php /** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
/** @noinspection MissingService */
/** @noinspection PhpUnused */

declare(strict_types = 1);

namespace Application;

use Application\View\Helper\AddTranslationFile;
use Application\View\Helper\GetLanguage;
use Application\View\Helper\GetServiceManager;
use Application\View\Helper\Params;
use Interop\Container\Containerinterface as InteropContainerInterface;
use Laminas\I18n\Translator\Translator;
use Laminas\I18n\Translator\TranslatorServiceFactory;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    /**
     * @return array[]
     */
    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                'MvcTranslator' => TranslatorServiceFactory::class,
                'translator'    => function (InteropContainerInterface $sm) {
                    /** @var Translator $translator */
                    $translator = $sm->get('MvcTranslator');
                    $translator->setLocale($this->getLocale($sm));
                    return $translator;

                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                // the array key here is the name you will call the view helper by in your view scripts
                'params'             => function (InteropContainerInterface $sm) {
                    $app = $sm->get('Application');
                    return new Params($app->getRequest(), $app->getMvcEvent());
                },
                'getServiceManager'  => function (InteropContainerInterface $sm) {
                    return new GetServiceManager($sm->get('Application')->getServiceManager());
                },
                'addTranslationFile' => function (InteropContainerInterface $sm): AddTranslationFile {
                    return new AddTranslationFile($sm->get('Application')->getServiceManager());
                },
                'getLanguage'        => function (InteropContainerInterface $sm): GetLanguage {
                    /** @var Translator $translator */
                    $translator = $sm->get('MvcTranslator');
                    return new GetLanguage($translator);
                },
            ],
        ];
    }


    /**
     * Gets current locale from route
     * @param ServiceManager $sm
     * @return string
     */
    private function getLocale(InteropContainerInterface $sm): string
    {
        $locale = 'ru';
        try {
            $routeMatch = $sm->get('Application')->getMvcEvent()->getRouteMatch();
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return $locale;
        }
        if (!empty($routeMatch)) {
            $language = strtolower($routeMatch->getParam('language'));
            if (!empty($language)) {
                $available = ['ru'];
                try {
                    $available = $sm->get('Config')['translator']['available'];
                } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
                }
                if (is_array($available)) {
                    foreach (array_keys($available) as $loc) {
                        if (stripos($loc, $language) === 0) {
                            $locale = $loc;
                            break;
                        }
                    }
                }
            } else {
                header('Location: /' . $locale);
            }
        }
        return $locale;
    }
}
