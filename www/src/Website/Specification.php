<?php

namespace App\Website;

use PSX\Framework\Controller\ViewAbstract;
use PSX\Http\Environment\HttpContextInterface;

class Specification extends ViewAbstract
{
    public function doGet(HttpContextInterface $context): mixed
    {
        $spec = file_get_contents(__DIR__ . '/../../../schema/schema.htm');

        return $this->render(__DIR__ . '/resource/specification.php', [
            'spec' => $spec
        ]);
    }
}
