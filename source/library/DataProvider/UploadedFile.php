<?php
/**
 * Description of UploadedFile.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


class UploadedFile extends AbstractProvider
{

    public function retrieveData($source)
    {
        $path = $source['tmp_name'];
        $data = file_get_contents($path);
        return $data;
    }

}