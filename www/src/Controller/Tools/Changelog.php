<?php

namespace App\Controller\Tools;

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
    public function __construct(private ReverseRouter $reverseRouter, private SchemaManagerInterface $schemaManager)
    {
    }

    #[Get]
    #[Path('/tools/changelog')]
    public function show(): mixed
    {
        $data = [
            'title' => 'Changelog | TypeSchema',
            'method' => explode('::', __METHOD__),
            'left' => $this->getLeft(),
            'right' => $this->getRight(),
            'messages' => []
        ];

        $templateFile = __DIR__ . '/../../../resources/template/tools/changelog.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Post]
    #[Path('/tools/changelog')]
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
            'title' => 'Changelog | TypeSchema',
            'method' => explode('::', __METHOD__),
            'left' => $left,
            'right' => $right,
            'messages' => $messages
        ];

        $templateFile = __DIR__ . '/../../../resources/template/tools/changelog.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    private function getLeft(): string
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

    private function getRight(): string
    {
        return <<<'JSON'
{
  "definitions": {
    "Student": {
      "description": "Represents a student",
      "type": "struct",
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
  "root": "Student"
}
JSON;
    }
}
