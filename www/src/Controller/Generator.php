<?php

namespace App\Controller;

use App\Model\Generate;
use App\Service\TypeName;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Framework\Config\ConfigInterface;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Environment\HttpResponse;
use PSX\Http\Exception\BadRequestException;
use PSX\Http\Writer\File;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaManagerInterface;

class Generator extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter, private SchemaManagerInterface $schemaManager, private ConfigInterface $config)
    {
    }

    #[Get]
    #[Path('/generator')]
    public function show(): mixed
    {
        $types = [];
        foreach (GeneratorFactory::getPossibleTypes() as $type) {
            $types[$type] = TypeName::getDisplayName($type);
        }

        $data = [
            'title' => 'DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'schema' => $this->getSchema(),
            'types' => array_chunk($types, 9, true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator_overview.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Get]
    #[Path('/generator/:type')]
    public function showType(string $type): mixed
    {
        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'schema' => $this->getSchema(),
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/:type')]
    public function generate(string $type, Generate $generate): mixed
    {
        $namespace = $generate->getNamespace();
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        $config = new Config();
        if (!empty($namespace)) {
            $config->put(Config::NAMESPACE, $namespace);
        }

        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        try {
            $result = (new TypeSchema($this->schemaManager))->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'namespace' => $namespace,
            'schema' => $schema ?? $this->getSchema(),
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
            'output' => $output,
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/:type/download')]
    public function download(string $type, Generate $generate): mixed
    {
        $namespace = $generate->getNamespace();
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        $config = new Config();
        if (!empty($namespace)) {
            $config->put(Config::NAMESPACE, $namespace);
        }

        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        try {
            $result = (new TypeSchema($this->schemaManager))->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($result);

            if ($output instanceof Chunks && $generator instanceof FileAwareInterface) {
                $zipFile = $this->config->get('psx_path_cache') . '/typeschema_gen_' . sha1($schema) . '.zip';

                $result = new Chunks();
                foreach ($output as $identifier => $code) {
                    $result->append($generator->getFileName($identifier), $generator->getFileContent($code));
                }

                $result->writeToZip($zipFile);

                return new File($zipFile, 'typeschema_' . $type . '.zip', 'application/zip');
            } else {
                return new HttpResponse(200, ['Content-Type' => 'text/plain'], (string) $output);
            }
        } catch (\Throwable $e) {
            return new HttpResponse(500, ['Content-Type' => 'text/plain'], $e->getMessage());
        }
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "definitions": {
    "Student": {
      "type": "struct",
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
  "root": "Student"
}
JSON;
    }
}
