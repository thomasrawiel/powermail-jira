<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Domain\Model;

/**
 * Class Form
 */
class Form extends \In2code\Powermail\Domain\Model\Form
{
    /**
     * @var string
     */
    protected string $jiraTarget;

    /**
     * @return string
     */
    public function getJiraTarget(): string
    {
        return $this->jiraTarget;
    }

    /**
     * @param string $jiraTarget
     */
    public function setJiraTarget(string $jiraTarget): void
    {
        $this->jiraTarget = $jiraTarget;
    }
}
