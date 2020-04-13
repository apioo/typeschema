<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\RequestInterface;
use PSX\Http\ResponseInterface;

class Example extends ViewAbstract
{
    public function onGet(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, __DIR__ . '/resource/example.php', []);
    }
}