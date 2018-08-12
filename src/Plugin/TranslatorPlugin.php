<?php

namespace Keet\Mvc\Plugin;

use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class TranslatorPlugin extends AbstractPlugin implements TranslatorInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
    }

    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->getTranslator()->translate($message, $textDomain, $locale);
    }

    public function translatePlural(
        $singular,
        $plural,
        $number,
        $textDomain = 'default',
        $locale = null
    ) {
        return $this->getTranslator()->translatePlural($singular, $plural, $number, $textDomain, $locale);
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator() : TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @param TranslatorInterface $translator
     *
     * @return TranslatorPlugin
     */
    public function setTranslator(TranslatorInterface $translator) : TranslatorPlugin
    {
        $this->translator = $translator;

        return $this;
    }

}