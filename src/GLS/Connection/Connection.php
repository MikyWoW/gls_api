<?php declare(strict_types=1);

namespace GLS;

class Connection
{
	private string $username;
	private array $password;
	private string $baseUrl;

	/**
	 * Create connection to GLS
	 * @param string $username Username
	 * @param string $password Password
	 * @param int $country GLS\Country
	 * @param bool $test Test endpoint
	 */
	public function __construct(string $username, string $password, int $country, bool $test = false)
	{
		$this->username = $username;
		$this->password = self::passwordToArray($password);
		$this->baseUrl = self::getBaseUrl($country,$test);
	}

	private static function parsePDF(array $data) : string
	{
		return implode(array_map('chr', $data));
	}

	private static function getTLD(int $country) : string
	{
		$tld = '';
		switch ($country) {
			case 1:
				$tld = 'hr';
				break;
			case 2:
				$tld = 'cz';
				break;
			case 3:
				$tld = 'hu';
				break;
			case 4:
				$tld = 'ro';
				break;
			case 5:
				$tld = 'si';
				break;
			case 6:
				$tld = 'sk';
				break;
			default:
				throw new \Exception("Invalid country!");
				break;
		}
		return $tld;
	}

	private static function getBaseUrl(int $country, bool $test) : string
	{
		$t = $test ? 'test.':'';
		return 'https://api.'. $t .'mygls.' . self::getTLD($country) . '/ParcelService.svc/json/';
	}

	private static function passwordToArray(string $password) : array
	{
		return array_values(unpack('C*', hash('sha512', $password, true)));
	}

	private function getResponse(string $method, Request $request) : object
	{
		$request->Username = $this->username;
		$request->Password = $this->password;
		$request = json_encode($request);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_URL, $this->baseUrl . $method);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/json', 'Content-Length: ' . strlen($request)));
		
		$response = curl_exec($curl);
		if ($response === false)
		{
			throw new \Exception(curl_error($curl));
		}

		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		switch ($httpcode)
		{
			case 200:
				break;
			case 400:
				throw new \Exception('Bad Request 400: invalid data.');
				break;
			case 401:
				throw new \Exception('Unauthorized 401: invalid username or password.');
				break;
			case 404:
				throw new \Exception('Not Found 404: invalid url path.');
				break;
			default:
				throw new \Exception('Error '.$httpcode);
				break;
		}
		curl_close($curl);

		return json_decode($response);
	}

	/**
	 * Validates parcel data for labels and adds valid parcel data to database.
	 * @param Parcel[] $ParcelList
	 */
	public function PrepareLabels(array $ParcelList) : PrepareLabelsResponse
	{
		$response = $this->getResponse('PrepareLabels', new PrepareLabelsRequest($ParcelList));
		return new PrepareLabelsResponse($response->ParcelInfoList, $response->PrepareLabelsError);
	}

	/**
	 * Generates parcel numbers and PDF document contains labels in byte array format.
	 * @param int[] $ParcelIdList
	 */
	public function GetPrintedLabels(array $ParcelIdList, int $PrintPosition = 1, bool $ShowPrintDialog = false) : GetPrintedLabelsResponse
	{
		if($PrintPosition < 1 || $PrintPosition > 4)
		{
			throw new \Exception('Invalid print position. Accepted values: 1, 2, 3 or 4');
		}
		$response = $this->getResponse('GetPrintedLabels', new GetPrintedLabelsRequest($ParcelIdList,$PrintPosition,$ShowPrintDialog));
		$pdf = '';
		if($response->Labels)
		{
			$pdf = self::parsePDF($response->Labels);
		}
		return new GetPrintedLabelsResponse($pdf,$response->GetPrintedLabelsErrorList);
	}

	/**
	 * Calls both PrepareLabels and GetPrintedLabels in one step.
	 * So, it validates parcel data for labels, adds valid parcel data to database, generates parcel numbers and PDF document containing labels in byte array format.
	 */
	public function PrintLabels(array $ParcelList, int $PrintPosition = 1, bool $ShowPrintDialog = false) : PrintLabelsResponse
	{
		if($PrintPosition < 1 || $PrintPosition > 4)
		{
			throw new \Exception('Invalid print position. Accepted values: 1, 2, 3 or 4');
		}

		$response = $this->getResponse('PrintLabels', new PrintLabelsRequest($ParcelList,$PrintPosition,$ShowPrintDialog));
		$pdf = '';
		if($response->Labels)
		{
			$pdf = self::parsePDF($response->Labels);
		}
		return new PrintLabelsResponse($pdf,$response->PrintLabelsErrorList,$response->PrintLabelsInfoList);
	}

	/**
	 * Validates parcel data for labels, adds valid parcel data to database, generates parcel numbers and returns data for custom generating labels.
	 *  @param Parcel[] $ParcelList
	 */
	public function GetPrintData(array $ParcelList) : GetPrintDataResponse
	{
		$response = $this->getResponse('GetPrintData', new GetPrintDataRequest($ParcelList));
		return new GetPrintDataResponse($response->PrintDataInfoList,$response->GetPrintDataErrorList);
	}

	/**
	 * Set DELETED state for labels/parcels with specific database record ID. 
	 */
	public function DeleteLabels(array $ParcelIdList) : DeleteLabelsResponse
	{
		$response = $this->getResponse('DeleteLabels', new DeleteLabelsRequest($ParcelIdList));
		return new DeleteLabelsResponse($response->SuccessfullyDeletedList,$response->DeleteLabelsErrorList);
	}

	/**
	 * Changes COD amount for specific parcel.
	 */
	public function ModifyCOD(float $CODAmount, int $ParcelId, bool $isParcelNumber = false) : ModifyCODResponse
	{
		$response = $this->getResponse('ModifyCOD', new ModifyCODRequest($CODAmount, $ParcelId, $isParcelNumber));
		return new ModifyCODResponse($response->Successful,$response->ModifyCODError);
	}

	/**
	 * Get parcel(s) information by date ranges.
	 * By default it searching by pickup date. If you set $byPrint TRUE then it will search by print date
	 */
	public function GetParcelList(\DateTime $DateFrom, \DateTime $DateTo, bool $byPrint = false) : GetParcelListResponse
	{
		$response = $this->getResponse('GetParcelList',new GetParcelListRequest($DateFrom,$DateTo,$byPrint));
		return new GetParcelListResponse($response->PrintDataInfoList,$response->GetParcelListErrors);
	}

	/**
	 * Get parcel statuses.
	 * Optional POD file is in PDF format. You need set $ReturnPOD to TRUE
	 */
	public function GetParcelStatuses(int $ParcelNumber, bool $ReturnPOD = false) : GetParcelStatusResponse
	{
		$response = $this->getResponse('GetParcelStatuses', new GetParcelStatusesRequest($ParcelNumber,$ReturnPOD));
		$PDO = '';
		if(isset($response->PDO))
		{
			$PDO = self::parsePDF($response->PDO);
		}
		return new GetParcelStatusResponse($response->ClientReference,$response->DeliveryCountryCode,$response->DeliveryZipCode,$response->ParcelNumber,$PDO,$response->Weight,$response->ParcelStatusList,$response->GetParcelStatusErrors);
	}
}