<?php

namespace App\Controller\Tools;

use App\Model\Generate;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Incoming;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Api\Model\Passthru;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;

class Json extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/tools/json')]
    public function show(): mixed
    {
        $data = [
            'title' => 'JSON migration | TypeSchema',
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema()
        ];

        $templateFile = __DIR__ . '/../../../resources/template/tools/json.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/tools/json')]
    public function migrate(Generate $generate): mixed
    {
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        try {
            $definitions = [];
            $root = new \stdClass();
            $schema = $this->transform(json_decode($schema), $definitions);

            if (count($definitions) > 0) {
                $root->definitions = (object) $definitions;
            }

            if (isset($schema->target)) {
                $root->root = $schema->target;
            }

            $output = $root;
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'title' => 'JSON migration | TypeSchema',
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'output' => json_encode($output, JSON_PRETTY_PRINT)
        ];

        $templateFile = __DIR__ . '/../../../resources/template/tools/json.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function transform(mixed $schema, array &$definitions): object
    {
        if ($schema instanceof \stdClass) {
            $properties = [];
            foreach (get_object_vars($schema) as $key => $value) {
                $properties[$key] = $this->transform($value, $definitions);
            }

            $name = 'Schema' . substr(sha1(json_encode($properties)), 0, 8);

            $definitions[$name] = (object) [
                'type' => 'struct',
                'properties' => $properties,
            ];

            return (object) [
                'type' => 'reference',
                'target' => $name,
            ];
        } elseif (is_array($schema)) {
            if (count($schema) === 0) {
                throw new \RuntimeException('Array must contain a value otherwise we cant inspect the type of the array');
            }

            $items = $this->transform($schema[0] ?? null, $definitions);

            return (object) [
                'type' => 'array',
                'schema' => $items,
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
  "persons": [{
    "firstName": "foo",
    "lastName": "bar"
  }],
  "dimensions": {
    "length": 0,
    "width": 0,
    "height": 0
  }
}
JSON;
    }
}
