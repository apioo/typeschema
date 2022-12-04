<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\Environment\HttpContextInterface;

class Ecosystem extends ViewAbstract
{
    public function doGet(HttpContextInterface $context): mixed
    {
        return $this->render(__DIR__ . '/resource/ecosystem.php', [
            'controller' => __CLASS__,
        ]);
    }
}
