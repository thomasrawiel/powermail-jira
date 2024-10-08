<?php

namespace TRAW\PowermailJira\Domain\Model\DTO;

class FieldCondition
{
    protected string $field = '';
    protected array $values = [];
    protected bool $invert = false;

    public function __construct(string $field, array $values, bool $invert = false)
    {
        $this->field = $field;
        $this->values = $values;
        $this->invert = $invert;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function isInvert(): bool
    {
        return $this->invert;
    }
}
