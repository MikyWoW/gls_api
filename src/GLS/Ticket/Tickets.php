<?php declare(strict_types=1);

namespace GLS;

class Ticket
{
    public static function getTicket($PrintDataInfo, string $currency = '', Language $lang)
    {
        $result = '';
        $timestamp = substr($PrintDataInfo->Parcel->PickupDate,6,10);
        $date = new \DateTime("@$timestamp");
        $date = $date->format($lang->DateFormat);

        for ($i = 0; $i < $PrintDataInfo->Parcel->Count; $i++)
        {
            $part = $i + 1;
            $barcode = substr('00000000000' . ($PrintDataInfo->ParcelNumber + $i),-11);
            $barcodeFull = $barcode . self::checkSum($barcode);

            $barcode1 = substr($barcodeFull,0,4);
            $barcode2 = substr($barcodeFull,4,7);
            $barcode3 = substr($barcodeFull,-1);

            $cod = '';
            if($PrintDataInfo->Parcel->CODAmount)
            {
                if($i == 0)
                {
                    $cod = 'COD: ' . $PrintDataInfo->Parcel->CODAmount . ' ' . $currency; 
                }
                else
                {
                    $cod = $lang->COD;
                }
                
            }

            $result .= <<<EOT
            ^XA
            ^CI28
            ^FO240,95
            ^BY4
            ^B2N,200,N,N,N
            ^FD{$barcodeFull}^FS
            ^FO230,35
            ^A0N,0,60
            ^FD{$barcode1}^FS
            ^FO430,35
            ^A0N,0,50
            ^FD{$barcode2}^FS
            ^FO710,35
            ^A0N,0,40
            ^FD{$barcode3}^FS
            ^FO230,330
            ^A0N,0,50
            ^FD{$cod}^FS
            ^FO700,430
            ^A0R,0,30
            ^FD{$lang->Recipient}^FS
            ^FO640,430
            ^A0R,0,40
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->Name}^FS
            ^FO590,430
            ^A0R,0,40
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->Street} {$PrintDataInfo->Parcel->DeliveryAddress->HouseNumber}/{$PrintDataInfo->Parcel->DeliveryAddress->HouseNumberInfo}^FS
            ^FO540,430
            ^A0R,0,40
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->ZipCode}^FS
            ^FO540,570
            ^A0R,0,40
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->City}^FS
            ^FO490,430
            ^A0R,0,40
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->CountryIsoCode}^FS
            ^FO450,430
            ^A0R,0,23
            ^FD{$PrintDataInfo->Parcel->DeliveryAddress->ContactName}^FS
            ^FO320,430
            ^A0R,23,23
            ^TBR,740,100
            ^FD{$lang->glsText}^FS
            ^FO300,430
            ^A0R,0,23
            ^FD{$PrintDataInfo->Parcel->Content}^FS
            ^FO200,430
            ^A0R,0,23
            ^FD{$PrintDataInfo->Parcel->CODReference}^FS
            ^FO125,430
            ^A0R,0,23
            ^FD{$lang->Amount}^FS
            ^FO75,460
            ^A0R,0,32
            ^FD{$part}/{$PrintDataInfo->Parcel->Count}^FS
            ^FO25,430
            ^A0R,0,23
            ^FD{$date}^FS
            ^FO190,35
            ^GB2,375
            ^FS
            ^FO25,160
            ^GB165,2
            ^FS
            ^FO25,285
            ^GB165,2
            ^FS
            ^FO150,35
            ^A0R,0,30
            ^FD{$lang->Depot}^FS
            ^FO80,35
            ^A0R,0,45
            ^FD{$PrintDataInfo->Depot}^FS
            ^FO150,170
            ^A0R,0,30
            ^FD{$lang->Sort}^FS
            ^FO80,170
            ^A0R,0,45
            ^FD{$PrintDataInfo->Sort}^FS
            ^FO150,300
            ^A0R,0,30
            ^FD{$lang->Driver}^FS
            ^FO80,300
            ^A0R,0,45
            ^FD{$PrintDataInfo->Driver}^FS
            ^FO225,750
            ^A0R,0,23
            ^FD{$lang->Sender}^FS
            ^FO185,750
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->Name}^FS
            ^FO145,750
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->Street} {$PrintDataInfo->Parcel->PickupAddress->HouseNumber}/{$PrintDataInfo->Parcel->PickupAddress->HouseNumberInfo}^FS
            ^FO105,750
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->ZipCode}^FS
            ^FO105,850
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->City}^FS
            ^FO65,750
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->CountryIsoCode}^FS
            ^FO25,750
            ^A0R,0,30
            ^FD{$PrintDataInfo->Parcel->PickupAddress->ContactName}^FS
            ^FO680,800
            ^GFA,5600,5600,14, Q0G3V0P0IFGCT0O0G7JFGCS0N0G1LFG8R0N0G7LFGER0M0G1NFG8Q0M0G3NFGEQ0M0PFG8P0L0G1PFGCP0L0G3QFP0L0G7KFGCG0G1IFG8O0L0KFGCJ0HFGEO0K0G1KFK0G1HFO0K0G3JFGCL0G7GFG8N0K0G7JFM0G1GFGCN0K0JFGEN0G7GEN0J0G1JFGCN0G3GFN0J0G1JFG8O0GFG8M0J0G3JFP0G7GCM0J0G7IFGEP0G1GEM0J0JFGCQ0GFM0J0JFG8Q0G7G8L0I0G1JFR0G3GCL0I0G1JFR0G1GEL0I0G3IFGES0GFL0I0G7IFGCS0G7L0I0G7IFGCS0G3G8K0I0JFG8S0G1GCK0I0JFG8T0GEK0H0G1JFU0G6K0H0G1JFU0G3K0H0G3IFGEU0G1G8J0:H0G3IFGCV0GCJ0H0G7IFGCV0G6J0H0G7IFGCV0G2J0H0JFG8V0G3J0H0JFG8V0G1J0H0JFG8W0G8I0G0G1JFX0G8I0G0G1JFX0G4I0G0G1JFX0G2I0G0G3JFX0G2I0G0G3IFGEgH0G0G3IFGEX0G1I0G0G7IFGEgH0:G0G7IFGCgH0:G0JFGCgH0:::G1JFGCgH0G1JFG8gH0:::G3JFG8gH0::::::G7JFG8gH0:::::::::KFG8gH0:KFGCgH0:::::KFGEgH0::::LFgH0G7KFgH0::G7KFG8gG0::G7KFGCgG0:G7KFGCN0G8R0G7KFGEN0GFG8Q0G3KFGEN0HFGCP0G3LFN0IFGEO0G3LFN0KFN0G3LFN0LFG8L0G3LFG8M0MFL0:G3LFGCM0MFL0:G1LFGEM0MFL0:G1MFM0MFL0:G1MFG8L0MFL0G0MFGCL0MFL0:G0MFGEL0MFL0G0NFL0MFL0G0G7MFL0MFL0G0G7MFG8K0MFL0G0G7MFGCK0MFL0:G0G3MFGEK0MFL0G0G3NFK0MFL0G0G3NFG8J0MFL0G0G3NFGCJ0MFL0G0G1NFGCJ0MFL0G0G1NFGEJ0MFL0G0G1OFJ0MFL0H0OFG8I0MFL0H0OFGCI0MFL0H0G7NFGEI0MFL0H0G7OFI0MFL0H0G7OFG8H0MFL0H0G3OFGEH0MFL0H0G3PFH0MFL0H0G1PFG8G0MFL0H0G1PFGCG0MFL0I0QFG0MFL0I0QFG8MFL0I0G7PFGDMFL0I0G7XFL0I0G3XFL0:I0G1XFL0:J0XFL0:J0G7WFL0:J0G3WFL0J0G1WFL0:K0WFL0K0G7VFL0:K0G3VFL0K0G1VFL0L0VFL0:L0G7UFL0L0G3UFL0L0G1UFL0M0UFL0M0G7TFL0M0G3TFL0M0G1TFL0N0TFL0G4M0G7SFL0G7GFL0G3SFL0G7HFG8J0G1SFL0G7IFGCJ0SFL0G7JFGEI0G7RFL0G7LFH0G1RFL0G7MFGCG0RFL0G7NFGERFL0G7gGFL0::::::::::::::::::::::G0G3gFL0H0G1YFL0J0XFL0K0G3VFL0L0G1UFL0N0TFL0O0G7RFL0P0G3QFL0R0PFL0S0G7NFL0T0G3MFL0U0G1LFL0W0G7JFL0X0G3IFL0Y0G1HFL0gG0GFL0,::::L0JFGCW0K0MFV0J0G3MFGEU0J0OFGCT0I0G3PFG8S0I0QFGES0H0G1RFG8R0H0G3RFGCR0H0G7SFR0H0TFGCQ0G0G1TFGEQ0G0G1UFQ0G0G3UFGCP0G0G7UFGEP0G0G7VFP0G0WFG8O0G0WFGCO0G0WFGEO0G1XFO0G1XFG8N0:G3XFGCN0G3XFGEN0:G3LFGCI0OFN0G7LFK0NFG8M0G7KFGCK0G1MFG8M0G7KFG8L0G7LFGCM0G7KFM0G1LFGCM0G7KFN0LFGEM0G7JFGEN0G3KFGEM0G7JFGEN0G1LFM0G7JFGCO0LFM0G7JFGCO0G7KFG8L0KFGCO0G3KFG8L0KFGCO0G1KFG8L0KFG8O0G1KFGCL0G7JFG8P0KFGCL0:G7JFG8P0G7JFGEL0:G7JFG8P0G3JFGEL0:G7JFGCP0G1JFGEL0G7JFGCP0G1KFL0:G7KFG8O0G1KFL0G3LFGEO0KFL0G3NFN0KFL0G3OFG8L0KFL0G3PFGCK0KFL0G3QFK0KFL0:G1QFK0KFL0:::G0QFK0KFL0:G0QFJ0G1KFL0G0G7PFJ0G1KFL0::G0G3PFJ0G1KFL0G0G1PFJ0G1KFL0H0G1OFJ0G3KFL0J0G7MFJ0G3KFL0K0G3LFJ0G3JFGEL0L0G1KFJ0G3JFGEL0N0JFJ0G7JFGEL0O0G3HFJ0G7JFGEL0P0G1GFJ0G7JFGEL0V0KFGEL0G6U0KFGEL0G7GFG8R0G1KFGCL0G7HFG8R0KFGCL0G7IFGER0G7IFGCL0G7KFR0G3HFGCL0G7LFG8Q0G1GFG8L0G7MFGCR0G8L0G7NFGEX0G7PFW0G7QFGCU0G7RFGET0G7TFS0G7UFG8Q0G7VFGCP0G7WFGEO0G7YFN0G7gFGCL0G7gGFL0::::::::G7JFGCG3UFL0G7JFGCH0TFL0G7JFGCI0G7RFL0G7JFGCJ0G3QFL0G7JFGCK0G1PFL0G7JFGCM0OFL0G7JFGCN0G7MFL0G7JFGCO0G3LFL0G7JFGCP0G1KFL0G7JFGCR0JFL0G7JFGCS0G7HFL0G7JFGCT0G1GFL0G7JFGCgH0:G3JFGCgH0H0IFGCgH0I0G7GFGCgH0J0G3GCgH0,:::::G3G8gL0G3GFGEgK0G7IFgJ0G7JFG8gH0G7JFGEgH0G7JFGCgH0::G7JFG8L0G1IFG8Q0KFG8L0G7JFG8P0KFG8K0G1KFGEP0KFG8K0G7LFG8O0KFG8K0MFGEO0KFG8J0G1NFO0KFK0G3NFG8N0KFK0G7NFGCN0KFK0OFGEN0KFJ0G1PFN0KFJ0G1PFG8M0KFJ0G3PFGCM0KFJ0G7PFGCM0KFJ0G7PFGEM0G7JFJ0RFM0G7JFG8H0G1RFM0G7JFG8H0G1RFG8L0G7JFG8H0G3RFG8L0G7JFGCH0G7RFGCL0G3JFGEH0SFGCL0G3KFG0G1SFGCL0G3KFGETFGEL0G3gFGEL0G1gFGEL0G1SFGEG0G3JFGEL0G0SFGCG0G1KFL0G0SFG8H0KFL0G0G7RFI0KFL0G0G7QFGEI0G7JFL0G0G3QFGEI0G7JFL0G0G3QFGCI0G7JFL0G0G1QFG8I0G7JFL0H0QFG8I0G3JFL0H0QFJ0G3JFL0H0G7OFGEJ0G3JFL0H0G3OFGEJ0G3JFL0H0G1OFGCJ0G3JFL0I0OFG8J0G3JFL0I0G7NFK0G7JFL0I0G3MFGEK0G7JFL0J0MFGCK0G7JFL0J0G7LFG8K0G7JFL0J0G1KFGEL0G7JFL0K0G3JFGCL0G7JFL0L0G7HFGEM0KFL0W0KFL0W0G7JFL0X0G3IFL0Y0G1HFL0gG0GEL0,^FS
            ^FO550,1160
            ^A0R,0,70
            ^FD{$PrintDataInfo->B2CChar}^FS
            ^XZ
            EOT;
        }

        return $result;
    }

    public static function checkSum(string $barcode)
    {
        $nums = str_split($barcode);
        $even = 0;
        $odd = 0;
        for ($i=0; $i < 11; $i++)
        {
            if(($i+1) % 2 == 0)
            { 
                $even += $nums[$i];
            } 
            else
            { 
                $odd += $nums[$i];
            } 
        }
        $sum = ((($odd * 3) + $even + 1) % 10);

        if($sum == 0)
        {
            return 0;
        }
        else
        {
            return 10 - $sum;
        }
    }
}