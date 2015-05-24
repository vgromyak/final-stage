<?php
/**
 * Description of Renderer.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\App\Forms;


use Zend\Form\Element;
use Zend\Form\Form;

class Renderer
{

    public static function render(Form $form)
    {
        $html = '';
        $html .= "<form method=\"{$form->getAttribute('method')}\" action=\"{$form->getOption('action')}\"";
        $html .= " name=\"{$form->getName()}\" id=\"{$form->getName()}\"";
        $html .= " class=\"jumbotron\"";
        if ($enctype = $form->getOption('enctype')) {
            $html .= " enctype=\"{$enctype}\"";
        }
        $html .= ">";
        foreach ($form->getElements() as $element) {
            $html .= self::renderElement($element);
        }
        $html .= "</form>";
        return $html;
    }

    private static function renderElement(Element $element)
    {
        switch ($element->getAttribute('type')) {
            case 'hidden':
                return self::renderHidden($element);
            case 'text':
            case 'url':
                return self::renderText($element);
            case 'file':
                return self::renderFile($element);
            case 'textarea':
                return self::renderTextarea($element);
            case 'radio':
                return self::renderRadio($element);
            case 'select':
                return self::renderSelect($element);
            case 'submit':
                return self::renderSubmit($element);
            default:
                return '';
        }
    }

    private static function renderHidden(Element $element)
    {
        $html = "<input type=\"hidden\" name=\"{$element->getName()}\" value=\"{$element->getValue()}\">";
        return self::wrap($element, $html);
    }

    private static function renderText(Element $element)
    {
        $html = '';
        $html .= "<input type=\"{$element->getAttribute('type')}\" ";
        $html .= "name=\"{$element->getName()}\" ";
        $html .= "value=\"{$element->getValue()}\" ";
        $html .= "placeholder=\"{$element->getLabel()}\" ";
        $html .= "class=\"form-control\">";
        return self::wrap($element, $html);
    }

    private static function renderFile(Element $element)
    {
        $html = '';
        $html .= "<input type=\"{$element->getAttribute('type')}\" name=\"{$element->getName()}\">";
        return self::wrap($element, $html);
    }

    private static function renderTextarea(Element $element)
    {
        $html = '';
        $html .= "<textarea name=\"{$element->getName()}\" ";
        $html .= "placeholder=\"{$element->getLabel()}\" ";
        $html .= " class=\"form-control\">{$element->getValue()}</textarea>";
        return self::wrap($element, $html);
    }

    private static function renderRadio(Element\Radio $element)
    {
        $html = '';
        $elementValue = $element->getValue() === null ? $element->getOption('default') : $element->getValue();
        if ($elementValue === null) {
            $elementValue = key($element->getValueOptions());
        }
        foreach ($element->getValueOptions() as $value=>$label) {
            $html .= '<div class="checkbox" id="item-'.$element->getName() . '-' . $value .'"><label>';
            $html .= "<input type=\"{$element->getAttribute('type')}\" name=\"{$element->getName()}\" value=\"{$value}\"";
            if ($elementValue == $value) {
                $html .= " checked";
            }
            $html .= " id=\"{$element->getName()}-{$value}\"";
            $html .= ">";
            $html .= " {$label}";
            $html .= '</label></div>';
        }
        return $html;
    }

    private static function renderSelect(Element\Select $element)
    {
        $html = "<select name=\"{$element->getName()}\" class=\"form-control\">";
        $elementValue = $element->getValue() === null ? $element->getOption('default') : $element->getValue();
        foreach ($element->getValueOptions() as $value=>$label) {
            $html .= "<option value=\"{$value}\"";
            if ($elementValue == $value) {
                $html .= " checked";
            }
            $html .= ">{$label}</option>";
        }
        $html .= "</select>";
        return self::wrap($element, $html);
    }

    private static function renderSubmit(Element $element)
    {
        $html = '';
        $html .= "<input class=\"btn btn-default\" type=\"{$element->getAttribute('type')}\" name=\"{$element->getName()}\" value=\"{$element->getValue()}\">";
        return self::wrap($element, $html);
    }

    private static function wrap(Element $element, $code, $wrapper = 'form-group')
    {
        $messages = $element->getMessages();

        $html = '';
        $html .= '<div class="' . $wrapper . (empty($messages) ? '' : ' has-error') . '"';
        $html .= ' id="item-'.$element->getName() .'"';
        $html .= ($element->getOption('hidden') ? ' style="display: none;"' : '') . '>';
        if ($element->getLabel()) {
            $html .= '<label for="' . $element->getName() . '">';
            $html .= $element->getLabel();
            $html .= '</label>';
        }
        $html .= $code;

        if (!empty($messages)) {
            $html .= '<p class="alert media bg-danger">';
            $html .= implode('<br>', $messages);
            $html .= '</p>';
        }
        $html .= '</div>';
        return $html;
    }

}