<?php declare(strict_types=1);

namespace GLS;

class PrintDataInfo
{
	/**
	 * Object containing necessary data for printing labels. 
	 */
	public Parcel $Parcel;

	/**
	 * Label/Parcel database record ID.
	 */
	public int $ParcelId;

	/**
	 * Parcel number
	 */
	public int $ParcelNumber;

	/**
	 * Parcel Number With Check digit
	 */
	public int $ParcelNumberWithCheckdigit;

	/**
	 * Depot number (Maximum 7 + 1 character: Depot + Sort + B2CChar) (DEPRICATED)
	 */
	public string $DepotNumber;

	/**
	 * Tour number
	 */
	public string $Driver;

	/**
	 * Maximum 4 character
	 */
	public string $Depot;

	/**
	 * Maximum 3 character.
	 */
	public string $Sort;

	/**
	 * Possible values: B, C. 
	 */
	public string $B2CChar;
}