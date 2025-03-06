<?php
declare(strict_types=1);

namespace TRAW\PowermailJira\Domain\Model\CustomFields;

/**
 * Class SimpleValueCustomField
 */
final class SimpleValueCustomField extends AbstractCustomField
{
    /**
     * @var string|array
     */
    protected string|array $value;

    /**
     * @param string       $key
     * @param string|array $value
     */
    public function __construct(string $key, string|array $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string|array
     */
    public function getValue(): string|array
    {
        return $this->value;
    }
}