<?php

namespace lib\html;

class Element
{
    /**
     * http://w3c.github.io/html/syntax.html#void-elements
     */
    private const VOID_ELEMENTS = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    ];
    /**
     * If set, children are ignored
     * @var string
     */
    public $contents;
    private $name;
    /**
     * @var self[]
     */
    private $children = [];
    /**
     * @var string[]
     */
    private $attributes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function has(string $attributeName): bool
    {
        return isset($this->attributes[$attributeName]);
    }

    public function get(string $attributeName): string
    {
        if (isset($this->attributes[$attributeName])) {
            return $this->attributes[$attributeName];
        } else {
            return null;
        }
    }

    public function getArray(string $attributeName): array
    {
        if (isset($this->attributes[$attributeName])) {
            return explode(' ', $this->attributes[$attributeName]);
        } else {
            return [];
        }
    }

    public function set(string $attributeName, $attributeValue): self
    {
        if (is_array($attributeValue)) {
            $valueToSet = implode(' ', $attributeValue);
        } else {
            $valueToSet = $attributeValue;
        }
        $this->attributes[$attributeName] = $valueToSet;
        return $this;
    }

    public function push(string $attributeName, string $pushValue): self
    {
        $values = $this->getArray($attributeName);
        $values[] = $pushValue;
        $this->set($attributeName, $values);
        return $this;
    }

    public function addChild(self $element): self
    {
        $this->children[] = $element;
        return $this;
    }

    public function render(): string
    {
        $result = "<$this->name";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $result .= " $attributeName=\"" . htmlspecialchars($attributeValue) . '"';
        }
        $result .= '>';

        if (!in_array($this->name, self::VOID_ELEMENTS)) {
            if (isset($this->contents)) {
                $result .= $this->contents;
            } else {
                foreach ($this->children as $childElement) {
                    $result .= $childElement->render();
                }
            }
            $result .= "</$this->name>";
        }

        return $result;
    }
}
