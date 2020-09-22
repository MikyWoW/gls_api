<?php declare(strict_types=1);

namespace GLS;

class Service
{
	public string $Code;
	public array $ADRParameter;
	public array $AOSParameter;
	public array $CS1Parameter;
	public array $DDSParameter;
	public array $DPVParameter;
	public array $FDSParameter;
	public array $FSSParameter;
	public array $INSParameter;
	public array $MMPParameter;
	public array $PSDParameter;
	public array $SDSParameter;
	public array $SM1Parameter;
	public array $SM2Parameter;
	public array $SZLParameter;
	public string $Value;

	public function __construct(string $Code)
	{
		$this->Code = $Code;
	}
}