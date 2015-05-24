<?php
/**
 * Description of TagManager.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\ID3;


class TagManager {

    private $fileName;

    /**
     * @param $fileName
     */
    public function __construct($fileName = null)
    {
        $this->fileName = $fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getMeta()
    {
        $data = id3_get_tag($this->fileName);
        $meta = Meta::fromArray($data);
        return $meta;
    }

    public function setMeta(Meta $meta)
    {
        $data = $meta->toArray();
        $version = $this->defineCurrentVersion();
        id3_set_tag($this->fileName, $data, $version);
    }
//0 => int 1 - ID3_V1_0
//1 => int 3 - ID3_V1_1
//2 => int 4 - ID3_V2_1
//3 => int 12 - ID3_V2_2
//4 => int 28 - ID3_V2_3
//5 => int 60 - ID3_V2_4
    private function defineCurrentVersion()
    {
        return ID3_V1_1;//too old library(((
        //return @id3_get_version($this->fileName);
    }

}