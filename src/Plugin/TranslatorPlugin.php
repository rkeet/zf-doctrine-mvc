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

    /**
     * TranslatorPlugin constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
    }

    /**
     * @param string $message
     * @param string $textDomain
     * @param null   $locale
     *
     * @return string
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->getTranslator()->translate($message, $textDomain, $locale);
    }

    /**
     * @param string $singular
     * @param string $plural
     * @param int    $number
     * @param string $textDomain
     * @param null   $locale
     *
     * @return string
     */
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