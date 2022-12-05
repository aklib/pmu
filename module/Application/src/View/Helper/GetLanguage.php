<?php

/**
 * View helper to get translations in a view
 */


namespace Application\View\Helper;

use Laminas\I18n\Exception;
use Laminas\I18n\Translator\Translator;
use Laminas\I18n\Translator\TranslatorInterface;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Helper\AbstractHelper;

class GetLanguage extends AbstractHelper
{

    protected string $language;

    public function __construct(Translator $translator)
    {
        $this->language = $translator->getLocale();
    }

    /**
     * Gets current language ru|en
     *
     * @return string
     */
    public function __invoke(): string
    {
        return $this->language;
    }
}
