<?php
/**
 * Description of DownloadFile.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Message\MessageInterface;
use UWC\Torrent\Entity\File;

class DownloadFile extends AbstractProvider
{

    public function retrieveData($source)
    {
        $client = new Client();
        try {
            $response = $client->get($source, [
                'timeout' => 40,
                'connect_timeout' => 15,
            ]);
        } catch (ConnectException $e) {
            throw new DataProviderException("Can't download remote file.");
        }
        if ($response->getStatusCode() != 200 || empty($response->getBody())) {
            throw new DataProviderException("Can't download remote file.");
        }

        $this->assetValidContentType($response);

        return $response->getBody();
    }

    private function assetValidContentType(MessageInterface $response)
    {
        $contentType = $response->getHeader('Content-Type');
        if (empty($contentType)) {
            return false;
        }
        $mimeType = explode(';', $contentType, 2);
        $type = reset($mimeType);
        if (!in_array($type, File::$availableMimeTypes)) {
            throw new DataProviderException("Unsupported content type of remove content: {$type}.");
        }
    }

}