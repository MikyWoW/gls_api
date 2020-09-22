<?php declare(strict_types=1);

namespace GLS;

class GetPrintedLabelsResponse
{
	public string $Labels;

	/** @var ErrorInfo[] */
	public array $ErrorInfoList;

	/**
	* @param ErrorInfo[] $ErrorInfoList
	*/
	public function __construct(string $Labels, array $ErrorInfoList)
	{
		$this->Labels = $Labels;
		$this->ErrorInfoList = $ErrorInfoList;
	}
}