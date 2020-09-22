<?php declare(strict_types=1);

namespace GLS;

class DeleteLabelsRequest extends Request
{
	/** @var int[] */
	public array $ParcelIdList;

	/**
	* @param int[] $ParcelIdList
	*/
	public function __construct(array $ParcelIdList)
	{
		$this->ParcelIdList = $ParcelIdList;
	}
}