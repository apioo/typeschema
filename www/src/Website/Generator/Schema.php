<?php

namespace App\Website\Generator;

use PSX\Api\Attribute\Incoming;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;

class Schema extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/generator/schema.php', [
            'schema' => $this->getSchema(),
            'types' => GeneratorFactory::getPossibleTypes()
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $type   = $record->type ?? null;
        $schema = $record->schema ?? null;
        $config = null;

        try {
            $result = (new TypeSchema())->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/generator/schema.php', [
            'schema' => $schema,
            'types' => GeneratorFactory::getPossibleTypes(),
            'type' => $type,
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
