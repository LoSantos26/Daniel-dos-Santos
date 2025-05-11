<?php

namespace Src\domain\File\DTO;

class GetFileByFilterInputDto
{
    public function __construct(
        public ?string $filaName,
        public ?\DateTimeImmutable $sentAt
    ){ }

    public function toArray()
    {
        return [
            'file_name' => $this->filaName,
            'sent_at' => $this->sentAt,
        ];
    }
}
