<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\RequestInterface;
use PSX\Http\ResponseInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;

class Generator extends ViewAbstract
{
    public function onGet(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, __DIR__ . '/resource/generator.php', [
            'schema' => $this->getSchema(),
            'types' => GeneratorFactory::getPossibleTypes()
        ]);
    }

    public function onPost(RequestInterface $request, ResponseInterface $response)
    {
        $body = $this->requestReader->getBody($request);

        $type   = $body->type ?? null;
        $schema = $body->schema ?? null;
        $config = null;

        try {
            $result = (new TypeSchema())->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $this->render($response, __DIR__ . '/resource/generator.php', [
            'schema' => $schema,
            'types' => GeneratorFactory::getPossibleTypes(),
            'type' => $type,
            'output' => $output
        ]);
    }
    
    private function getSchema()
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
