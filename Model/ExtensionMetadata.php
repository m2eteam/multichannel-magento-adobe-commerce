<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model;

class ExtensionMetadata
{
    private string $docsUrl;
    private string $supportUrl;
    private string $marketplaceUrl;
    private string $docInstallUrl;

    public function __construct(
        string $docsUrl,
        string $supportUrl,
        string $marketplaceUrl,
        string $docInstallUrl
    ) {
        $this->docsUrl = $docsUrl;
        $this->supportUrl = $supportUrl;
        $this->marketplaceUrl = $marketplaceUrl;
        $this->docInstallUrl = $docInstallUrl;
    }

    public function getDocsUrl(): string
    {
        return $this->docsUrl;
    }

    public function getSupportUrl(): string
    {
        return $this->supportUrl;
    }

    public function getMarketplaceUrl(): string
    {
        return $this->marketplaceUrl;
    }

    public function getDocInstallUrl(): string
    {
        return $this->docInstallUrl;
    }
}
