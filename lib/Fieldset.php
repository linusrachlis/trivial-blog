<?php

namespace lib;

class Fieldset
{
    /**
     * @var Field[]
     */
    private $fields = [];

    public function __get(string $fieldName): Field
    {
        if (!isset($this->fields[$fieldName])) {
            $this->fields[$fieldName] = new Field($fieldName);
        }
        return $this->fields[$fieldName];
    }

    public function isValid(): bool
    {
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Map of field names to values
     * @return string[]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->fields as $fieldName => $field) {
            $values[$fieldName] = $field->value();
        }
        return $values;
    }

}
