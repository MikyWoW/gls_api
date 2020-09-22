<?php declare(strict_types=1);

namespace GLS;

class GetParcelStatusResponse
{
    public ?string $ClientReference;

    public ?string $DeliveryCountryCode;

    public ?string $DeliveryZipCode;

    public int $ParcelNumber;

    public string $POD;

    public ?float $Weight;

    /**
     * @var ParcelStatus[]
     */
    public array $ParcelStatusList;

    /**
     * @var ErrorInfo[]
     */
    public array $ErrorInfoList;

    /**
     * @param ParcelStatus[] $ParcelStatusList
     * @param ErrorInfo[] $ErrorInfoList
     */
    public function __construct(?string $ClientReference, ?string $DeliveryCountryCode, ?string $DeliveryZipCode, int $ParcelNumber, string $POD, ?float $Weight, array $ParcelStatusList, array $ErrorInfoList)
    {
        $this->ClientReference = $ClientReference;
        $this->DeliveryCountryCode = $DeliveryCountryCode;
        $this->DeliveryZipCode = $DeliveryZipCode;
        $this->ParcelNumber = $ParcelNumber;
        $this->POD = $POD;
        $this->Weight = $Weight;
        $this->ParcelStatusList = $ParcelStatusList;
        $this->ErrorInfoList = $ErrorInfoList;
    }
}

class ParcelStatus
{
    public string $DepotCity;

    public string $DepotNumber;

    public string $StatusCode;

    public string $StatusDate;

    public string $StatusDescription;

    public string $StatusInfo;
}