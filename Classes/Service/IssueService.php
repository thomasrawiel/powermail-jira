<?php

namespace TRAW\PowermailJira\Service;

use TRAW\PowermailJira\Configuration\ConditionalConfiguraton;
use TRAW\PowermailJira\Configuration\JiraConfiguration;
use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Domain\Model\IssueField;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;

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

        if (empty($configuration)) {
            throw new \Exception('No matching configuration found');
        }
        $issueField = (new $issueFieldClass())->setProjectKey($configuration->getProjectKey())
            ->setSummary($configuration->getSubject() ?? $mail->getSubject())
            ->setPriorityNameAsString($configuration->getPriority())
            ->setIssueTypeAsString($configuration->getType())
            ->setDescription($issueDocument->getDescriptionForIssue($event));

        foreach ($configuration->getCustomFields() as $customFieldKey => $customFieldValue) {
            $issueField->addCustomField($customFieldKey, $customFieldValue);
        }

        foreach ($configuration->getLabels() as $label) {
            $issueField->addLabelAsString($label);
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
