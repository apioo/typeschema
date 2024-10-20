<?php

namespace App\Controller;

use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;

class Tools extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/tools')]
    public function show(): mixed
    {
        $data = [
            'title' => 'Tools | TypeSchema',
            'method' => explode('::', __METHOD__),
        ];

        $templateFile = __DIR__ . '/../../resources/template/tools.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }
}
