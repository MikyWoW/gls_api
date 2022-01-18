<?php declare(strict_types=1);

namespace GLS;

class ModifyCODRequest extends Request
{
	/**
	 * Label/parcel database ID. REQUIRED IF ParcelNumber IS NULL
	 */
	public int $ParcelId;

	/**
	 * Parcel number. REQUIRED IF ParcelId IS NULL
	 */
	public int $ParcelNumber;

	/**
	 * Cash on delivery amount. ZERO OR POSITIVE
	 */
	public float $CODAmount;

	public function __construct(float $CODAmount, int $ParcelId, bool $isParcelNumber)
	{
		if($isParcelNumber)
		{
			$this->ParcelNumber = $ParcelId;
		}
		else
		{
			$this->ParcelId  = $ParcelId;
		}
		$this->CODAmount = $CODAmount;
	}
}