<?php

namespace TRAW\PowermailJira\EventListener;

use In2code\Powermail\Domain\Model\Answer;
use JiraCloud\Configuration\ArrayConfiguration;
use JiraCloud\Issue\IssueService as JiraIssueService;
use JiraCloud\JiraException;
use TRAW\PowermailJira\Configuration\JiraConfiguration;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TRAW\PowermailJira\Service\IssueService as MyIssueService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PowermailSubmitEventListener
 * @package TRAW\PowermailJira\EventListener
 */
class PowermailSubmitEventListener
{
    /**
     * @var MyIssueService
     */
    protected MyIssueService $issueService;
    /**
     * @var JiraConfiguration
     */
    protected JiraConfiguration $jiraConfig;

    /**
     * @param MyIssueService $issueService
     */
    public function __construct(MyIssueService $issueService)
    {
        $this->issueService = $issueService;
        $this->jiraConfig = new JiraConfiguration();
    }

    /**
     * @param PowermailSubmitEvent $event
     *
     * @return void
     * @throws JiraException
     * @throws \In2code\Powermail\Exception\DeprecatedException
     * @throws \JsonMapper_Exception
     */
    public function pushToJira(PowermailSubmitEvent $event)
    {
        $connection = $this->jiraConfig->getConnectionConfiguration();
        if (empty($connection)) {
            throw new \Exception('No Jira connection configured.');
        }

        try {
            $jiraIssueService = new JiraIssueService(new ArrayConfiguration($connection));
            $issueField = $this->issueService->createIssue($event);
            $issue = $jiraIssueService->create($issueField);
        } catch (JiraException $exception) {
            throw $exception;
        }

        $uploads = $event->getMail()->getAnswersByValueType(Answer::VALUE_TYPE_UPLOAD);

        if (!empty($uploads)) {
            try {
                $attachments = [];
                $uploadFolder = $event->getSettings()['misc']['file']['folder'] ?? null;

                foreach ($uploads as $upload) {
                    if (is_array($upload->getValue())) {
                        foreach ($upload->getValue() as $fileName) {
                            $attachments[] = GeneralUtility::getFileAbsFileName($uploadFolder . $fileName);
                        }
                    } else {
                        $attachments[] = GeneralUtility::getFileAbsFileName($uploadFolder . $upload->getValue());
                    }
                }
                $jiraIssueService->addAttachments($issue->key, $attachments);
            } catch (JiraException $exception) {
                throw $exception;
            }
        }
    }
}