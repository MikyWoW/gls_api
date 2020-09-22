<?php declare(strict_types=1);

namespace GLS;

class GetParcelStatusesRequest extends Request
{
    public int $ParcelNumber;
    public bool $ReturnPOD;
}