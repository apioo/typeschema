<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\RequestInterface;
use PSX\Http\ResponseInterface;

class Specification extends ViewAbstract
{
    public function onGet(RequestInterface $request, ResponseInterface $response)
    {
        $spec = file_get_contents(__DIR__ . '/../../../schema/schema.htm');

        $this->render($response, __DIR__ . '/resource/specification.php', [
            'spec' => $spec
        ]);
    }
}
