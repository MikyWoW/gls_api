<?php declare(strict_types=1);

namespace GLS;

class GetPrintedLabelsRequest extends Request
{
	/** @var int[] */
	public array $ParcelIdList;

	public int $PrintPosition;

	public bool $ShowPrintDialog;

	/**
	* @param int[] $ParcelIdList
	*/
	public function __construct(array $ParcelIdList, int $PrintPosition, bool $ShowPrintDialog)
	{
		$this->ParcelIdList = $ParcelIdList;
		$this->PrintPosition = $PrintPosition;
		$this->ShowPrintDialog = $ShowPrintDialog;
	}
}