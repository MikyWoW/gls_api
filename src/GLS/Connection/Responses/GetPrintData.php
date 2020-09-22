<?php declare(strict_types=1);

namespace GLS;

class GetPrintDataResponse
{
	/** @var PrintDataInfo[] */
	public array $PrintDataInfoList;

	/** @var ErrorInfo[] */
	public array $ErrorInfoList;

	/**
	* @param PrintDataInfo[] $PrintDataInfoList
	* @param ErrorInfo[] $ErrorInfoList
	*/
	public function __construct(array $PrintDataInfoList, array $ErrorInfoList)
	{
		$this->PrintDataInfoList = $PrintDataInfoList;
		$this->ErrorInfoList = $ErrorInfoList;
	}
}