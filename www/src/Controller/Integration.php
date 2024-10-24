<?php

namespace App\Controller;

use App\Service\TypeName;
use PSX\Api\Attribute\Get;
use PSX\Api\Attribute\Path;
use PSX\Framework\Controller\ControllerAbstract;
use PSX\Framework\Http\Writer\Template;
use PSX\Framework\Loader\ReverseRouter;
use PSX\Http\Exception\BadRequestException;
use PSX\Schema\GeneratorFactory;

class Integration extends ControllerAbstract
{
    public function __construct(private ReverseRouter $reverseRouter)
    {
    }

    #[Get]
    #[Path('/integration')]
    public function show(): mixed
    {
        $types = [];
        foreach (GeneratorFactory::getPossibleTypes() as $type) {
            $dtoFile = __DIR__ . '/../../resources/template/integration/' . $type . '_dto.txt';
            $integrationFile = __DIR__ . '/../../resources/template/integration/' . $type . '_integration.txt';

            if (!is_file($dtoFile) || !is_file($integrationFile)) {
                continue;
            }

            $types[$type] = TypeName::getDisplayName($type);
        }

        $data = [
            'title' => 'Integration | TypeSchema',
            'method' => explode('::', __METHOD__),
            'types' => array_chunk($types, (int) ceil(count($types) / 2), true),
        ];

        $templateFile = __DIR__ . '/../../resources/template/integration.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }

    #[Get]
    #[Path('/integration/:type')]
    public function showType(string $type): mixed
    {
        if (!in_array($type, GeneratorFactory::getPossibleTypes())) {
            throw new BadRequestException('Provided an invalid type');
        }

        $dtoFile = __DIR__ . '/../../resources/template/integration/' . $type . '_dto.txt';
        $integrationFile = __DIR__ . '/../../resources/template/integration/' . $type . '_integration.txt';

        if (!is_file($dtoFile) || !is_file($integrationFile)) {
            throw new BadRequestException('No integration available for the provided type');
        }

        $data = [
            'title' => TypeName::getDisplayName($type) . ' Integration | TypeSchema',
            'method' => explode('::', __METHOD__),
            'parameters' => ['type' => $type],
            'dto' => file_get_contents($dtoFile),
            'integration' => file_get_contents($integrationFile),
            'type' => $type,
            'typeName' => TypeName::getDisplayName($type),
        ];

        $templateFile = __DIR__ . '/../../resources/template/integration/detail.php';
        return new Template($data, $templateFile, $this->reverseRouter);
    }
}
