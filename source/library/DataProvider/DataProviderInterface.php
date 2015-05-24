<?php
/**
 * Description of DataProviderInterface.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


interface DataProviderInterface
{

    /**
     * @param mixed $source
     * @return mixed
     */
    public function retrieveData($source);

    /**
     * Store previously retrieved data and return a key by which the data will be available in the storage
     *
     * @param mixed
     * @return string
     */
    public function retrieveDataAndStore($source);

    /**
     * @param string $key
     * @return mixed
     */
    public function getData($key);
}