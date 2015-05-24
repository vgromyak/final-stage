<?php
/**
 * Description of locator.php
 *
 * @author Vladimir Gromyak
 */
$container->singleton(\UWC\ServiceLocator::STORAGE_INCOME, function () use ($container) {
    $config = $container['config'];
    $factory = new \UWC\Storage\Factory($config['storage']['income']['config']);
    $storage = $factory->create($config['storage']['income']['type']);
    return $storage;
});
$container->singleton(\UWC\ServiceLocator::STORAGE_OUTCOME, function () use ($container) {
    $config = $container['config'];
    $factory = new \UWC\Storage\Factory($config['storage']['outcome']['config']);
    $storage = $factory->create($config['storage']['outcome']['type']);
    return $storage;
});
$container->singleton(\UWC\DataProvider\Factory::class, function () use ($container) {
    $factory = new \UWC\DataProvider\Factory(
        $container[\UWC\ServiceLocator::STORAGE_INCOME],
        $container[\UWC\DataProvider\DataKeyGenerator::class]
    );
    return $factory;
});
$container->singleton(\UWC\ServiceLocator::class, function () use ($container) {
    return new \UWC\ServiceLocator($container);
});
$container->singleton(\UWC\Waveform\Creator::class, function ($key) use ($container) {
    include_once(THIRD_PARTY_LIB_PATH . 'php-waveform-png.php');
    return new \UWC\Waveform\Creator(
        $container[\UWC\ServiceLocator::STORAGE_INCOME],
        $container[\UWC\ServiceLocator::STORAGE_OUTCOME],
        $container[\UWC\DataProvider\DataKeyGenerator::class]
    );
});