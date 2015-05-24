<?php
/**
 * Description of routes.php
 *
 * @author Vladimir Gromyak
 */

$renderFile = function ($template, $data = [])
{
    if (!empty($data)) {
        extract($data);
    }
    require dirname(__DIR__) . '/templates/template.phtml';
};
$renderContent = function ($content, $layout = 'template')
{
    require dirname(__DIR__) . "/templates/{$layout}.phtml";
};
$renderHandler = function ($handler, $template, $data = [], $layout = 'template') use ($container, $renderContent) {
    /** @var \UWC\Handlers\ViewHandler $handler */
    $handler = $container[$handler];
    $content = $handler->render($data, $template);
    $renderContent($content, $layout);
};

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/', function () use ($renderHandler) {
    $renderHandler(\UWC\Handlers\ProvideFile::class, 'provide-file-form');
});

$app->get('/waveform/', function () use ($app,$container) {
    $key = $app->request->get('key');
//    $creator = $container[\UWC\Waveform\Creator::class];
//
//    $creator->makeWaveform();
//todo: fix;
    $storageOutcome = $container[\UWC\ServiceLocator::STORAGE_OUTCOME];


    include(__DIR__ .'/../third-party-lib/php-waveform-png.php');
    makeWaveform($storageOutcome->getFilePath($key));
});

//$app->get('/provide-file-form/', function () use ($renderHandler) {
//    /** @var \UWC\Handlers\ViewHandler $handler */
//    $renderHandler(\UWC\Handlers\ProvideFile::class, 'provide-file-form', [], 'simple-template');
//});

$app->post('/', function () use ($app, $renderHandler) {
    $data = array_merge($app->request->post(), $_FILES);
    $renderHandler(\UWC\Handlers\Validate::class, 'validate-form', $data);
});

$app->post('/edit/', function () use ($app, $renderHandler) {
    $data = array_merge($app->request->post(), $_FILES);
    $renderHandler(\UWC\Handlers\Edit::class, 'edit-form', $data);
});

//$app->get('/upload-progress/', function () use ($app, $renderHandler) {
//    $unique = $app->request->get('unique');
//    $key = "upload_progress_$unique";
//    var_dump($_SESSION);
//    if (isset($_SESSION[$key])) { // файл загружается в данный момент
//        $progress = $_SESSION["upload_progress_$unique"];
//        $percent = round(100 * $progress['bytes_processed'] / $progress['content_length']);
//        echo "Upload progress: $percent%<br /><pre>" . print_r($progress, 1) . '</pre>';
//    } else {
//        echo 'no uploading';
//    }
//});


$app->get('/edit/upload/', function () use ($app, $container) {
    $key = $app->request->get('key');
    $key = preg_replace('/\W+/isu', '', $key);

    /** @var \UWC\Storage\Storage $storage */
    $storage = $container[\UWC\ServiceLocator::STORAGE_OUTCOME];
    try {
        //todo: buffering output;
        $content = $storage->get($key);

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Length: ". strlen($content).";");
        header("Content-Disposition: attachment; filename={$key}.mp3");
        header("Content-Type: " . \UWC\App\Forms\ProvideFile::$availableMimeTypes[1] . "; ");
        echo $content;
    } catch (\Exception $e) {
        //todo: forward to pretty error
    }
});
$app->get('/edit/send-email/', function () use ($renderFile) {
    $renderFile('edit-form-email');
});

$app->get('/about/', function () use ($renderContent)  {
    $parser = new \cebe\markdown\GithubMarkdown();
    $parser->html5 = true;
    $markdown = file_get_contents(APPLICATION_PATH . '/README.md');
    $renderContent($parser->parse($markdown));
});