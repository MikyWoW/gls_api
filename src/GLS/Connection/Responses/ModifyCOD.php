<?php declare(strict_types=1);

namespace GLS;

class ModifyCODResponse
{
	public bool $Successful;

	/** @var ErrorInfo[] */
	public array $ErrorInfoList;

	/**
	* @param ErrorInfo[] $ErrorInfoList
	*/
	public function __construct(bool $Successful, array $ErrorInfoList)
	{
		$this->Successful = $Successful;
		$this->ErrorInfoList = $ErrorInfoList;
	}
}