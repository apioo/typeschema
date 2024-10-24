<?php

namespace App\Controller;

use App\Model\Generate;
use App\Service\CaptchaVerifier;
use App\Service\TypeName;
use PSX\Api\Attribute\Body;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Param;
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
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;

class Generator extends ControllerAbstract
{
    private const MAX_SCHEMA_LENGTH = 2048;

    public function __construct(private ReverseRouter $reverseRouter, private SchemaManagerInterface $schemaManager, private ConfigInterface $config, private CaptchaVerifier $captchaVerifier)
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
            'types' => array_chunk($types, (int) ceil(count($types) / 2), true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator.php';
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
            'js' => ['https://www.google.com/recaptcha/api.js'],
            'recaptcha_key' => $this->config->get('recaptcha_key'),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator/form.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/:type')]
    public function generate(string $type, Generate $generate): mixed
    {
        [$namespace, $schema, $config, $parsedSchema] = $this->parse($type, $generate);

        try {
            $generator = (new GeneratorFactory())->getGenerator($type, $config);
            $result = $generator->generate($parsedSchema);

            if ($result instanceof Chunks && $generator instanceof FileAwareInterface) {
                $chunks = [];
                foreach ($result->getChunks() as $fileName => $code) {
                    if (is_string($code)) {
                        $chunks[$generator->getFileName($fileName)] = $generator->getFileContent($code);
                    }
                }
                $output = $chunks;
            } else {
                $output = (string) $result;
            }
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' DTO Generator | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'namespace' => $namespace,
            'schema' => $schema,
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
            'output' => $output,
            'js' => ['https://www.google.com/recaptcha/api.js'],
            'recaptcha_key' => $this->config->get('recaptcha_key'),
        ];

        $templateFile = __DIR__ . '/../../resources/template/generator/form.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/:type/download')]
    public function download(#[Param] string $type, #[Body] Generate $generate): mixed
    {
        [$namespace, $schema, $config, $parsedSchema] = $this->parse($type, $generate);

        try {
            $zipFile = $this->config->get('psx_path_cache') . '/typeschema_' . $type . '_' . sha1($schema) . '.zip';
            if (is_file($zipFile)) {
                return new File($zipFile, 'typeschema_' . $type . '.zip', 'application/zip');
            }

            $generator = (new GeneratorFactory())->getGenerator($type, $config);
            $result = $generator->generate($parsedSchema);

            if ($result instanceof Chunks && $generator instanceof FileAwareInterface) {
                $output = new Chunks();
                $this->appendOutput($result, $output, $generator);

                $output->writeToZip($zipFile);

                return new File($zipFile, 'typeschema_' . $type . '.zip', 'application/zip');
            } else {
                return new HttpResponse(200, ['Content-Type' => 'text/plain'], (string) $result);
            }
        } catch (\Throwable $e) {
            return new HttpResponse(500, ['Content-Type' => 'text/plain'], $e->getMessage());
        }
    }

    private function appendOutput(Chunks $result, Chunks $output, FileAwareInterface $generator): void
    {
        foreach ($result->getChunks() as $identifier => $code) {
            if (is_string($code)) {
                $output->append($generator->getFileName($identifier), $generator->getFileContent($code));
            }
        }
    }

    /**
     * @return array{string|null, string, Config, SchemaInterface}
     */
    private function parse(string $type, Generate $generate): array
    {
        $recaptchaSecret = $this->config->get('recaptcha_secret');
        if (!empty($recaptchaSecret) && !$this->captchaVerifier->verify($generate->getGRecaptchaResponse())) {
            throw new BadRequestException('Invalid captcha');
        }

        $namespace = $generate->getNamespace();
        $schema = $generate->getSchema() ?? throw new \RuntimeException('Provided no schema');

        if (strlen($schema) > self::MAX_SCHEMA_LENGTH) {
            throw new BadRequestException('Provided schema is too large, allowed max ' . self::MAX_SCHEMA_LENGTH . ' characters');
        }

        $config = new Config();
        if ($namespace !== null && $namespace !== '') {
            $config->put(Config::NAMESPACE, $namespace);
        }

        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        $result = (new TypeSchema($this->schemaManager))->parse($schema);

        return [$namespace, $schema, $config, $result];
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
