<?php

namespace App\Controller;

use App\Model\Generate;
use App\Service\CaptchaVerifier;
use App\Service\TypeName;
use PSX\Api\Attribute\Body;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Param;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Framework\Config\ConfigInterface;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Environment\HttpResponse;
use PSX\Http\Exception\BadRequestException;
use PSX\Http\Writer\File;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;

class Generator extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/generator')]
    public function show(): mixed
    {
        $types = [];
        foreach (GeneratorFactory::getPossibleTypes() as $type) {
            $types[$type] = TypeName::getDisplayName($type);
        }

        $data = [
            'title' => 'DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'types' => array_chunk($types, (int) ceil(count($types) / 2), true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Get]
    #[Path('/generator/:type')]
    public function showType(string $type): mixed
    {
        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator/form.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }
}
