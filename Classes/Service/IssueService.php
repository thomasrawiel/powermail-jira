<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Service;

use JiraRestApi\Issue\Reporter;
use TRAW\PowermailJira\Configuration\ConditionalConfiguraton;
use TRAW\PowermailJira\Configuration\JiraConfiguration;
use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Domain\Model\IssueField;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TRAW\PowermailJira\Utility\AnswerUtility;

/**
 * Class IssueService
 */
class IssueService
{
    /**
     * @var ConditionalConfiguraton|JiraConfiguration|null
     */
    protected ConditionalConfiguraton|null $jiraConfiguration = null;
    /**
     * @var UserLookupService|null
     */
    protected UserLookupService|null $userLookupService = null;

    /**
     * @param JiraConfiguration $jiraConfiguration
     */
    public function __construct(ConditionalConfiguraton $jiraConfiguration, UserLookupService $userLookupService)
    {
        $this->jiraConfiguration = $jiraConfiguration;
        $this->userLookupService = $userLookupService;
    }

    /**
     * @param PowermailSubmitEvent $event
     *
     * @return IssueField
     * @throws \Exception
     */
    public function createIssue(PowermailSubmitEvent $event)
    {
        $mail = $event->getMail();
        $uri = $event->getUri();
        $url = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
        $answers = $mail->getAnswers();
        /** @var IssueConfiguration $configuration */
        $configuration = $this->jiraConfiguration->getConfiguration($event);

        $issueDocumentClass = ClassService::getIssueDocumentClass();
        $issueFieldClass = ClassService::getIssueFieldClass();
        $issueDocument = new $issueDocumentClass();

        if(empty($issueFieldClass) || empty($issueFieldClass)) {
            throw new \Exception('Depending classes missing');
        }

        if (empty($configuration)) {
            throw new \Exception('No matching configuration found');
        }

        $issueField = (new $issueFieldClass())->setProjectKey($configuration->getProjectKey())
            ->setSummary($configuration->getSubject() ?? $mail->getSubject())
            ->setPriorityNameAsString($configuration->getPriority())
            ->setIssueTypeAsString($configuration->getType())
            ->setDescription($issueDocument->getDescriptionForIssue($event));

        if(!empty($configuration->getReporterFieldName())) {
            $reporterField = AnswerUtility::filterAnswersForField($answers, $configuration->getReporterFieldName());
            if(!empty($reporterField)) {
                $reporterClass = ClassService::getReporterClass();
                $reporter = new $reporterClass();
                $reporter->emailAddress = $reporterField->getValue();

                $issueField->reporter = $reporter;
            }
        }

        foreach ($configuration->getCustomFields() as $customFieldKey => $customFieldValue) {
            $issueField->addCustomField($customFieldKey, $customFieldValue);
        }

        if (!empty($configuration->getAssignee())) {
            $assignToUser = $this->userLookupService->lookup($configuration->getAssignee(), $configuration->getProjectKey());
            if (empty($assignToUser)) {
                $issueField->setAssigneeToDefault();
            } else {
                if ($assignToUser['accountId']) {
                    $issueField->setAssigneeAccountId($assignToUser['accountId']);
                } else {
                    //fallback for v2 api
                    $issueField->setAssigneeNameAsString($assignToUser['name']);
                }
            }
        }

        return $issueField;
    }
}
