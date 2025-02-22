<?php

declare(strict_types = 1);

namespace App\Model;


class Diff implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $left = null;
    protected ?string $right = null;
    public function setLeft(?string $left): void
    {
        $this->left = $left;
    }
    public function getLeft(): ?string
    {
        return $this->left;
    }
    public function setRight(?string $right): void
    {
        $this->right = $right;
    }
    public function getRight(): ?string
    {
        return $this->right;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('left', $this->left);
        $record->put('right', $this->right);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

