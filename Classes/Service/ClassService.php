<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Service;

/**
 * Class ClassService
 *
 * Get classnames depending on which Jira Client Extension is installed
 */
class ClassService
{
    /**
     * @return string
     */
    public static function getArrayConfigurationClass(): string
    {
        $class = '';
        if (class_exists(\TRAW\PowermailJiraonpremiseIssues\Configuration\ArrayConfiguration::class)) {
            $class = \TRAW\PowermailJiraonpremiseIssues\Configuration\ArrayConfiguration::class;
        }
        if (class_exists(\TRAW\PowermailJiraIssues\Configuration\ArrayConfiguration::class)) {
            $class = \TRAW\PowermailJiraIssues\Configuration\ArrayConfiguration::class;
        }
        return $class;
    }

    /**
     * @return string
     */
    public static function getUserServiceClass(): string
    {
        $class = '';

        if (class_exists(\TRAW\PowermailJiraonpremiseIssues\Service\UserService::class)) {
            $class = \TRAW\PowermailJiraonpremiseIssues\Service\UserService::class;
        }
        if (class_exists(\TRAW\PowermailJiraIssues\Service\UserService::class)) {
            $class = \TRAW\PowermailJiraIssues\Service\UserService::class;
        }
        return $class;
    }

    /**
     * @return string
     */
    public static function getJiraIssueServiceClass(): string
    {
        $class = '';
        if (class_exists(\TRAW\PowermailJiraonpremiseIssues\Service\JiraIssueService::class)) {
            $class = \TRAW\PowermailJiraonpremiseIssues\Service\JiraIssueService::class;
        }
        if (class_exists(\TRAW\PowermailJiraIssues\Service\JiraIssueService::class)) {
            $class = \TRAW\PowermailJiraIssues\Service\JiraIssueService::class;
        }
        return $class;
    }

    /**
     * @return string
     */
    public static function getIssueDocumentClass(): string
    {
        $class = '';
        if (class_exists(\TRAW\PowermailJiraonpremiseIssues\Domain\Model\IssueDocument::class)) {
            $class = \TRAW\PowermailJiraonpremiseIssues\Domain\Model\IssueDocument::class;
        }
        if (class_exists(\TRAW\PowermailJiraIssues\Domain\Model\IssueDocument::class)) {
            $class = \TRAW\PowermailJiraIssues\Domain\Model\IssueDocument::class;
        }
        return $class;
    }

    /**
     * @return string
     */
    public static function getIssueFieldClass(): string
    {
        $class = '';
        if (class_exists(\JiraRestApi\Issue\IssueField::class)) {
            $class = \JiraRestApi\Issue\IssueField::class;
        }
        if (class_exists(\JiraCloud\Issue\IssueField::class)) {
            $class = \JiraCloud\Issue\IssueField::class;
        }
        return $class;
    }

    /**
     * @return string
     */
    public static function getReporterClass(): string {
        $class = '';
        if (class_exists(\JiraRestApi\Issue\Reporter::class)) {
            $class = \JiraRestApi\Issue\Reporter::class;
        }
        if (class_exists(\JiraCloud\Issue\Reporter::class)) {
            $class = \JiraCloud\Issue\Reporter::class;
        }
        return $class;
    }
}
