<?php

namespace TRAW\PowermailJira\Configuration;

use In2code\Powermail\Domain\Model\Answer;
use JiraRestApi\Configuration\AbstractConfiguration;
use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ConditionalConfiguraton
 * @package TRAW\PowermailJira\Configuration
 */
class ConditionalConfiguraton extends JiraConfiguration
{
    /**
     * @var ObjectStorage
     */
    protected ObjectStorage $answers;

    /**
     * Get the first configuration that matches its conditions
     * or the first one without conditions
     *
     * @param PowermailSubmitEvent $event
     *
     * @return IssueConfiguration|null
     * @throws \In2code\Powermail\Exception\DeprecatedException
     */
    public function getConfiguration(PowermailSubmitEvent $event)
    {
        $key = $event->getMail()->getForm()->getJiraTarget();
        $configuration = $this->getIssueConfiguration()[$key];

        $this->answers = $event->getMail()->getAnswers();
        $issueConfiguration = null;

        foreach ($configuration['issueConfiguration'] as $conf) {
            if (isset($conf['conditions'])) {
                $conditionMatches = $this->conditionMatches($conf['conditions']);

                if (!$conditionMatches) {
                    continue;
                }
            }
            $issueConfiguration = new IssueConfiguration($conf);
            //we want the first one that matches
            break;
        }

        return $issueConfiguration;
    }

    /**
     * Returns true if all conditons match
     *
     * fields: if there's an answer where the value matches
     * notFields: if there's an answer but the value doesn't match
     *
     * @param array $conditions
     *
     * @return bool
     * @throws \In2code\Powermail\Exception\DeprecatedException
     */
    protected function conditionMatches(array $conditions): bool
    {
        if (isset($conditions['fields'])) {
            foreach ($conditions['fields'] as $cmpField => $cmpValues) {
                $cmpAnswer = $this->filterAnswersForConditionField($cmpField);

                if (empty($cmpAnswer) || !in_array($cmpAnswer->getValue(), $cmpValues)) {
                    return false;
                }
            }
        }
        if (isset($conditions['notFields'])) {
            foreach ($conditions['notFields'] as $cmpField => $cmpValues) {
                $cmpAnswer = $this->filterAnswersForConditionField($cmpField);

                if (!empty($cmpAnswer) && in_array($cmpAnswer->getValue(), $cmpValues)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Returns the Answer that has the $fieldName as marker/name
     *
     * @param string $fieldName
     *
     * @return Answer|null
     */
    protected function filterAnswersForConditionField(string $fieldName): ?Answer
    {
        return array_values(array_filter($this->answers->toArray(), function ($answer) use ($fieldName) {
            return $answer->getField()->getMarker() === $fieldName;
        }))[0] ?? null;
    }
}
