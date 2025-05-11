<?php

namespace Src\domain\File\DTO;

class GetFileContentByFilterInputDto
{
    public function __construct(
        public ?string $tckrSymb,
        public ?string $rptDt
    )
    { }

    public function toArray()
    {
        return [
            'tckr_symb' => $this->tckrSymb,
            'rpt_dt' => $this->rptDt
        ];
    }
}
