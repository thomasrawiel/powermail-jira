<?php

namespace TRAW\PowermailJira\Service;

use DH\Adf\Node\Block\Document;
use JiraCloud\ADF\AtlassianDocumentFormat;
use TRAW\PowermailJira\Configuration\JiraConfiguration;
use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Domain\Model\IssueDocument;
use TRAW\PowermailJira\Domain\Model\IssueField;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;

/**
 * Class IssueService
 * @package TRAW\PowermailJira\Service
 */
class IssueService
{
    /**
     * @var JiraConfiguration|null
     */
    protected JiraConfiguration|null $jiraConfiguration = null;

    protected UserLookupService|null $userLookupService = null;


    /**
     * @param JiraConfiguration $jiraConfiguration
     */
    public function __construct(JiraConfiguration $jiraConfiguration, UserLookupService $userLookupService)
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
    public function createIssue(PowermailSubmitEvent $event): IssueField
    {
        $mail = $event->getMail();
        $uri = $event->getUri();
        $url = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
        $answers = $mail->getAnswers();
        /** @var IssueConfiguration $configuration */
        $configuration = $this->jiraConfiguration->getConfigurationByKey($mail->getForm()->getJiraTarget());


//        $doc = new Document();
//
//        foreach ($answers as $answer) {
//            $doc->paragraph()
//                ->strong($answer->getField()->getTitle())
//                ->end();
//            switch ($answer->getValueType()) {
//                case Answer::VALUE_TYPE_UPLOAD:
//                case Answer::VALUE_TYPE_ARRAY:
//                    foreach ($answer->getValue() as $uploadedFile) {
//                        $doc->paragraph()->text($uploadedFile)->end();
//                    }
//                    break;
//                default:
//                    $doc->paragraph()->text($answer->getValue())->end();
//            }
//
//        }
//        $doc->paragraph()->em('- - - This issue has been automatically created - - -')->end();
//        $doc->paragraph()->em('URL: ' . $url)->end();

        $issueDocumentClass = ClassService::getIssueDocumentClass();
        $issueFieldClass = ClassService::getIssueFieldClass();
        $issueDocument = new $issueDocumentClass();


        $issueField = (new $issueFieldClass())->setProjectKey($configuration->getProjectKey())
            ->setSummary($configuration->getSubject() ?? $mail->getSubject())
            ->setPriorityNameAsString($configuration->getPriority())
            ->setIssueTypeAsString($configuration->getType())
            //->setDescription(new AtlassianDocumentFormat($doc));
            ->setDescription($issueDocument->getDescriptionForIssue($answers));

        foreach ($configuration->getLabels() as $label) {
            $issueField->addLabelAsString($label);
        }

        if (!empty($configuration->getAssignee())) {
            $assignToUser = $this->userLookupService->lookup($configuration->getAssignee(), $configuration->getProjectKey());
            $issueField->setAssigneeAccountId($assignToUser['accountId']);
        } else {
            $issueField->setAssigneeToDefault();
        }

        return $issueField;
    }
}
