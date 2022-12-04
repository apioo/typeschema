<?php

namespace App\Website\Generator;

use PSX\Api\Attribute\Incoming;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\Inspector;

class Hash extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/generator/hash.php', [
            'controller' => __CLASS__,
            'schema' => $this->getSchema()
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $schema = $record->schema ?? null;

        try {
            $result = (new TypeSchema())->parse($schema);
            $output = (new Inspector\Hash())->generate($result->getDefinitions());
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/generator/hash.php', [
            'controller' => __CLASS__,
            'schema' => $schema,
            'output' => $output
        ]);
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
