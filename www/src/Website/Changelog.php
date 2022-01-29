<?php

namespace App\Website;

use PSX\Api\Attribute\Incoming;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Schema\Inspector\ChangelogGenerator;
use PSX\Schema\Inspector\SemVer;
use PSX\Schema\Parser\TypeSchema;

class Changelog extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/resource/changelog.php', [
            'left' => $this->getLeft(),
            'right' => $this->getRight(),
            'messages' => []
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $left = $record->left ?? '';
        $right = $record->right ?? '';
        $messages = [];
        try {
            $defLeft = (new TypeSchema())->parse($record->left ?? '')->getDefinitions();
            $defRight = (new TypeSchema())->parse($record->right ?? '')->getDefinitions();

            foreach ((new ChangelogGenerator())->generate($defLeft, $defRight) as $type => $message) {
                $messages[] = [$type, $message];
            }
        } catch (\Throwable $e) {
            $messages[] = [SemVer::MAJOR, $e->getMessage()];
        }

        return $this->render(__DIR__ . '/resource/changelog.php', [
            'left' => $left,
            'right' => $right,
            'messages' => $messages
        ]);
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
