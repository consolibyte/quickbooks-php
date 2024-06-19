<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::PHP_82,
        // You can add other sets as needed
    ]);

    $rectorConfig->paths([
        __DIR__ ]);

        $rectorConfig->skip([
            __DIR__ . '/vendor',
            __DIR__ . '/.git',
        ]);

    // Optional: Configure other rules or sets
};
