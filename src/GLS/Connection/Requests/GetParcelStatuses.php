<?php declare(strict_types=1);

namespace GLS;

class GetParcelStatusesRequest extends Request
{
    public int $ParcelNumber;
    public bool $ReturnPOD;
    public string $LanguageIsoCode;

    public function __construct(int $ParcelNumber, bool $ReturnPOD, string $LanguageIsoCode)
    {
        $this->ParcelNumber = $ParcelNumber;
        $this->ReturnPOD = $ReturnPOD;
        $this->LanguageIsoCode = $LanguageIsoCode;
    }
}