<?php

namespace App\Controller;

use App\Service\TypeName;
use Psr\Cache\CacheItemPoolInterface;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Client\Client;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\Context\FilesystemContext;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaManagerInterface;

class Index extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/')]
    public function show(): mixed
    {
        $types = [];
        foreach (GeneratorFactory::getPossibleTypes() as $type) {
            $types[$type] = TypeName::getDisplayName($type);
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'types' => array_chunk($types, ceil(count($types) / 2), true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/index.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }
}
