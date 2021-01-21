<?php declare(strict_types=1);

namespace GLS;

class GetParcelListRequest extends Request
{
    public string $PickupDateFrom;
    public string $PickupDateTo;
    public string $PrintDateFrom;
    public string $PrintDateTo;

	public function __construct(\DateTime $DateFrom, \DateTime $DateTo, bool $byPrint = false)
	{
        $DateFrom = '/Date('.$DateFrom->getTimestamp().'000)/';
        $DateTo = '/Date('.$DateTo->getTimestamp().'000)/';
        if($byPrint)
		{
			$this->PrintDateFrom = $DateFrom;
			$this->PrintDateTo = $DateTo;
		}
		else
		{
			$this->PickupDateFrom = $DateFrom;
			$this->PickupDateTo = $DateTo;
		}
	}
}
