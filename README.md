# powermail-jira-issues
Post powermail form submissions as jira issues

## Installation 
This is the base extension, and doesn't work on it's own - please install either https://github.com/thomasrawiel/powermail-jira-issues or https://github.com/thomasrawiel/powermail-jiraonpremise-issues

## Requirements

You will need:
- at least 1 Jira project where you can post issues.
- A Jira user that is allowed to create issues in that project
- A personal access token, which you can get https://id.atlassian.com/manage-profile/security/api-tokens

Also see for more configuration infos:
https://github.com/lesstif/php-JiraCloud-RESTAPI


## Configuration
(work in progress)

It is recommended to have your credentials and security related configuration values in a seperated .env file
### Connecting to your Jira instance

```
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['powermail_jira'] = [
    'connection' => [
        'jiraHost' => getenv('JIRAAPI_V3_HOST'),
        'jiraUser' => getenv('JIRAAPI_V3_USER'),
        'personalAccessToken' => getenv('JIRAAPI_V3_PERSONAL_ACCESS_TOKEN'),
    ],
];
```
Add this e.g. in your additional.php configuration file

This user will also be the author of the created issues.

### Adding projects

For each project add a configuration array

Some options like Issue type and priority can be configured (WIP)

```
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['powermail_jira'] = [
    'issues' => [
        //configuration key, must be unique, max 20 chars
        'my_issues' => [
            //required: label for the configuration select in the powermail form backend form
            'label' => 'My Issues',
            //required: the projects project key where the issues are created
            'project_key' => getenv('PROJECT_KEY_FOR_MY_ISSUES'),
            //set type for the issues
            'type' => 'Task',
            //set priority of the issues
            'priority' => 'Medium',
        ],
        'other_issues' => [
            'label' => 'Other Issues',
            'project_key' => getenv('PROJECT_KEY_FOR_OTHER_ISSUES'),
            'type' => 'Task',
            'priority' => 'High',
        ],
    ],
];
```
Hint: The project key is the prefix of the issue number.  In the example of JRA-123, the "JRA" portion of the issue number is the project key.

The label and project key are required.


### Usage

To enable posting to your Jira Board, make sure to add the static typoscript include `Add Powermail Jira Issues Finisher` to your page's template.

In your form, select the configuration
![Screenshot of the resulting selection in the powermail form](Documentation%2FImages%2FForm.jpg)


The title of the issue will be the subject of the email to the receiver, that you configure in the powermail plugin

All fields of the form will be added to the description of the issue



This extension is work in progess and can change anytime.