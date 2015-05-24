<?php
/**
 * Description of config.php
 *
 * @author Vladimir Gromyak
 */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('display_errors', 1);
$config = [
    'storage' => [
        'income' => [
            'config' => [
                'localFile' => [
                    'storageRoot' => '/tmp/storage_income/'
                ],
            ],
            'type' => \UWC\Storage\Factory::STORAGE_LOCAL_FILE,
        ],
        'outcome' => [
            'config' => [
                'localFile' => [
                    'storageRoot' => '/tmp/storage_outcome/'
                ],
            ],
            'type' => \UWC\Storage\Factory::STORAGE_LOCAL_FILE,
        ],

    ],
    'engine' => [],
];