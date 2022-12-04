<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\Environment\HttpContextInterface;

class Implementation extends ViewAbstract
{
    public function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/resource/implementation.php', [
            'controller' => __CLASS__,
        ]);
    }
}
