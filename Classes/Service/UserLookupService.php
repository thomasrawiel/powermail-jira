<?php

namespace TRAW\PowermailJira\Service;

use JiraCloud\Configuration\ArrayConfiguration;
use JiraCloud\User\UserService;
use TRAW\PowermailJira\Configuration\JiraConfiguration;

/**
 * Class UserLookupService
 * @package TRAW\PowermailJira\Service
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
        $userService = new UserService(new ArrayConfiguration($this->jiraConfiguration->getConnectionConfiguration()));
        $users = $userService->findAssignableUsers([
            'project' => $project,
            'startAt' => 0,
            'maxResults' => 200,
        ]);

        $found = false;

        foreach (['accountId', 'emailAddress', 'name', 'displayName'] as $searchColumn) {
            $found = array_search($searchString, array_column($users, $searchColumn));
            if ($found !== false) break;
        }

        if ($found === false) {
            throw new Exception('User that should be assigned was not found');
        }

        return $users[$found]->toArray();
    }
}