<?php
declare(strict_types=1);

namespace TRAW\PowermailJira\Domain\Model\CustomFields;

/**
 * Class AbstractCustomField
 */
abstract class AbstractCustomField
{
    /**
     * @var string
     */
    protected string $key = '';

    /**
     * @return string
     */
    public function getKey(): string
    {
        if (str_starts_with($this->key, 'customfield_') || $this->key === 'summary') {
            return $this->key;
        } else {
            return 'customfield_' . $this->key;
        }
    }
}