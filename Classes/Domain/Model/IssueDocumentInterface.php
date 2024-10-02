<?php

namespace TRAW\PowermailJira\Domain\Model;

use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 */
interface IssueDocumentInterface
{
    /**
     * @param ObjectStorage $anwers
     *
     * @return mixed
     */
    public function getDescriptionForIssue(PowermailSubmitEvent $event);
}
