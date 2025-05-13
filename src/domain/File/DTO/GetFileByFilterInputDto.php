<?php

namespace Src\domain\File\DTO;

class GetFileByFilterInputDto
{
    /**
     * @param string|null $filaName
     * @param string|null $sentAt
     */
    public function __construct(
        public ?string $filaName,
        public ?string $sentAt
    ){ }

    public function toArray()
    {
        return [
            'file_name' => $this->filaName,
            'sent_at' => $this->sentAt,
        ];
    }
}
