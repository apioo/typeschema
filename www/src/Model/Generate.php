<?php

declare(strict_types = 1);

namespace App\Model;


class Generate implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $namespace = null;
    protected ?string $schema = null;
    public function setNamespace(?string $namespace) : void
    {
        $this->namespace = $namespace;
    }
    public function getNamespace() : ?string
    {
        return $this->namespace;
    }
    public function setSchema(?string $schema) : void
    {
        $this->schema = $schema;
    }
    public function getSchema() : ?string
    {
        return $this->schema;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('namespace', $this->namespace);
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

