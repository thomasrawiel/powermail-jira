<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\EventListener;

use In2code\Powermail\Domain\Model\Answer;
use TRAW\PowermailJira\Configuration\ConditionalConfiguraton;
use TRAW\PowermailJira\Configuration\JiraConfiguration;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TRAW\PowermailJira\Service\ClassService;
use TRAW\PowermailJira\Service\IssueService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PowermailSubmitEventListener
 */
class PowermailSubmitEventListener
{
    /**
     * @var IssueService
     */
    protected IssueService $issueService;
    /**
     * @var JiraConfiguration
     */
    protected JiraConfiguration $jiraConfig;

    /**
     * @param IssueService $issueService
     */
    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
        $this->jiraConfig = new JiraConfiguration();
        $this->config = new ConditionalConfiguraton();
    }

    /**
     * @param PowermailSubmitEvent $event
     *
     * @throws JiraException
     * @throws \In2code\Powermail\Exception\DeprecatedException
     * @throws \TRAW\PowermailJira\Exception\JiraException
     * @throws \JsonMapper_Exception
     */
    public function pushToJira(PowermailSubmitEvent $event)
    {
        $connection = $this->jiraConfig->getConnectionConfiguration();
        if (empty($connection)) {
            throw new \Exception('No Jira connection configured.');
        }

        try {
            $configurationClass = ClassService::getArrayConfigurationClass();
            $jiraIssueServiceClass = ClassService::getJiraIssueServiceClass();

            $jiraIssueService = new $jiraIssueServiceClass(new $configurationClass($connection));
            $issueField = $this->issueService->createIssue($event);
            $issue = $jiraIssueService->create($issueField);
        } catch (\Exception $exception) {
            throw $exception;
        }

        $configuration = $this->config->getConfiguration($event);
        if (count($configuration->getLabels())) {
            try {
                $jiraIssueService->updateLabels($issue->key, $configuration->getLabels(), [], false);
            } catch (\Exception $exception) {
                throw $exception;
            }
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
            } catch (\Exception $exception) {
                throw $exception;
            }
        }
    }
}
