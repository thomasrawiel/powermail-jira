<?php
declare(strict_types=1);

namespace TRAW\PowermailJira\Utility;

use In2code\Powermail\Domain\Model\Answer;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class AnswerUtility
{
    /**
     * Returns the Answer that has the $fieldName as marker/name
     *
     * @param string $fieldName
     *
     * @return Answer|null
     */
    public static function filterAnswersForField(ObjectStorage $answers, ?string $fieldName = null): ?Answer
    {
        if (is_null($fieldName)) {
            return null;
        }

        return array_values(array_filter($answers->toArray(), function ($answer) use ($fieldName) {
            return $answer->getField()->getMarker() === $fieldName;
        }))[0] ?? null;
    }

    /**
     * Returns the Answer that has the field uid
     *
     * @param ObjectStorage $answers
     * @param int           $fieldUid
     *
     * @return Answer|null
     */
    public static function filterAnswersForFieldUid(ObjectStorage $answers, ?int $fieldUid = null): ?Answer
    {
        if (is_null($fieldUid)) {
            return null;
        }

        return array_values(array_filter($answers->toArray(), function ($answer) use ($fieldUid) {
            return $answer->getField()->getUid() === $fieldUid;
        }))[0] ?? null;
    }
}
