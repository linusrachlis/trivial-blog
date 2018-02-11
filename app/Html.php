<?php

namespace app;

use lib\html\Element;
use lib\Field;

class Html
{
    public static function textInput(Field $field): string
    {
        $input = (new Element('input'))
            ->set('name', $field->name)
            ->set('type', 'text');

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $input->set('value', $field->value());
            if (!$field->isValid()) {
                return $input->render() . self::errorDiv($field->errors[0]);
            }
        }

        return $input->render();
    }

    public static function textarea(Field $field): string
    {
        $textarea = (new Element('textarea'))
            ->set('name', $field->name);

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $textarea->contents = htmlspecialchars($field->value());
            if (!$field->isValid()) {
                return $textarea->render() . self::errorDiv($field->errors[0]);
            }
        }

        return $textarea->render();
    }

    public static function errorDiv(string $errorMessage): string
    {
        $error = new Element('div');
        $error->push('class', 'form-error');
        $error->contents = htmlspecialchars($errorMessage);
        return $error->render();
    }
}
