<?php

namespace TRAW\PowermailJira\Domain\Model\DTO;

/**
 * Class IssueConfiguration
 * @package TRAW\PowermailJira\Domain\Model\DTO
 */
class IssueConfiguration
{
    /**
     * @var string|mixed
     */
    protected string $projectKey = '';
    /**
     * @var string|mixed|null
     */
    protected ?string $subject = null;
    /**
     * @var string|mixed
     */
    protected string $type = '';
    /**
     * @var string|mixed
     */
    protected string $priority = '';
    /**
     * @var string|mixed|null
     */
    protected ?string $assignee = null;
    /**
     * @var bool
     */
    protected bool $assigneeIsAccountId = false;
    /**
     * @var array|mixed
     */
    protected array $labels = [];

    /**
     * @param array|null $conf
     *
     * @throws \Exception
     */
    public function __construct(?array $conf)
    {
        if (empty($conf) || empty($conf['project_key'])) {
            throw new \Exception('No configuration for this board');
        }

        $this->projectKey = $conf['project_key'] ?? '';
        $this->subject = $conf['subject'] ?? null;
        $this->type = $conf['type'] ?? 'Task';
        $this->priority = $conf['priority'] ?? 'Medium';
        $this->assignee = $conf['assignee'] ?? '';
        $this->labels = $conf['labels'] ?? [];
    }

    /**
     * @return mixed
     */
    public function getAssignee(): mixed
    {
        return $this->assignee;
    }

    /**
     * @return mixed
     */
    public function getPriority(): mixed
    {
        return $this->priority;
    }

    /**
     * @return mixed
     */
    public function getProjectKey(): mixed
    {
        return $this->projectKey;
    }

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

}
