<?php declare(strict_types=1);

namespace GLS;

class GetPrintDataRequest extends Request
{
	/** @var Parcel[] */
	public array $ParcelList;

	/**
	* @param Parcel[] $ParcelList
	*/
	public function __construct(array $ParcelList)
	{
		$this->ParcelList = $ParcelList;
	}
}