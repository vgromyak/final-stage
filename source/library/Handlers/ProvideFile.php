<?php
/**
 * Description of ProvideFile.php
 *
 * @author Vladimir Gromyak
 */
namespace UWC\Handlers;


use UWC\App\Forms\ProvideFile as ProvideFileForm;
use UWC\App\Forms\Renderer;

class ProvideFile extends ViewHandler
{

    public function handle($data)
    {
        $form = new ProvideFileForm();
        $this->form = Renderer::render($form);
        $this->step = 1;
    }

}