<?php

namespace TRAW\PowermailJira\Configuration;

use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Validation\Validation;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Schema\Struct\SelectItem;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class JiraConfiguration
 * @package TRAW\PowermailJira\Configuration
 */
class JiraConfiguration
{
    /**
     * @param $params
     *
     * @return void
     */
    public function loadJiraConfigurationForTCA(&$params): void
    {
        $items = $this->getConfigurationKeyValues();

        //switch between old and new
        if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 12) {
            $params['items'] = array_merge($params['items'], $items);
        } else {
            $params['items'] = array_merge($params['items'], array_map(function ($item) {
                return new SelectItem('select', $item[0], $item[1]);
            }, $items));
        }
    }

    /**
     * @return array|null
     */
    public function getConnectionConfiguration(): ?array
    {
        return $this->getExtensionConfiguration()['connection'] ?? null;
    }

    /**
     * @return array|null
     */
    protected function getIssueConfiguration(): ?array
    {
        return $this->getExtensionConfiguration()['issues'] ?? null;
    }

    /**
     * @return array|null
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    protected function getExtensionConfiguration(): ?array
    {
        return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('powermail_jira');
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getConfigurationKeyValues(): array
    {
        $configuration = $this->getIssueConfiguration();
        return !empty($configuration) ? array_map(function ($config, $key) {
            if (Validation::validateConfiguration($key, $config)) {
                return [$config['tca']['label'], empty($config['tca']['value']) ? $key : $config['tca']['value']];
            }
        }, $configuration, array_keys($configuration)) : [];
    }

    /**
     * @param string $key
     *
     * @return array|null
     */
    public function getConfigurationByKey(string $key): IssueConfiguration
    {
        return new IssueConfiguration($this->getIssueConfiguration()[$key]);
    }
}