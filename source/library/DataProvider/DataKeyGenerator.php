<?php
/**
 * Description of DataKeyGenerator.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;

/**
 * Provides key generating algorithm for data storing
 *
 * Use strategy template if more complex key generating algorithms needed
 *
 * @package UWC\DataProvider
 */
class DataKeyGenerator
{

    public function generate()
    {
        return md5(mt_rand() . '-' . microtime(true));
    }

}