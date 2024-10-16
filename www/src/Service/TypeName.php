<?php

declare(strict_types = 1);

namespace App\Service;

use PSX\Schema\GeneratorFactory;

class TypeName
{
    public static function getDisplayName(string $type): string
    {
        return match($type) {
            GeneratorFactory::TYPE_CSHARP => 'C#',
            GeneratorFactory::TYPE_GRAPHQL => 'GraphQL',
            GeneratorFactory::TYPE_HTML => 'HTML',
            GeneratorFactory::TYPE_JSONSCHEMA => 'JsonSchema',
            GeneratorFactory::TYPE_PHP => 'PHP',
            GeneratorFactory::TYPE_TYPESCHEMA => 'TypeSchema',
            GeneratorFactory::TYPE_TYPESCRIPT => 'TypeScript',
            GeneratorFactory::TYPE_VISUALBASIC => 'VisualBasic',
            default => ucfirst($type),
        };
    }
}
