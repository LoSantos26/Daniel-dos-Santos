<?php

namespace Src\domain\File\Entities;

class FileContent
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
        private ?int $id,
        private string $rptDt,
        private ?string $tckrSymb,
        private ?string $mktNm,
        private ?string $sctyCtgyNm,
        private ?string $isin,
        private ?string $crpnNm
    )
    {}

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRptDt(): string
    {
        return $this->rptDt;
    }

    /**
     * @return string|null
     */
    public function getTckrSymb(): ?string
    {
        return $this->tckrSymb;
    }

    /**
     * @return string|null
     */
    public function getMktNm(): ?string
    {
        return $this->mktNm;
    }

    /**
     * @return string|null
     */
    public function getSctyCtgyNm(): ?string
    {
        return $this->sctyCtgyNm;
    }

    /**
     * @return string|null
     */
    public function getIsin(): ?string
    {
        return $this->isin;
    }

    /**
     * @return string|null
     */
    public function getCrpnNm(): ?string
    {
        return $this->crpnNm;
    }
}
