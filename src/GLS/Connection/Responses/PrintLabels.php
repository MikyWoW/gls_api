<?php declare(strict_types=1);

namespace GLS;

class PrintLabelsResponse
{
	public string $Labels;

	/** @var ErrorInfo[] */
	public array $ErrorInfoList;

	/** @var ParcelInfo[] */
	public array $ParcelInfoList;

	/**
	* @param ErrorInfo[] $ErrorInfoList
	*/
	public function __construct(string $Labels, array $ErrorInfoList, array $ParcelInfoList)
	{
		$this->Labels = $Labels;
		$this->ErrorInfoList = $ErrorInfoList;
		$this->ParcelInfoList = $ParcelInfoList;
	}
}