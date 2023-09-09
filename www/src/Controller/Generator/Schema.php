<?php

namespace App\Controller\Generator;

use App\Model\Generate;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Incoming;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Api\Model\Passthru;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaManagerInterface;

class Schema extends ControllerAbstract
{
    private ReverseRouter $reverseRouter;
    private SchemaManagerInterface $schemaManager;

    public function __construct(ReverseRouter $reverseRouter, SchemaManagerInterface $schemaManager)
    {
        $this->reverseRouter = $reverseRouter;
        $this->schemaManager = $schemaManager;
    }

    #[Get]
    #[Path('/generator/schema')]
    public function show(): mixed
    {
        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'types' => GeneratorFactory::getPossibleTypes()
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/schema.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/schema')]
    public function generate(Generate $generate): mixed
    {
        $type   = $generate->getType() ?? throw new \RuntimeException('Provided no type');
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');
        $config = null;

        try {
            $result = (new TypeSchema($this->schemaManager))->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'types' => GeneratorFactory::getPossibleTypes(),
            'type' => $type,
            'output' => $output,
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/schema.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "definitions": {
    "Student": {
      "type": "object",
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
  "$ref": "Student"
}
JSON;
    }
}
