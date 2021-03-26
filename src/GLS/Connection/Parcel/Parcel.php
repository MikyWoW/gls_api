<?php declare(strict_types=1);

namespace GLS;

class Parcel
{
	/**
	* Unique client number provided by GLS company. REQUIRED
	*/
	public int $ClientNumber;

	/**
	* Client custom tag identifying parcel. STRONGLY RECOMMENDED
	*/
	public string $ClientReference;

	/**
	* Count of parcels sent in one shipment. (1 >= x <= 99) DEFAULT 1
	*/
	public int $Count = 1;

	/**
	* Cash on delivery amount. NOT REQUIRED
	*/
	public float $CODAmount;

	/**
	* Cash on delivery client reference number used for payment pairing. REQUIRED if CODAmount is filled.
	*/
	public string $CODReference;

	/**
	* Parcel info printed on label.
	*/
	public string $Content;

	/**
	* Pick up date. DEFAULT actual date
	*/
	public string $PickupDate;

	/**
	* The address of place where courier pick up the shipment. REQUIRED
	*/
	public Address $PickupAddress;

	/**
	* The address of destination place. REQUIRED
	*/
	public Address $DeliveryAddress;

	/**
	* Services and their special parameters.
	* @var Service[]
	*/
	public array $ServiceList = [];

	public function __construct(int $ClientNumber, Address $PickupAddress, Address $DeliveryAddress)
	{
		$this->ClientNumber = $ClientNumber;
		$this->PickupAddress = $PickupAddress;
		$this->DeliveryAddress = $DeliveryAddress;
	}

	/**
	* Pick up date. DEFAULT actual date
	*/
	public function setPickupDate(\DateTime $date)
	{
		$this->PickupDate = '/Date('.$date->getTimestamp().'000)/';
	}

	/**
	* Service guaranteed delivery shipment in 24 Hours
	*/
	public function add24H()
	{
		$s = new Service('24H');
		$this->ServiceList[] = $s;
	}

	/**
	* Agreement about Dangerous goods by Road !NOT IMPLEMENTED!
	*/
	public function addADR($AdrItemType,$AmountUnit,$InnerCount,$PackSize,$UnNumber)
	{
		throw new \Exception("Not implemented exception.");
	}

	/**
	* Addressee Only Service
	*/
	public function addAOS($Value)
	{
		$s = new Service('AOS');
		$s->AOSParameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* Cash On Delivery service
	*/
	public function addCOD(float $CODAmount, string $CODReference)
	{
		$s = new Service('COD');
		$this->ServiceList[] = $s;

		$this->CODAmount = $CODAmount;
		$this->CODReference = $CODReference;
	}

	/**
	* Contact Service
	*/
	public function addCS1($Value)
	{
		$s = new Service('SC1');
		$s->SC1Parameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* Delivery At Work service
	*/
	public function addDAW()
	{
		$s = new Service('DAW');
		$this->ServiceList[] = $s;
	}

	/**
	* Day Definite Service
	*/
	public function addDDS(\DateTime $date)
	{
		$s = new Service('DDS');
		$s->DDSParameter['Value'] = date_format($date, 'Y-m-d');
		$this->ServiceList[] = $s;
	}

	/**
	* Declared Parcel Value service
	*/
	public function addDPV(string $StringValue,float $DecimalValue)
	{
		$s = new Service('DPV');
		$s->DPVParameter['DecimalValue'] = $DecimalValue;
		$s->DPVParameter['StringValue'] = $StringValue;
		$this->ServiceList[] = $s;
	}

	/**
	* Flexible Delivery Service
	*/
	public function addFDS($Value)
	{
		$s = new Service('FDS');
		$s->FDSParameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* Flexible delivery Sms Service
	*/
	public function addFSS($Value)
	{
		$s = new Service('FSS');
		$s->FSSParameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* Insurance Service
	*/
	public function addINS(float $Value)
	{
		$s = new Service('INS');
		$s->INSParameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* LDS
	*/
	public function addLDS()
	{
		$s = new Service('LDS');
		$this->ServiceList[] = $s;
	}

	/**
	* MCC
	*/
	public function addMCC()
	{
		$s = new Service('MCC');
		$this->ServiceList[] = $s;
	}

	/**
	* Middle Man Price service !NOT IMPLEMENTED!
	*/
	public function addMMP($Value)
	{
		throw new \Exception("Not implemented exception.");
	}

	/**
	* PCC
	*/
	public function addPCC()
	{
		$s = new Service('PCC');
		$this->ServiceList[] = $s;
	}

	/**
	* PRS
	*/
	public function addPRS()
	{
		$s = new Service('PRS');
		$this->ServiceList[] = $s;
	}

	/**
	* Parcel Shop Delivery service
	*/
	public function addPSD(int $DropOffPointID)
	{
		$s = new Service('PSD');
		$s->PSDParameter['IntegerValue'] = $DropOffPointID;
		$this->ServiceList[] = $s;
	}

	/**
	* Pick & Ship Service
	*/
	public function addPSS()
	{
		$s = new Service('PSS');
		$this->ServiceList[] = $s;
	}

	/**
	* SATurday service
	*/
	public function addSAT()
	{
		$s = new Service('SAT');
		$this->ServiceList[] = $s;
	}

	/**
	* Stand By Service
	*/
	public function addSBS()
	{
		$s = new Service('SBS');
		$this->ServiceList[] = $s;
	}

	/**
	* Scheduled Delivery Service
	*/
	public function addSDS(\DateTime $TimeFrom, \DateTime $TimeTo)
	{
		$s = new Service('SDS');
		$s->SDSParameter['TimeFrom'] = '/Date('.$TimeFrom->getTimestamp().'000)/';
		$s->SDSParameter['TimeTo'] = '/Date('.$TimeTo->getTimestamp().'000)/';
		$this->ServiceList[] = $s;
	}

	/**
	* SMs service phone nuber and text of SMS
	* Example: "+36701234567|#ParcelNr# - Test message.
	* Variables: #ParcelNr#, #COD#, #PickupDate#, #From_Name#, #ClientRef#
	*/
	public function addSM1($Value)
	{
		$s = new Service('SM1');
		$s->SM1Parameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* SMs pre-advice
	*/
	public function addSM2($Value)
	{
		$s = new Service('SM2');
		$s->SM2Parameter['Value'] = $Value;
		$this->ServiceList[] = $s;
	}

	/**
	* SRS
	*/
	public function addSRS()
	{
		$s = new Service('SRS');
		$this->ServiceList[] = $s;
	}

	/**
	* document return service (SZáLlítólevél visszaforgatás) !NOT IMPLEMENTED!
	*/
	public function addSZL($Value)
	{
		throw new \Exception("Not implemented exception.");
	}

	/**
	* Express service T09
	*/
	public function addT09()
	{
		$s = new Service('T09');
		$this->ServiceList[] = $s;
	}

	/**
	* Express service T10
	*/
	public function addT10()
	{
		$s = new Service('T10');
		$this->ServiceList[] = $s;
	}

	/**
	* Express service T12
	*/
	public function addT12()
	{
		$s = new Service('T12');
		$this->ServiceList[] = $s;
	}

	/**
	* Think Green Service
	*/
	public function addTGS()
	{
		$s = new Service('TGS');
		$this->ServiceList[] = $s;
	}

	/**
	* Exchange Service
	*/
	public function addXS()
	{
		$s = new Service('XS');
		$this->ServiceList[] = $s;
	}
}