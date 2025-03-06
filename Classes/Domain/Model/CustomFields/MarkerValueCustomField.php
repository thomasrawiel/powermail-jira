<?php

namespace TRAW\PowermailJira\Domain\Model\CustomFields;

/**
 * Class MarkerValueCustomField
 */
final class MarkerValueCustomField extends AbstractCustomField
{
    /**
     * @var string
     */
    protected string $markerFieldName;

    /**
     * @param string $key
     * @param string $markerName
     */
    public function __construct(string $key, string $markerName)
    {
        $this->key = $key;
        $this->markerName = $markerName;
    }

    /**
     * @return string
     */
    public function getMarkerFieldName(): string
    {
        return $this->markerName;
    }
}