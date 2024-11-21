<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Configuration;

use In2code\Powermail\Domain\Model\Answer;
use TRAW\PowermailJira\Domain\Model\DTO\IssueConfiguration;
use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TRAW\PowermailJira\Utility\AnswerUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ConditionalConfiguraton
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
                $cmpAnswer = AnswerUtility::filterAnswersForField($this->answers, $cmpField);

                if (empty($cmpAnswer) || !in_array($cmpAnswer->getValue(), $cmpValues)) {
                    return false;
                }
            }
        }
        if (isset($conditions['notFields'])) {
            foreach ($conditions['notFields'] as $cmpField => $cmpValues) {
                $cmpAnswer = AnswerUtility::filterAnswersForField($this->answers, $cmpField);

                if (!empty($cmpAnswer) && in_array($cmpAnswer->getValue(), $cmpValues)) {
                    return false;
                }
            }
        }

        return true;
    }
}
