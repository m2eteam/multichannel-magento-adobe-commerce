<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model\Extension;

class Source
{
    private string $moduleName;
    private string $title;
    private ?string $description;
    private ?string $icon;
    private string $id;
    private string $moduleLabel;
    private Source\Metadata $metadata;

    public function __construct(
        string $id,
        string $moduleName,
        string $moduleLabel,
        string $title,
        Source\Metadata $metadata,
        ?string $description = null,
        ?string $icon = null
    ) {
        $this->id = $id;
        $this->moduleName = $moduleName;
        $this->moduleLabel = $moduleLabel;
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
        $this->metadata = $metadata;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getModuleLabel(): string
    {
        return $this->moduleLabel;
    }

    public function getMetadata(): Source\Metadata
    {
        return $this->metadata;
    }
}
