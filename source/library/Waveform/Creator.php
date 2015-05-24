<?php
/**
 * Description of Creator.php
 *
 * @author Vladimir Gromyak
 */
namespace UWC\Waveform;

use UWC\DataProvider\DataKeyGenerator;
use UWC\Storage\LocalFile;

class Creator {

    /**
     * @var LocalFile
     */
    private $storageIncome;

    /**
     * @var LocalFile
     */
    private $storageOutcome;

    /**
     * @var DataKeyGenerator
     */
    private $keyGenerator;

    public function __construct(
        LocalFile $storageIncome,
        LocalFile $storageOutcome,
        DataKeyGenerator $keyGenerator)
    {
        $this->storageIncome = $storageIncome;
        $this->storageOutcome = $storageOutcome;
        $this->keyGenerator = $keyGenerator;
    }

    public function create($key)
    {
        $filePath = $this->storageIncome->getFilePath($key);
        $waveformKey = $this->keyGenerator->generate() . '.png';
        $waveformName = $this->storageOutcome->getFilePath($waveformKey);

        makeWaveform($filePath, $waveformName);
        return $waveformName;
    }

}