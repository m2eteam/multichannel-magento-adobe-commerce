<?php

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    \M2E\Multichannel\Helper\Module::IDENTIFIER,
    __DIR__
);
