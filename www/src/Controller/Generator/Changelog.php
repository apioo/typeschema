<?php

namespace App\Controller\Generator;

use App\Model\Diff;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Api\Attribute\Post;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Schema\Inspector\ChangelogGenerator;
use PSX\Schema\Inspector\SemVer;
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\SchemaManagerInterface;

class Changelog extends ControllerAbstract
{
    private ReverseRouter $reverseRouter;
    private SchemaManagerInterface $schemaManager;

    public function __construct(ReverseRouter $reverseRouter, SchemaManagerInterface $schemaManager)
    {
        $this->reverseRouter = $reverseRouter;
        $this->schemaManager = $schemaManager;
    }

    #[Get]
    #[Path('/generator/changelog')]
    public function show(): mixed
    {
        $data = [
            'method' => explode('::', __METHOD__),
            'left' => $this->getLeft(),
            'right' => $this->getRight(),
            'messages' => []
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/changelog.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/generator/changelog')]
    public function generate(Diff $diff): mixed
    {
        $left = $diff->getLeft() ?? throw new \RuntimeException('Provided no left');
        $right = $diff->getRight() ?? throw new \RuntimeException('Provided no right');
        $messages = [];
        try {
            $defLeft = (new TypeSchema($this->schemaManager))->parse($left)->getDefinitions();
            $defRight = (new TypeSchema($this->schemaManager))->parse($right)->getDefinitions();

            foreach ((new ChangelogGenerator())->generate($defLeft, $defRight) as $type => $message) {
                $messages[] = [$type, $message];
            }
        } catch (\Throwable $e) {
            $messages[] = [SemVer::MAJOR, $e->getMessage()];
        }

        $data = [
            'method' => explode('::', __METHOD__),
            'left' => $left,
            'right' => $right,
            'messages' => $messages
        ];

        $templateFile = __DIR__ . '/../../../resources/template/generator/changelog.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function getLeft(): string
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

    private function getRight(): string
    {
        return <<<'JSON'
{
  "definitions": {
    "Student": {
      "description": "Represents a student",
      "type": "object",
      "properties": {
        "firstName": {
          "type": "string"
        },
        "lastName": {
          "type": "string"
        },
        "gender": {
          "type": "string"
        },
        "age": {
          "type": "string"
        }
      }
    }
  },
  "$ref": "Student"
}
JSON;
    }
}
