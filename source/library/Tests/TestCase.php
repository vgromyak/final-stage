<?php
/**
 * Description of TestCase.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Tests;


use Illuminate\Container\Container;
use Slim\Slim;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    protected function setUp()
    {
        require __DIR__ . '/../../app/start.php';
        /** @var Slim $app */
        $this->container = $app->container->get('locator');
    }

    protected function getContainer()
    {
        return $this->container;
    }
}