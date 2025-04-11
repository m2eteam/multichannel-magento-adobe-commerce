<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model;

class Extension
{
    private string $moduleName;
    private string $title;
    private bool $isEnabled;
    private ?string $description;
    private ?string $icon;
    private string $template;
    private string $id;
    private string $moduleLabel;
    private ExtensionMetadata $metadata;
    private ?string $menuCssId;

    public function __construct(
        string $id,
        string $moduleName,
        string $moduleLabel,
        string $title,
        bool $isEnabled,
        string $template,
        ExtensionMetadata $metadata,
        ?string $description,
        ?string $icon,
        ?string $menuId
    ) {
        $this->moduleName = $moduleName;
        $this->title = $title;
        $this->isEnabled = $isEnabled;
        $this->description = $description;
        $this->icon = $icon;
        $this->template = $template;
        $this->id = $id;
        $this->moduleLabel = $moduleLabel;
        $this->metadata = $metadata;
        $this->menuCssId = $menuId;
    }

    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModuleLabel(): string
    {
        return $this->moduleLabel;
    }

    public function getMetadata(): ExtensionMetadata
    {
        return $this->metadata;
    }

    public function getMenuCssId(): ?string
    {
        return $this->menuCssId;
    }
}
