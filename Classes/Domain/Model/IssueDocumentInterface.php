<?php

namespace TRAW\PowermailJira\Domain\Model;

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
    public function getDescriptionForIssue(ObjectStorage $anwers);
}