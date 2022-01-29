<?php

namespace App\Website\Generator;

use PSX\Api\Attribute\Incoming;
use PSX\Api\Parser\OpenAPI;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Framework\Schema\Passthru;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Api\GeneratorFactory;
use PSX\Http\Writer\File;
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Parser\TypeSchema;

class Client extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/../resource/generator/client.php', [
            'schema' => $this->getSchema(),
            'types' => GeneratorFactory::getPossibleTypes(),
        ]);
    }

    #[Incoming(Passthru::class)]
    protected function doPost(mixed $record, HttpContextInterface $context): mixed
    {
        $type   = $record->type ?? null;
        $schema = $record->schema ?? null;
        $config = null;

        try {
            $result = (new OpenAPI())->parse($schema);
            $generator = (new GeneratorFactory('TypeSchema', 'https://acme.com', ''))->getGenerator($type, $config);

            $output = $generator->generate($result);

            if ($output instanceof Chunks) {
                $file = PSX_PATH_CACHE . '/' . uniqid('client-') . '.zip';
                $output->writeTo($file);

                return new File($file, $type . '.zip', 'application/zip');
            }
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }

        return $this->render(__DIR__ . '/../resource/generator/client.php', [
            'schema' => $schema,
            'types' => GeneratorFactory::getPossibleTypes(),
            'type' => $type,
            'output' => $output
        ]);
    }

    private function getSchema(): string
    {
        return <<<'JSON'
{
  "openapi": "3.0.0",
  "info": {
    "version": "1.0.0",
    "title": "Swagger Petstore",
    "license": {
      "name": "MIT"
    }
  },
  "servers": [
    {
      "url": "http:\/\/petstore.swagger.io\/v1"
    }
  ],
  "paths": {
    "\/pets": {
      "get": {
        "summary": "List all pets",
        "operationId": "listPets",
        "tags": [
          "pets"
        ],
        "parameters": [
          {
            "name": "limit",
            "in": "query",
            "description": "How many items to return at one time (max 100)",
            "required": false,
            "schema": {
              "type": "integer",
              "format": "int32"
            }
          }
        ],
        "responses": {
          "200": {
            "description": "A paged array of pets",
            "headers": {
              "x-next": {
                "description": "A link to the next page of responses",
                "schema": {
                  "type": "string"
                }
              }
            },
            "content": {
              "application\/json": {
                "schema": {
                  "$ref": "Pets"
                }
              }
            }
          },
          "default": {
            "description": "unexpected error",
            "content": {
              "application\/json": {
                "schema": {
                  "$ref": "Error"
                }
              }
            }
          }
        }
      },
      "post": {
        "summary": "Create a pet",
        "operationId": "createPets",
        "tags": [
          "pets"
        ],
        "responses": {
          "201": {
            "description": "Null response"
          },
          "default": {
            "description": "unexpected error",
            "content": {
              "application\/json": {
                "schema": {
                  "$ref": "Error"
                }
              }
            }
          }
        }
      }
    },
    "\/pets\/{petId}": {
      "parameters": [
        {
          "name": "petId",
          "in": "path",
          "required": true,
          "description": "The id of the pet to retrieve",
          "schema": {
            "type": "string"
          }
        }
      ],
      "get": {
        "summary": "Info for a specific pet",
        "operationId": "showPetById",
        "tags": [
          "pets"
        ],
        "responses": {
          "200": {
            "description": "Expected response to a valid request",
            "content": {
              "application\/json": {
                "schema": {
                  "$ref": "Pet"
                }
              }
            }
          },
          "default": {
            "description": "unexpected error",
            "content": {
              "application\/json": {
                "schema": {
                  "$ref": "Error"
                }
              }
            }
          }
        }
      }
    }
  },
  "components": {
    "schemas": {
      "Pet": {
        "type": "object",
        "properties": {
          "id": {
            "type": "integer"
          },
          "name": {
            "type": "string"
          },
          "tag": {
            "type": "string"
          }
        },
        "required": [
          "id",
          "name"
        ]
      },
      "Pets": {
        "type": "object",
        "properties": {
          "totalItems": {
            "type": "integer"
          },
          "items": {
            "type": "array",
            "items": {
              "$ref": "Pet"
            }
          }
        }
      },
      "Error": {
        "type": "object",
        "properties": {
          "code": {
            "type": "integer"
          },
          "message": {
            "type": "string"
          }
        },
        "required": [
          "code",
          "message"
        ]
      }
    }
  }
}
JSON;
    }
}
