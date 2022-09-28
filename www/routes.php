<?php

return [

    [['ANY'], '/', App\Website\Index::class],
    [['ANY'], '/specification', App\Website\Specification::class],
    [['ANY'], '/developer', App\Website\Developer::class],
    [['ANY'], '/ecosystem', App\Website\Ecosystem::class],
    [['ANY'], '/faq', App\Website\Faq::class],
    [['ANY'], '/generator/client', App\Website\Generator\Client::class],
    [['ANY'], '/generator/schema', App\Website\Generator\Schema::class],
    [['ANY'], '/generator/changelog', \App\Website\Generator\Changelog::class],
    [['ANY'], '/migration/jsonschema', App\Website\Migration\JsonSchema::class],
    [['ANY'], '/migration/openapi', App\Website\Migration\OpenAPI::class],
    [['ANY'], '/migration/json', App\Website\Migration\Json::class],

];
