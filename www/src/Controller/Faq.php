<?php

namespace App\Controller;

use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;

class Faq extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/faq')]
    public function show(): mixed
    {
        $data = [
            'title' => 'FAQ | TypeSchema',
            'method' => explode('::', __METHOD__),
        ];

        $templateFile = __DIR__ . '/../../resources/template/faq.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }
}
