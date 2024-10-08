<?php

defined('TYPO3') || die('Access denied.');

if (!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail_jira_issues')
    && !\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail_jiraonpremise_issues')) {
    throw new \Exception('EXT:powermail_jira_issues or EXT:powermail_jiraonpremise_issues must be installed!');
}
