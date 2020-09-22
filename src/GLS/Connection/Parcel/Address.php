<?php declare(strict_types=1);

namespace GLS;

class Address
{
	/**
	* Name of the person or organization. REQUIRED
	*/
	public string $Name;

	/**
	* Name of the street. REQUIRED
	*/
	public string $Street;

	/**
	* Number of the house. (ONLY NUMBER)
	*/
	public string $HouseNumber;

	/**
	* Additional information. (Building, stairway, etc.)
	*/
	public string $HouseNumberInfo;

	/**
	* Name of the town or village. REQUIRED
	*/
	public string $City;

	/**
	* Area Zip code. REQUIRED
	*/
	public string $ZipCode;

	/**
	* Two letter country code defined in ISO 3166-1. REQUIRED
	*/
	public string $CountryIsoCode;

	/**
	* Name of person which can be asked or inform about shipment details by GLS.
	*/
	public string $ContactName;

	/**
	* Phone number of person which can be asked or inform about shipment details by GLS.
	*/
	public string $ContactPhone;

	/**
	* Email address of person which can be asked or inform about shipment details by GLS.
	*/
	public string $ContactEmail;
}