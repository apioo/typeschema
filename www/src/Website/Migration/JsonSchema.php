<?php

namespace App\Website\Migration;

use PSX\Api\Attribute\Incoming;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;

class JsonSchema extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/migration/jsonschema.php', [
            'schema' => $this->getSchema()
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $schema = $record->schema ?? null;

        try {
            $output = (new \PSX\Schema\Transformer\JsonSchema())->transform(json_decode($schema));
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/migration/jsonschema.php', [
            'schema' => $schema,
            'output' => json_encode($output, JSON_PRETTY_PRINT)
        ]);
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
