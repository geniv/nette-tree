<?php

use Nette\Localization\ITranslator;
use Nette\Application\UI\Control;


/**
 * Class TreeMenu
 *
 * @author  geniv
 */
class TreeMenu extends Control
{
    /** @var string */
    private $templatePath;
    /** @var ITranslator */
    private $translator;


    /**
     * TreeMenu constructor.
     *
     * @param ITranslator|null $translator
     */
    public function __construct(ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;
    }


    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        //TODO dopsat...

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
