<?php
defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(\TRAW\PowermailJira\Domain\Model\Form::TABLE_NAME, [
    'jira_target' => [
        'label' => 'Jira Configuration',
        'description' => '',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => '', 'value' => ''],
            ],
            'default' => '',
            'itemsProcFunc' => \TRAW\PowermailJira\Configuration\JiraConfiguration::class . '->loadJiraConfigurationForTCA',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
]);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    \TRAW\PowermailJira\Domain\Model\Form::TABLE_NAME,
    'jira_target',
    '',
    'after:pages'
);