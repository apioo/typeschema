<?php

declare(strict_types = 1);

namespace App\Model;

use PSX\Schema\Attribute\Key;

class Generate implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $namespace = null;
    protected ?string $schema = null;
    #[Key('g-recaptcha-response')]
    protected ?string $gRecaptchaResponse = null;
    public function setNamespace(?string $namespace): void
    {
        $this->namespace = $namespace;
    }
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }
    public function setSchema(?string $schema): void
    {
        $this->schema = $schema;
    }
    public function getSchema(): ?string
    {
        return $this->schema;
    }
    public function setGRecaptchaResponse(?string $gRecaptchaResponse): void
    {
        $this->gRecaptchaResponse = $gRecaptchaResponse;
    }
    public function getGRecaptchaResponse(): ?string
    {
        return $this->gRecaptchaResponse;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('namespace', $this->namespace);
        $record->put('schema', $this->schema);
        $record->put('g-recaptcha-response', $this->gRecaptchaResponse);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

