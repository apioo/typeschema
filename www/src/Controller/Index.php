<?php

namespace App\Controller;

use Psr\Cache\CacheItemPoolInterface;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Client\Client;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;

class Index extends ControllerAbstract
{
    private CacheItemPoolInterface $cache;
    private ReverseRouter $reverseRouter;

    public function __construct(CacheItemPoolInterface $cache, ReverseRouter $reverseRouter)
    {
        $this->cache = $cache;
        $this->reverseRouter = $reverseRouter;
    }

    #[Get]
    #[Path('/')]
    public function show(): mixed
    {
        $item = $this->cache->getItem('example-cache');
        if (!$item->isHit()) {
            $examples = $this->getExamples();
            foreach ($examples as $key => $example) {
                $types = GeneratorFactory::getPossibleTypes();
                foreach ($types as $type) {
                    $examples[$key]['types'][$type] = $this->convert($type, $example['schema']);
                }
            }

            $item->expiresAfter(null);
            $item->set($examples);
            $this->cache->save($item);
        } else {
            $examples = $item->get();
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'examples' => $examples
        ];

        $templateFile = __DIR__ . '/../../resources/template/index.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function convert(string $type, string $code): string
    {
        $httpClient = new Client();
        $parser = new TypeSchema(TypeSchema\ImportResolver::createDefault($httpClient), __DIR__ . '/../../resources/examples');
        $schema = $parser->parse($code);

        $factory = new GeneratorFactory();
        $generator = $factory->getGenerator($type);

        return (string) $generator->generate($schema);
    }

    private function getExamples(): array
    {
        $examples = [];
        $examples[] = [
            'title' => 'Simple model',
            'description' => 'A simple model with some scalar properties.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/simple.json'),
        ];

        $examples[] = [
            'title' => 'Model with inheritance',
            'description' => 'A student class which extends from the human class.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/inheritance.json'),
        ];

        $examples[] = [
            'title' => 'Model with reference',
            'description' => 'A student class which reference a faculty class.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/reference.json'),
        ];

        $examples[] = [
            'title' => 'Map with string values',
            'description' => 'A student class which contains a map with arbitrary string properties.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/map.json'),
        ];

        $examples[] = [
            'title' => 'Inline map with string values',
            'description' => 'A student class which contains an inline map with arbitrary string properties.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/map_inline.json'),
        ];

        $examples[] = [
            'title' => 'Model with discriminator',
            'description' => 'A model which contains a union type.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/discriminator.json'),
        ];

        $examples[] = [
            'title' => 'Advanced model which uses generics',
            'description' => 'A generic map which uses a specific model.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/generic.json'),
        ];

        $examples[] = [
            'title' => 'Import other TypeSchema specification',
            'description' => 'Shows how to import and use another TypeSchema.',
            'schema' => file_get_contents(__DIR__ . '/../../resources/examples/import.json'),
        ];

        return $examples;
    }
}
