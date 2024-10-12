<?php

namespace App\Controller;

use App\Service\TypeName;
use Psr\Cache\CacheItemPoolInterface;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Exception\BadRequestException;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\Context\FilesystemContext;
use PSX\Schema\SchemaManagerInterface;

class Example extends ControllerAbstract
{
    private CacheItemPoolInterface $cache;
    private ReverseRouter $reverseRouter;
    private SchemaManagerInterface $schemaManager;

    public function __construct(CacheItemPoolInterface $cache, ReverseRouter $reverseRouter, SchemaManagerInterface $schemaManager)
    {
        $this->cache = $cache;
        $this->reverseRouter = $reverseRouter;
        $this->schemaManager = $schemaManager;
    }

    #[Get]
    #[Path('/example/:type')]
    public function show(string $type): mixed
    {
        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        $item = $this->cache->getItem('example-cache-' . $type);
        if (true) {
            $examples = $this->getExamples();
            foreach ($examples as $key => $example) {
                $examples[$key]['schema'] = file_get_contents($example['file']);
                $config = $example['config'][$type] ?? [];
                $examples[$key]['types'][$type] = $this->convert($type, $example['file'], $config['namespace'] ?? null, $config['mapping'] ?? null);
            }

            $item->expiresAfter(null);
            $item->set($examples);
            $this->cache->save($item);
        } else {
            $examples = $item->get();
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' Example | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'type' => TypeName::getDisplayName($type),
            'examples' => $examples,
        ];

        $templateFile = __DIR__ . '/../../resources/template/example.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function convert(string $type, string $file, ?string $namespace, ?array $mapping): string|array
    {
        $config = new Config();
        $config->put(Config::NAMESPACE, $namespace);
        $config->put(Config::MAPPING, $mapping);

        $context = new FilesystemContext(__DIR__ . '/../../resources/examples');
        $schema = $this->schemaManager->getSchema($file, $context);

        $factory = new GeneratorFactory();
        $generator = $factory->getGenerator($type, $config);

        $result = $generator->generate($schema);
        if ($result instanceof Chunks && $generator instanceof FileAwareInterface) {
            $chunks = [];
            foreach ($result->getChunks() as $fileName => $code) {
                $chunks[$generator->getFileName($fileName)] = $generator->getFileContent($code);
            }
            return $chunks;
        } else {
            return (string) $result;
        }
    }

    private function getExamples(): array
    {
        $examples = [];
        $examples[] = [
            'title' => 'Simple model',
            'description' => 'A simple model with some scalar properties.',
            'file' => __DIR__ . '/../../resources/examples/simple.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Model with inheritance',
            'description' => 'A student struct which extends from a different struct.',
            'file' => __DIR__ . '/../../resources/examples/inheritance.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Model with reference',
            'description' => 'A student struct which reference a faculty struct.',
            'file' => __DIR__ . '/../../resources/examples/reference.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Map with string values',
            'description' => 'A student struct which contains a map with arbitrary string values.',
            'file' => __DIR__ . '/../../resources/examples/map_inline.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Model with discriminator',
            'description' => 'A struct which uses a discriminator mapping.',
            'file' => __DIR__ . '/../../resources/examples/discriminator.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Model with generics',
            'description' => 'A struct which uses generics.',
            'file' => __DIR__ . '/../../resources/examples/generic.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
            ],
        ];

        $examples[] = [
            'title' => 'Import other TypeSchema specification',
            'description' => 'A struct which references an external TypeSchema.',
            'file' => __DIR__ . '/../../resources/examples/import.json',
            'config' => [
                'csharp' => ['namespace' => 'TypeSchema.DTO'],
                'go' => ['namespace' => 'TypeSchema'],
                'java' => ['namespace' => 'org.typeschema.dto'],
                'php' => ['namespace' => 'TypeSchema\\DTO'],
                'ruby' => ['namespace' => 'TypeSchema'],
                'typescript' => ['mapping' => ['my_ns' => './']]
            ],
        ];

        return $examples;
    }
}
