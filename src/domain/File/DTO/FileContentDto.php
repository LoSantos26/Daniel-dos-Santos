<?php

namespace Src\domain\File\DTO;

class FileContentDto
{
    public function __construct(
        public ?int $id,
        public \DateTimeImmutable $rptDt,
        public string $tckrSymb,
        public string $mktNm,
        public string $sctyCtgyNm,
        public string $isin,
        public string $crpnNm
    ) { }
}
