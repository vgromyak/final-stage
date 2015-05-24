<?php
/**
 * Description of Edit.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Handlers;


use UWC\App\Forms\Renderer;
use UWC\DataProvider\DataKeyGenerator;
use UWC\ID3\Meta;
use UWC\ID3\TagManager;
use UWC\ServiceLocator;
use UWC\Storage\LocalFile;
use Zend\Form\Form;

class Edit extends ViewHandler
{

    public function handle($data)
    {
        $this->step = 3;

        $key = @$data[\UWC\App\Forms\Edit::FIELD_FILE_KEY];
        $form = new \UWC\App\Forms\Edit($key);
        $form->setData($data);
        if (!$form->isValid()) {
            $this->fail($form);
            return ;
        }

        try {
            $newKey = $this->processTagsModification($key, $form);
            $this->newKey = $newKey;
        } catch (\Exception $e) {
            $this->fail($form, [$e->getMessage()]);
            return ;
        }
    }

    private function fail($form, $errors = [])
    {
        $this->step = 2;
        $this->errors = $errors;
        $this->form = Renderer::render($form);
        $this->setTemplate('validate-form');
    }

    private function processTagsModification($key, Form $form)
    {
        list($newKey, $fileName) = $this->copySource($key);

        $data = $form->getData();
        $meta = Meta::fromArray($data);
        /** @var TagManager $tagManager */
        $tagManager = $this->getLocator()->get(TagManager::class);
        $tagManager->setFileName($fileName);
        $tagManager->setMeta($meta);

        return $newKey;
    }


    private function copySource($key)
    {
        /** @var LocalFile $storageIncome */
        $storageIncome = $this->getLocator()->get(ServiceLocator::STORAGE_INCOME);
        //$fileName = $storage->getFilePath($key);
        $source = $storageIncome->get($key);

        /** @var LocalFile $storageOutcome */
        $storageOutcome = $this->getLocator()->get(ServiceLocator::STORAGE_OUTCOME);
        /** @var DataKeyGenerator $keyGenerator */
        $keyGenerator = $this->getLocator()->get(DataKeyGenerator ::class);
        $newKey = $keyGenerator->generate();
        $storageOutcome->set($newKey, $source);

        return [$newKey, $storageOutcome->getFilePath($newKey)];
    }
}