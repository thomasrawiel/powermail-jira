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

https://github.com/lesstif/php-jira-rest-client


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
Each project can have multiple configurations that are by conditions

```
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['powermail_jira'] = [
    'connection' => [
        'jiraHost' => getenv('JIRAAPI_V3_HOST'),
        'jiraUser' => getenv('JIRAAPI_V3_USER'),
        'personalAccessToken' => getenv('JIRAAPI_V3_PERSONAL_ACCESS_TOKEN'),
    ],
    'issues' => [
        //required. configuration key, recommended to be the same as tca value, max 20 chars if tca value is empty
        'my_project_1' => [
            'tca' => [
                //required: label for the configuration select in the powermail form backend form
                'label' => 'Service Request in Project XYZ',
                //max 20 chars, leave empty to use configuration key
                'value' => '',
            ],
            //configuration used to create issues in Jira
            'issueConfiguration' => [
               //case 1: Used as configuration if powermail_fieldname has the value 'Powermail Field Value 01'
                [
                    'project_key' => 'JiraProjectKey',
                    'type' => 'Task', //Task, Story, etc.
                    'priority' => 'High',
                    'customFields' => [
                        'customfield_10000' => ['name'=>'Group name'], //group field
                        'customfield_10001' => ['value'=>'Value'], //select field (single)
                        'customfield_10002 => [ //select field (multiple)
                            ['value'=>'Value 1'], ['value'=>'Value 2'], /
                        ],
                        'customfield_10003' => 'Simple string value',
                        new \TRAW\PowermailJira\Domain\Model\CustomFields\SimpleValueCustomField('customfield_10004', 'simple string value'),
                        new \TRAW\PowermailJira\Domain\Model\CustomFields\SimpleValueCustomField('customfield_10005', ['value'=>'Value']), //select field (single)
                        new \TRAW\PowermailJira\Domain\Model\CustomFields\SimpleValueCustomField('customfield_10006', [ //select field (multiple)
                            ['value'=>'Value 1'], ['value'=>'Value 2'], /
                        ]), //select field (multiple)
                        new \TRAW\PowermailJira\Domain\Model\CustomFields\MarkerValueCustomField('customfield_10007', 'e_mailadress_marker_name'), //marker from form
                    ],
                    'labels' => ['label1', 'label2'],
                    'conditions' => [
                        'fields' => [
                            'powermail_fieldname' => ['Powermail Field Value 01'],
                        ],
                    ],
                ],
                //Case 2: Used as configuration if powermail_fieldname has the value 'Other Powermail Field value' AND powermail_fieldname2 does not have the value 1,2 or 3
                [
                    'project_key' => 'JiraProjectKey',
                    'type' => 'Task',
                    'priority' => 'Medium',
                    'assignee' => 'Assigned Username',
                    'labels' => ['Other label'],
                    'conditions' => [
                        'fields' => [
                            'powermail_fieldname' => ['Other Powermail Field value'],
                        ],
                        'notFields' [
                            'powermail_fieldname2' => [1,2,3]
                        ]
                    ],
                ],
                //default no condition, always added if no previous configuration condition matched
                [
                    'project_key' => 'JiraProjectKey',
                    'type' => 'Task',
                    'priority' => 'Medium',
                ],
            ],
        ],
    ],
];
```
Hint: The project key is the prefix of the issue number.  In the example of JRA-123, the "JRA" portion of the issue number is the project key.

The label and project key are required.


**New with version 1.2.0**
You can now add values from the form itself to custom fields by adding a `MarkerValueCustomField` to the custom field configuration.

See example above.




### Usage

To enable posting to your Jira Board, make sure to add the static typoscript include `Add Powermail Jira Issues Finisher` to your page's template.

In your form, select the configuration
![Screenshot of the resulting selection in the powermail form](Documentation%2FImages%2FForm.jpg)


The title of the issue will be the subject of the email to the receiver, that you configure in the powermail plugin

All fields of the form will be added to the description of the issue

Uploads fields are detected automatically and files will be attached to the issue after it has been created.



**This extension is work in progess and can change anytime.**
