<?php
/**
 * Description of ServiceLocator.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC;
use Illuminate\Container\Container;
use Slim\Helper\Set;

/**
 * All functionality moved to Slim\Helper\Set
 * Class contains only keys for special cases of class usages
 *
 * @package UWC
 */
class ServiceLocator
{

    const STORAGE_INCOME = 'storageIncome';
    const STORAGE_OUTCOME = 'storageOutcome';

    /**
     * @var Container
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get($key)
    {
        return $this->container[$key];
    }

}