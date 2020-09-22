<?php declare(strict_types=1);

namespace GLS;

class PrintLabelsRequest extends Request
{
	/** @var Parcel[] */
	public array $ParcelList;

	public int $PrintPosition;

	public bool $ShowPrintDialog;

	/**
	* @param Parcel[] $ParcelList
	*/
	public function __construct(array $ParcelList, int $PrintPosition, bool $ShowPrintDialog)
	{
		$this->ParcelList = $ParcelList;
		$this->PrintPosition = $PrintPosition;
		$this->ShowPrintDialog = $ShowPrintDialog;
	}
}