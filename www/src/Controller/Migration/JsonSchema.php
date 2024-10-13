<?php

namespace App\Controller\Migration;

use App\Model\Generate;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Incoming;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Api\Model\Passthru;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;

class JsonSchema extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/migration/jsonschema')]
    public function show(): mixed
    {
        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema()
        ];

        $templateFile = __DIR__ . '/../../../resources/template/migration/jsonschema.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/migration/jsonschema')]
    public function migrate(Generate $generate): mixed
    {
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        try {
            $output = (new \PSX\Schema\Transformer\JsonSchema())->transform(json_decode($schema));
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'output' => json_encode($output, JSON_PRETTY_PRINT)
        ];

        $templateFile = __DIR__ . '/../../../resources/template/migration/jsonschema.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "$id": "https://example.com/product.schema.json",
  "title": "Product",
  "description": "A product from Acme's catalog",
  "type": "object",
  "properties": {
    "productId": {
      "description": "The unique identifier for a product",
      "type": "integer"
    },
    "productName": {
      "description": "Name of the product",
      "type": "string"
    },
    "price": {
      "description": "The price of the product",
      "type": "number",
      "exclusiveMinimum": 0
    },
    "tags": {
      "description": "Tags for the product",
      "type": "array",
      "items": {
        "type": "string"
      },
      "minItems": 1,
      "uniqueItems": true
    },
    "dimensions": {
      "type": "object",
      "properties": {
        "length": {
          "type": "number"
        },
        "width": {
          "type": "number"
        },
        "height": {
          "type": "number"
        }
      },
      "required": [ "length", "width", "height" ]
    }
  },
  "required": [ "productId", "productName", "price" ]
}
JSON;
    }
}
