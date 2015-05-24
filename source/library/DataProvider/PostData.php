<?php
/**
 * Description of PostData.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


class PostData  extends AbstractProvider
{

    public function retrieveData($source)
    {
        return $source;
    }

}