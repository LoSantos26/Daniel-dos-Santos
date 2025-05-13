<?php

namespace Src\domain\File\DTO;

class FileContentDto
{
    /**
     * @param int|null $id
     * @param string $rptDt
     * @param string|null $tckrSymb
     * @param string|null $mktNm
     * @param string|null $sctyCtgyNm
     * @param string|null $isin
     * @param string|null $crpnNm
     */
    public function __construct(
        public ?int $id,
        public string $rptDt,
        public ?string $tckrSymb,
        public ?string $mktNm,
        public ?string $sctyCtgyNm,
        public ?string $isin,
        public ?string $crpnNm
    ) { }
}
