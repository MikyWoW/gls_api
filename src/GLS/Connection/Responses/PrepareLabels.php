<?php declare(strict_types=1);

namespace GLS;

class PrepareLabelsResponse
{
	/** @var ParcelInfo[] */
	public iterable $ParcelInfoList;

	/** @var ErrorInfo[] */
	public iterable $ErrorInfoList;

	/**
	* @param ParcelInfo[] $ParcelInfoList
	* @param ErrorInfo[] $ErrorInfoList
	*/
	public function __construct(iterable $ParcelInfoList, iterable $ErrorInfoList)
	{
		$this->ParcelInfoList = $ParcelInfoList;
		$this->ErrorInfoList = $ErrorInfoList;
	}
}

class ParcelInfo
{
    /**
     * Client custom tag identifying parcel.
     */
    public string $ClientReference;

    /**
     * Label/Parcel database record ID.
     */
    public int $ParcelId;
}