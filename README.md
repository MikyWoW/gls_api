# GLS myAPI
Implementation of GLS Json API and generaiting ZPL code for printer.
PHP 7.4 required

## Usage

```php
$ClientNumber = 123456789; // Unique client number provided by GLS company.
$connection = new GLS\Connection('example@example.com','password', GLS\Country::CZECHIA);

/** @var GLS\Parcel[] */
$parcels = [];

$pickupAddress = new GLS\Address;
$pickupAddress->Name = 'Company name';
$pickupAddress->Street = 'Nunn Street';
$pickupAddress->HouseNumber = '123';
$pickupAddress->HouseNumberInfo = '88B';
$pickupAddress->City = 'Lyki Valley';
$pickupAddress->ZipCode = '12345';
$pickupAddress->CountryIsoCode = 'CZ';
$pickupAddress->ContactName = 'Jareth Mcarthur';
$pickupAddress->ContactPhone = '123456789';
$pickupAddress->ContactEmail = 'Jareth@example.com';

$deliveryAddress = new GLS\Address;
$deliveryAddress->Name = 'Jeffery Fox';
$deliveryAddress->Street = 'Winston Road';
$deliveryAddress->HouseNumber = '256';
$deliveryAddress->HouseNumberInfo = '1';
$deliveryAddress->City = 'Meststoke River';
$deliveryAddress->ZipCode = '43210';
$deliveryAddress->CountryIsoCode = 'CZ';
$deliveryAddress->ContactName = 'Jeffery Fox';
$deliveryAddress->ContactPhone = '123456789';
$deliveryAddress->ContactEmail = 'Jeffery@example.com';

$variableSymbol = '1234567890';
$parcel = new GLS\Parcel($ClientNumber,$pickupAddress,$deliveryAddress);
$parcel->addCOD(2000,$variableSymbol);
$parcel->setPickupDate(new DateTime());
$parcel->Count = 1;

$parcel->ClientReference = $variableSymbol; // custom ID for identification. Important for error handling more parcels at once
$parcel->Content = 'Custom text on ticket';

$parcels[] = $parcel;

```

### Add parcel and get PDF

```php

try
{
    $response = $connection->PrintLabels($parcels);
    if($response->ErrorInfoList)
    {
        foreach($response->ErrorInfoList as $e)
        {
            echo 'Error in parcel: ' . implode(", ",$e->ClientReferenceList) . ' Desc: ' . $e->ErrorDescription . PHP_EOL;
        }
    }
    else
    {
        file_put_contents('Labels.pdf', $response->Labels);
    }
}
catch (\Throwable $e)
{
    echo $e->getMessage();
}
```

### Add parcel and get generate ZPL code

```php

$lang = new GLS\Language;
$lang->Amount = 'Množství:';
$lang->COD = 'Dobírka na prvním balíku';
$lang->Depot = 'Depo:';
$lang->Driver = 'Řidič:';
$lang->glsText = 'Informace o ochraně osobních údajů v síti GLS Group naleznete na gls-group.eu/dataprotection';
$lang->Recipient = 'Příjemce:';
$lang->Sender = 'Odesílatel:';
$lang->Sort = 'Sort:';
$lang->DateFormat = 'd.m.Y';

try
{
    $response = $connection->GetPrintData($parcels);
    if($response->ErrorInfoList)
    {
        foreach($response->ErrorInfoList as $e)
        {
            echo 'Error in parcel: ' . implode(", ",$e->ClientReferenceList) . ' Desc: ' . $e->ErrorDescription . PHP_EOL;
        }
    }
    else
    {
        $zpl = '';
        foreach($response->PrintDataInfoList as $p)
        {
            $zpl .= GLS\Ticket::getTicket($p, 'CZK', $lang);
        }
        file_put_contents('Labels.zpl', $zpl);
    }
}
catch (\Throwable $e)
{
    echo $e->getMessage();
}
```