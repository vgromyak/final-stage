<?php
/**
 * Description of ViewHandler.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Handlers;


use UWC\ServiceLocator;

abstract class ViewHandler
{

    /**
     * @var ServiceLocator
     */
    private $locator;

    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @return ServiceLocator
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * @var array
     */
    private $container = [];

    public function __get($key)
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }

    public function __set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->container[$key]);
    }

    public function __unset($key)
    {
        unset($this->container[$key]);
    }

    abstract function handle($data);

    private $template;

    protected function setTemplate($template)
    {
        $this->template = $template;
    }

    private function getTemplatePath($template)
    {
        //todo: implement more clear way
        return APPLICATION_PATH . "/templates/{$template}.phtml";
    }

    private function processTemplate()
    {
        $templatePath = $this->getTemplatePath($this->template);
        extract($this->container);
        include($templatePath);
    }

    final public function render($data, $template)
    {
        $this->setTemplate($template);
        $this->handle($data);
        ob_start();
        $this->processTemplate();
        $content = ob_get_clean();
        return $content;
    }

}