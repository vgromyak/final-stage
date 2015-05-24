<?php
/**
 * Description of EditReceive.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Handlers;

use UWC\App\Forms\Edit;
use UWC\App\Forms\ProvideFile;
use UWC\App\Forms\Renderer;
use UWC\DataProvider\DataProviderException;
use UWC\DataProvider\Factory;
use UWC\ID3\TagManager;
use UWC\ServiceLocator;
use UWC\Storage\LocalFile;

class Validate extends ViewHandler
{

    public function handle($data)
    {
        $this->step = 2;
        $form = new ProvideFile();
        $form->setData($data);
        if (!$form->isValid()) {
            $this->forwardToFirstStep($form);
            return ;
        }

        /** @var Factory $factory */
        $factory = $this->getLocator()->get(Factory::class);
        $dataProviderType = $data[ProvideFile::FIELD_TYPE];
        $dataProvider = $factory->create($dataProviderType);
        $source = $factory->retrieveSource($dataProviderType, $data);

        try {
            $key = $dataProvider->retrieveDataAndStore($source);
        } catch (DataProviderException $e) {
            $this->forwardToFirstStep($form, [$e->getMessage()]);
            return;
        }

        $form = new Edit($key);

        /** @var LocalFile $storageIncome */
        $storageIncome = $this->getLocator()->get(ServiceLocator::STORAGE_INCOME);
        /** @var TagManager $tagManager */
        $tagManager = $this->getLocator()->get(TagManager::class);
        $tagManager->setFileName($storageIncome->getFilePath($key));

        $form->setData($tagManager->getMeta()->toArray());

        $this->form = Renderer::render($form);
    }

    private function forwardToFirstStep($form, $errors = [])
    {
        if (!empty($errors)) {
            $this->errors = $errors;
        }
        $this->setTemplate('provide-file-form');
        $this->step = 1;
        $this->form = Renderer::render($form);
    }
}