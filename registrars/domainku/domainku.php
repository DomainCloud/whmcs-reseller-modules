<?php
/**
 * This is registar command module for connecting to DomainCloud API.
 *
 * @package    DCRegistrarModules
 * @author     Infinys System Indonesia
 * @copyright  Copyright (c) Infinys System Indonesia. 2014
 * @license    http://www.isi.co.id/
 * @version    $Id$
 * @link       http://www.isi.co.id/
 */

date_default_timezone_set('Asia/Jakarta');

# Configuration array
function domainku_getConfigArray() {
	$configarray = array(
		"AuthEmail" => array( "Type" => "text", "Size" => "20", "Description" => "Enter your auth email here" ),
		"Token" => array( "Type" => "text", "Size" => "20", "Description" => "Enter your token here" )
	);
	return $configarray;
}

function domainku_AdminCustomButtonArray() {

}

function domainku_GetContactDetails($params) {
	$values = _api_process($params, "GetContactDetails");
	return $values;
}

function domainku_SaveContactDetails($params) {
	$values = _api_process($params, 'SaveContactDetails');
	return $values;
}

function domainku_GetNameservers($params) {
	$values = _api_process($params, "GetNameservers");
	return $values;
}

function domainku_SaveNameservers($params) {
	$values = _api_process($params, "SaveNameservers");
	return $values;
}

function domainku_GetRegistrarLock($params) {
	$values = _api_process($params, "GetRegistrarLock");
	return $values;
}

function domainku_SaveRegistrarLock($params) {
	$values = _api_process($params, "SaveRegistrarLock");
	return $values;
}

function domainku_RegisterDomain($params) {
	$values = _api_process($params, "RegisterDomain");
	return $values;
}

function domainku_TransferDomain($params) {
	$values = _api_process($params, "TransferDomain");
	return $values;
}

function domainku_RenewDomain($params) {
	$values = _api_process($params, "RenewDomain");
	return $values;
}

function domainku_GetEPPCode($params) {
	$values = _api_process($params, "GetEPPCode");
	return $values;
}

function domainku_RegisterNameserver($params) {
	$values = _api_process($params, "RegisterNameserver");
	return $values;
}

function domainku_ModifyNameserver($params) {
	$values = _api_process($params, "ModifyNameserver");
	return $values;
}

function domainku_DeleteNameserver($params) {
	$values = _api_process($params, "DeleteNameserver");
	return $values;
}

function _domainku_message($code) {
}

function _domainku_ackpoll($client,$msgid) {
}

function domainku_TransferSync($params) {
}

function domainku_Sync($params) {
}

function domainku_RequestDelete($params) {
	$values = _api_process($params, 'RequestDelete');
	if (empty($values['error'])) {
		$query = update_query( "tbldomains", array("status"=>"Cancelled"), array("id"=>$params['domainid']) );
	}
	return $values;
}

function _api_process($params, $command) {
	require_once "config.php";
	$config = getregistrarconfigoptions('domainku');

	# Check if module parameters are sane
	if (empty($config["AuthEmail"]) && empty($config["Token"]) && empty($config["Endpoint"])) {
		throw new Exception('System configuration error(1), please contact your provider');
	}

	$sld = $params["sld"];
	$tld = $params["tld"];
	
	$address1 = (!empty($params["contactdetails"]["Registrant"]["Address 1"]) ? $params["contactdetails"]["Registrant"]["Address 1"] : $params["contactdetails"]["Registrant"]["Address line 1"]);
	$address2 = (!empty($params["contactdetails"]["Registrant"]["Address 2"]) ? $params["contactdetails"]["Registrant"]["Address 2"] : $params["contactdetails"]["Registrant"]["Address line 2"]);
	$city = (!empty($params["contactdetails"]["Registrant"]["City"]) ? $params["contactdetails"]["Registrant"]["City"] : $params["contactdetails"]["Registrant"]["TownCity"]);
	$cc = (!empty($params["contactdetails"]["Registrant"]["Country"]) ? $params["contactdetails"]["Registrant"]["Country"] : $params["contactdetails"]["Registrant"]["Country Code"]);
	$zip = (!empty($params["contactdetails"]["Registrant"]["ZIP"]) ? $params["contactdetails"]["Registrant"]["ZIP"] : $params["contactdetails"]["Registrant"]["Zip code"]);
	$phonenum = (!empty($params["contactdetails"]["Registrant"]["Phone Number"]) ? $params["contactdetails"]["Registrant"]["Phone Number"] : $params["contactdetails"]["Registrant"]["Phone"]);

	$data = array(
	    "action"			=> $command,
	    "token"             => $config["Token"],
	    "authemail"         => $config["AuthEmail"],
	    "sld"				=> $sld,
	    "tld"				=> $tld,
	    "regperiod"			=> $params["regperiod"],
	    "nameserver1"       => $params["ns1"],
	    "nameserver2"       => $params["ns2"],
	    "nameserver3"       => $params["ns3"],
	    "nameserver4"       => $params["ns4"],
	    "nameserver5"       => $params["ns5"],
	    "dnsmanagement"		=> $params["dnsmanagement"],
	    "emailforwarding"	=> $params["emailforwarding"],
	    "idprotection"		=> $params["idprotection"],
	    "firstname"         => $params["firstname"],
	    "lastname"          => $params["lastname"],
	    "companyname"		=> $params["companyname"],
	    "address1"          => $params["address1"],
	    "address2"          => $params["address2"],
	    "city"				=> $params["city"],
	    "state"             => $params["state"],
	    "country"           => $params["country"],
	    "postcode"          => $params["postcode"],
	    "phonenumber"		=> $params["fullphonenumber"],
	    "email"             => $params["email"],
	    "adminfirstname"	=> $params["adminfirstname"],
	    "adminlastname"		=> $params["adminlastname"],
	    "adminaddress1"		=> $params["adminaddress1"],
	    "adminaddress2"		=> $params["adminaddress2"],
	    "admincity"			=> $params["admincity"],
	    "adminstate"		=> $params["adminstate"],
	    "admincountry"		=> $params["admincountry"],
	    "adminpostcode"		=> $params["adminpostcode"],
	    "adminemail"		=> $params["adminemail"],
	    "adminphonenumber"	=> $params["adminphonenumber"],
	    "nameserver"		=> $params["nameserver"],
	    "ipaddress"			=> $params["ipaddress"],
	    "currentipaddress"	=> $params["currentipaddress"],
	    "newipaddress"		=> $params["newipaddress"],
	    "transfersecret"	=> $params["transfersecret"],
	    "ContactName"		=> $params["contactdetails"]["Registrant"]["Contact Name"],
		"ContactOrg"		=> $params["contactdetails"]["Registrant"]["Organisation"],
		"ContactAddress1"	=> $address1,
		"ContactAddress2"	=> $address2,
		"ContactCity"		=> $city,
		"ContactState"		=> $params["contactdetails"]["Registrant"]["State"],
		"ContactZIP"		=> $zip,
		"ContactCountry"	=> $cc,
		"ContactPhoneNum"	=> $phonenum,
		"ContactEmail"		=> $params["contactdetails"]["Registrant"]["Email"],
	    "domaintype"		=> $command == 'TransferDomain' ? "transfer" : "register",
	    "paymentmethod"		=> "banktransfer",
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api_endpoint);
	curl_setopt($ch, CURLOPT_TIMEOUT, 0);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$output = curl_exec($ch);
	if ($output == false) {
		$res = array("error"=>curl_error($ch));
	} else {
		$res = json_decode($output, true);
	}
	return $res;
	curl_close($ch);
}

?>
