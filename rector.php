<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\PhpParser\Node\CustomNode\FileWithoutNamespace;


return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::NAMING,
        SetList::PHP_82,
        SetList::TYPE_DECLARATION,
        SetList::DEAD_CODE,
        // You can add other sets as needed
    ]);

    $rectorConfig->rules([
        FileWithoutNamespace::class
    ]);

    $rectorConfig->paths([
        __DIR__ ]);

        $rectorConfig->skip([
            __DIR__ . '/vendor',
            __DIR__ . '/.git',
        ]);

    // Optional: Configure other rules or sets
};
