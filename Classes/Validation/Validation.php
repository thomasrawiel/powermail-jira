<?php
declare(strict_types=1);
namespace TRAW\PowermailJira\Validation;

/**
 * Class Validation
 */
class Validation
{
    /**
     * @param string $key
     * @param array  $configuration
     *
     * @return bool
     * @throws \Exception
     */
    public static function validateConfiguration(string $key, array $configuration): bool
    {
        extract($configuration);

        if (empty($tca['label'])) {
            throw new \Exception('Label is required');
        }

        if (strlen($tca['value']) > 20) {
            throw new \Exception('Configuration key is too long (max 20 chars)');
        }

        return self::validateIssueConfiguration($issueConfiguration);
    }

    /**
     * @param array|null $issueConfiguration
     *
     * @return bool
     * @throws \Exception
     */
    protected static function validateIssueConfiguration(?array $issueConfiguration): bool
    {
        if (empty($issueConfiguration)) {
            return false;
        }
        foreach ($issueConfiguration as $key => $issueConfig) {
            if (empty($issueConfig['project_key'])) {
                throw new \Exception('Project key is required in issue configuration #' . $key);
            }
        }

        return true;
    }
}
