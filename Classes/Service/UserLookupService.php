<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Service;

use TRAW\PowermailJira\Configuration\JiraConfiguration;

/**
 * Class UserLookupService
 */
class UserLookupService
{
    /**
     * @var JiraConfiguration|null
     */
    protected JiraConfiguration|null $jiraConfiguration = null;

    /**
     * @param JiraConfiguration $jiraConfiguration
     */
    public function __construct(JiraConfiguration $jiraConfiguration)
    {
        $this->jiraConfiguration = $jiraConfiguration;
    }

    /**
     * @param string $searchString
     * @param string $project
     *
     * @return array
     * @throws \JiraCloud\JiraException
     * @throws \JsonMapper_Exception
     */
    public function lookup(string $searchString, string $project): array
    {
        $userServiceClass = ClassService::getUserServiceClass();
        $arrayConfigurationClass = ClassService::getArrayConfigurationClass();

        $userService = new $userServiceClass(new $arrayConfigurationClass($this->jiraConfiguration->getConnectionConfiguration()));
        $users = $userService->findAssignableUsers([
            'project' => $project,
            'startAt' => 0,
            'maxResults' => 200,
        ]);

        $found = false;

        foreach (['accountId', 'emailAddress', 'name', 'displayName', 'key'] as $searchColumn) {
            $found = array_search($searchString, array_column($users, $searchColumn));
            if ($found !== false) {
                break;
            }
        }

        return $found !== false ? $users[$found]->toArray() : [];
    }
}
