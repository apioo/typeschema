<?php

namespace App\Website\Generator;

use PSX\Api\Attribute\Incoming;
use PSX\Api\Parser\OpenAPI;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Api\GeneratorFactory;
use PSX\Http\Writer\File;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Parser\TypeSchema;

class Client extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/generator/client.php', [
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
            $result = (new OpenAPI())->parse($schema);
            $generator = (new GeneratorFactory('TypeSchema', 'https://foobar.com', ''))->getGenerator($type, $config);

            $output = $generator->generate($result);

            if ($output instanceof Chunks) {
                $file = PSX_PATH_CACHE . '/' . uniqid('client-') . '.zip';
                $output->writeTo($file);

                return new File($file, $type . '.zip', 'application/zip');
            }
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/generator/client.php', [
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
