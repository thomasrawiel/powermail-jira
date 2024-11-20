<?php

namespace TRAW\PowermailJira\Domain\Model\DTO;

/**
 * Class IssueConfiguration
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
     * @var array|mixed
     */
    protected array $customFields = [];

    protected string $reporterFieldName = '';

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
        $this->customFields = $conf['customFields'] ?? [];
        $this->reporterFieldName = $conf['reporterFieldName'] ?? '';
    }

    /**
     * @return string
     */
    public function getProjectKey(): string
    {
        return $this->projectKey;
    }

    /**
     * @param string $projectKey
     */
    public function setProjectKey(string $projectKey): void
    {
        $this->projectKey = $projectKey;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     */
    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array|string
     */
    public function getPriority(): array|string
    {
        return $this->priority;
    }

    /**
     * @param array|string $priority
     */
    public function setPriority(array|string $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return array|string
     */
    public function getAssignee(): array|string
    {
        return $this->assignee;
    }

    /**
     * @param array|string $assignee
     */
    public function setAssignee(array|string $assignee): void
    {
        $this->assignee = $assignee;
    }

    /**
     * @return bool
     */
    public function isAssigneeIsAccountId(): bool
    {
        return $this->assigneeIsAccountId;
    }

    /**
     * @param bool $assigneeIsAccountId
     */
    public function setAssigneeIsAccountId(bool $assigneeIsAccountId): void
    {
        $this->assigneeIsAccountId = $assigneeIsAccountId;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     */
    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @param array $customFields
     */
    public function setCustomFields(array $customFields): void
    {
        $this->customFields = $customFields;
    }

    public function getReporterFieldName(): string
    {
        return $this->reporterFieldName;
    }

    public function setReporterFieldName(string $reporterFieldName): void
    {
        $this->reporterFieldName = $reporterFieldName;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
