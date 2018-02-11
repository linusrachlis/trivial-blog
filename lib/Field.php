<?php

namespace lib;

class Field
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string[]
     */
    public $errors = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function value()
    {
        return isset($_POST[$this->name]) ? $_POST[$this->name] : '';
    }

    public function validatePresent(string $message = null): self
    {
        if ($this->value() === '') {
            $this->addError($message);
        }
        return $this;
    }

    public function validateNotEqual(string $compareValue, string $message = null): self
    {
        if ($this->value() === $compareValue) {
            $this->addError($message);
        }
        return $this;
    }

    public function validateEqual(string $compareValue, string $message = null): self
    {
        if ($this->value() !== $compareValue) {
            $this->addError($message);
        }
        return $this;
    }

    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }

    public function addError(string $message = null): void
    {
        $this->errors[] = $message ?: 'Invalid';
    }

}
