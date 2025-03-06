<?php

namespace TRAW\PowermailJira\Domain\Model\CustomFields;

use http\Exception\InvalidArgumentException;

/**
 * Class MarkerValueCustomField
 */
final class MarkerValueCustomField extends AbstractCustomField
{
    /**
     * @var string
     */
    protected ?string $markerFieldName = null;

    /**
     * @var int|null
     */
    protected ?int $uid = null;

    /**
     * @param string $key
     * @param string $markerName
     */
    public function __construct(string $key, ?string $markerName = null, ?int $uid = null)
    {
        $this->key = $key;
        $this->markerName = $markerName;
        $this->uid = $uid;
        
        if(is_null($markerName) && is_null($uid)) {
            throw new InvalidArgumentException('Marker name and uid cannot be null at the same time');
        }
    }

    /**
     * @return string|null
     */
    public function getMarkerFieldName(): ?string
    {
        return $this->markerName;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }
}