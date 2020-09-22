<?php declare(strict_types=1);

namespace GLS;

class ErrorInfo
{
    /**
     * Value from error enumeration
     * 1 Request parameter is null
     * 2 Parcel ID list is null
     * 3 Parcel ID list is empty
     * 4 Parcel ID not exists
     * 5 Access denied for this parcel ID
     * 6 Parcel with this ID has different status than PRINTED
     * 7 Missing parcel data in request
     * 8 COD amount has to be >= 0
     * 9 Parcel number not exists
     * 10 Parcel number was not assigned yet
     * 11 Parcel list is null
     * 12 Parcel list is empty
     * 13 Parcel validation issue
     * 14 User not exists
     * 15 User is not authorized to access parcel
     * 16 Label is empty
     * 17 There are no parcel numbers
     * 18 Parcel label is already generated
     * 19 Parcel number generator failed
     * 20 Parcel numbers were not generated
     * 21 There are no printable labels
     * 22 Count of parcels for deleting is out of limit
     * 23 The house number cannot be 0
     * 24 Wrong print date interval
     * 25 Wrong pickup date interval
     * 26 Parcel not found with current settings
     * 27 User is not authorized to access to Client
     * 28 The Count must be 1 because of the INS service
     * 29 Parcel(s) count must be between 1 and 99
     * 1000 Unexpected exception happened
     * 1001 Internal Problem
     */
    public int $ErrorCode;

    /**
     * Human readable error description or exception message trying to describe problem.
     */
    public string $ErrorDescription;

    /**
     * List of client parcel tags identifying parcels where specific error happened.
     * @var string[] $ClientReferenceList
     */
    public array $ClientReferenceList;
    
    /**
     * List of database parcel ID identifying parcel records where specific error happended.
     * @var string[] $ParcelIdList
     */
	public array $ParcelIdList;
}