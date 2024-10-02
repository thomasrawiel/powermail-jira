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
    protected string|array $priority = '';
    /**
     * @var string|mixed|null
     */
    protected string|array $assignee = '';
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
    public function __construct(?array $conf = null)
    {
        $this->projectKey = $conf['project_key'] ?? '';
        $this->subject = $conf['subject'] ?? null;
        $this->type = $conf['type'] ?? 'Task';
        $this->priority = $conf['priority'] ?? 'Medium';
        $this->assignee = $conf['assignee'] ?? '';
        $this->labels = $conf['labels'] ?? [];
    }

    public function getProjectKey(): string
    {
        return $this->projectKey;
    }

    public function setProjectKey(string $projectKey): void
    {
        $this->projectKey = $projectKey;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getPriority(): array|string
    {
        return $this->priority;
    }

    public function setPriority(array|string $priority): void
    {
        $this->priority = $priority;
    }

    public function getAssignee(): array|string
    {
        return $this->assignee;
    }

    public function setAssignee(array|string $assignee): void
    {
        $this->assignee = $assignee;
    }

    public function isAssigneeIsAccountId(): bool
    {
        return $this->assigneeIsAccountId;
    }

    public function setAssigneeIsAccountId(bool $assigneeIsAccountId): void
    {
        $this->assigneeIsAccountId = $assigneeIsAccountId;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    public function set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
