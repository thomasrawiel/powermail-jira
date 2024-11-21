<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Domain\Model\DTO;

/**
 * Class FieldCondition
 */
class FieldCondition
{
    /**
     * @var string
     */
    protected string $field = '';
    /**
     * @var array
     */
    protected array $values = [];
    /**
     * @var bool
     */
    protected bool $invert = false;

    /**
     * @param string $field
     * @param array  $values
     * @param bool   $invert
     */
    public function __construct(string $field, array $values, bool $invert = false)
    {
        $this->field = $field;
        $this->values = $values;
        $this->invert = $invert;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return bool
     */
    public function isInvert(): bool
    {
        return $this->invert;
    }
}
