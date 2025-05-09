<?php

namespace Src\domain\File\Entities;

class FileContent
{
    public function __construct(
        private ?int $id,
        private \DateTimeImmutable $rptDt,
        private string $tckrSymb,
        private string $mktNm,
        private string $sctyCtgyNm,
        private string $isin,
        private string $crpnNm
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
     * @return \DateTimeImmutable
     */
    public function getRptDt(): \DateTimeImmutable
    {
        return $this->rptDt;
    }

    /**
     * @return string
     */
    public function getTckrSymb(): string
    {
        return $this->tckrSymb;
    }

    /**
     * @return string
     */
    public function getMktNm(): string
    {
        return $this->mktNm;
    }

    /**
     * @return string
     */
    public function getSctyCtgyNm(): string
    {
        return $this->sctyCtgyNm;
    }

    /**
     * @return string
     */
    public function getIsin(): string
    {
        return $this->isin;
    }

    /**
     * @return string
     */
    public function getCrpnNm(): string
    {
        return $this->crpnNm;
    }
}
