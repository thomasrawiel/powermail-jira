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
    public static function filterAnswersForField(ObjectStorage $answers, string $fieldName): ?Answer
    {
        return array_values(array_filter($answers->toArray(), function ($answer) use ($fieldName) {
            return $answer->getField()->getMarker() === $fieldName;
        }))[0] ?? null;
    }
}
