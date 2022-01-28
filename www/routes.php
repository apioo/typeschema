<?php

return [

    [['GET'], '/', App\Website\Index::class],
    [['GET'], '/specification', App\Website\Specification::class],
    [['GET'], '/faq', App\Website\Faq::class],
    [['GET', 'POST'], '/generator/client', App\Website\Generator\Client::class],
    [['GET', 'POST'], '/generator/schema', App\Website\Generator\Schema::class],
    [['GET', 'POST'], '/migration/jsonschema', App\Website\Migration\JsonSchema::class],
    [['GET', 'POST'], '/migration/openapi', App\Website\Migration\OpenAPI::class],

];
