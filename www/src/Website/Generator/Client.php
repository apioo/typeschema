<?php

namespace App\Website\Generator;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Http\Exception\MovedPermanentlyException;

class Client extends ViewAbstract
{
    protected function doGet(HttpContextInterface $context): mixed
    {
        throw new MovedPermanentlyException('https://sdkgen.app/');
    }
}
