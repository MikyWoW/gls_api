<?php declare(strict_types=1);

namespace GLS;

class DeleteLabelsResponse
{
	/** @var SuccessfullyDeleted[] */
	public array $SuccessfullyDeletedList;

	/** @var ErrorInfo[] */
	public array $ErrorInfoList;

	/**
	* @param ErrorInfo[] $ErrorInfoList
	* @param SuccessfullyDeleted[] $SuccessfullyDeletedList
	*/
	public function __construct(array $SuccessfullyDeletedList, array $ErrorInfoList)
	{
		$this->SuccessfullyDeletedList = $SuccessfullyDeletedList;
		$this->ErrorInfoList = $ErrorInfoList;
	}
}

class SuccessfullyDeleted
{
	public int $ParcelId;
	public array $SubParcelIdList;
}