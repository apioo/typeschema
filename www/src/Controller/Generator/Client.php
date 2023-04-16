<?php

namespace App\Controller\Generator;

use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\Exception\MovedPermanentlyException;

class Client extends ControllerAbstract
{
    #[Get]
    #[Path('/generator/client')]
    protected function redirect(): mixed
    {
        throw new MovedPermanentlyException('https://sdkgen.app/');
    }
}
