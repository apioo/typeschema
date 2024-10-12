<?php

namespace App\Controller;

use App\Model\Generate;
use App\Service\TypeName;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Exception\BadRequestException;
use PSX\Schema\Generator\Config;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaManagerInterface;

class Generator extends ControllerAbstract
{
    private ReverseRouter $reverseRouter;
    private SchemaManagerInterface $schemaManager;

    public function __construct(ReverseRouter $reverseRouter, SchemaManagerInterface $schemaManager)
    {
        $this->reverseRouter = $reverseRouter;
        $this->schemaManager = $schemaManager;
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
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'types' => array_chunk($types, 9, true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator_overview.php';
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
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'schema' => $this->getSchema(),
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/:type')]
    public function generate(string $type, Generate $generate): mixed
    {
        $namespace = $generate->getNamespace();
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        $config = new Config();
        if (!empty($namespace)) {
            $config->put(Config::NAMESPACE, $namespace);
        }

        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        try {
            $result = (new TypeSchema($this->schemaManager))->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'namespace' => $namespace,
            'schema' => $schema ?? $this->getSchema(),
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
            'output' => $output,
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "definitions": {
    "Student": {
      "type": "struct",
      "properties": {
        "firstName": {
          "type": "string"
        },
        "lastName": {
          "type": "string"
        },
        "age": {
          "type": "integer"
        }
      }
    }
  },
  "root": "Student"
}
JSON;
    }
}
