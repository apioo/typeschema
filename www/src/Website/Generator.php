<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\RequestInterface;
use PSX\Http\ResponseInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\Parser\JsonSchema;

class Generator extends ViewAbstract
{
    public function onGet(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, __DIR__ . '/resource/generator.php', []);
    }

    public function onPost(RequestInterface $request, ResponseInterface $response)
    {
        $body = $this->requestReader->getBody($request);

        $type   = $body->type ?? null;
        $schema = $body->schema ?? null;
        $config = null;

        try {
            $schema = (new JsonSchema())->parse($schema);
            $generator = (new GeneratorFactory())->getGenerator($type, $config);

            $output = $generator->generate($schema);
        } catch (\Throwable $e) {
            throw $e;
        }

        $this->render($response, __DIR__ . '/resource/generator.php', [
            'type' => $type,
            'output' => $output
        ]);
    }
}
