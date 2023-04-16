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
use PSX\Schema\Inspector;
use PSX\Schema\Parser\TypeSchema;

class Hash extends ControllerAbstract
{
    private ReverseRouter $reverseRouter;

    public function __construct(ReverseRouter $reverseRouter)
    {
        $this->reverseRouter = $reverseRouter;
    }

    #[Get]
    #[Path('/generator/hash')]
    public function show(): mixed
    {
        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/hash.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/hash')]
    public function generate(Generate $generate): mixed
    {
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        try {
            $result = (new TypeSchema())->parse($schema);
            $output = (new Inspector\Hash())->generate($result->getDefinitions());
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'output' => $output
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/hash.php';
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
