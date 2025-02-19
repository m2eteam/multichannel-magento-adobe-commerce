<?php

declare(strict_types=1);

namespace M2E\Multichannel\Helper\Module\Database;

class Tables
{
    public const PREFIX = 'm2e_multichannel_';

    public static function isModuleTable(string $tableName): bool
    {
        return strpos($tableName, self::PREFIX) !== false;
    }
}
