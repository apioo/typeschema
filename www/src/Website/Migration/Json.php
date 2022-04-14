<?php

namespace App\Website\Migration;

use PSX\Api\Attribute\Incoming;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;

class Json extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/migration/json.php', [
            'schema' => $this->getSchema()
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $schema = $record->schema ?? null;

        try {
            $definitions = [];
            $root = $this->transform(json_decode($schema), $definitions);

            if (count($definitions) > 0) {
                $root->definitions = (object) $definitions;
            }

            $output = $root;
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/migration/json.php', [
            'schema' => $schema,
            'output' => json_encode($output, JSON_PRETTY_PRINT)
        ]);
    }

    private function transform(mixed $schema, array &$definitions): \stdClass
    {
        if ($schema instanceof \stdClass) {
            $properties = [];
            foreach ($schema as $key => $value) {
                $properties[$key] = $this->transform($value, $definitions);
            }

            $name = 'Schema' . substr(sha1(json_encode($properties)), 0, 8);

            $definitions[$name] = (object) [
                'type' => 'object',
                'properties' => $properties,
            ];

            return (object) [
                '$ref' => $name,
            ];
        } elseif (is_array($schema)) {
            if (count($schema) === 0) {
                throw new \RuntimeException('Array must contain a value otherwise we cant inspect the type of the array');
            }

            $items = $this->transform($schema[0] ?? null, $definitions);

            return (object) [
                'type' => 'array',
                'items' => $items,
            ];
        } elseif (is_string($schema)) {
            return (object) [
                'type' => 'string',
            ];
        } elseif (is_bool($schema)) {
            return (object) [
                'type' => 'boolean',
            ];
        } elseif (is_int($schema)) {
            return (object) [
                'type' => 'integer',
            ];
        } elseif (is_float($schema)) {
            return (object) [
                'type' => 'number',
            ];
        } else {
            return (object) [
                'type' => 'any',
            ];
        }
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "productId": 1,
  "productName": "foobar",
  "price": 12.99,
  "tags": ["foo", "bar"],
  "dimensions": {
    "length": 0,
    "width": 0,
    "height": 0
  }
}
JSON;
    }
}
