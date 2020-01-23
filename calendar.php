<?php

$givenName = "";
$middleName = "";
$familyName = "";

if(isset($_GET["id"]) && isset($_GET["api"])){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://z0shy2ecl0.execute-api.eu-west-1.amazonaws.com/production/appointment/list",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "accept:  application/json, text/plain, */*",
      "idtoken:  ". $_GET["id"],
      "x-api-key:  ". $_GET["api"]
      ),
  ));

  $response = curl_exec($curl);
  
  curl_close($curl);
  $data = json_decode($response);
  // Maak het downloadable
  //header('Content-type: text/calendar; charset=utf-8');
  //header('Content-Disposition: attachment; filename=SAH_cal.ics'); 
  // Begin van ICS file?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//bobbin v0.1//NONSGML iCal Writer//EN
CALSCALE:GREGORIAN
METHOD:PUBLISH
<?php foreach($data->items as $value){
$customerUsername = $value->customerUsername;
$customerCode = $value->customerNumber;
$description = $value->description;
$pin = $value->pin;
$startTime = $value->scheduledStartDateTime;
$endTime = $value->scheduledEndDateTime;
$address = $value->address->street . " " . $value->address->streetNumber . ", " . $value->address->postalCode . " " . $value->address->city;


/* 

-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

Working on converting username to real name
Not working yet

-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

*/

$curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://z0shy2ecl0.execute-api.eu-west-1.amazonaws.com/production/customer",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "accept:  application/json, text/plain, */*",
      "customerusername: ". $customerUsername,
      "idtoken:  ". $_GET["id"],
      "x-api-key:  ". $_GET["api"]
      ),
  ));

  $customerJson = curl_exec($curl);
  curl_close($curl);

  $customerInfo = json_decode($customerJson);

  foreach($customerInfo->user as $value1){
    $givenName = $value1->attributes->given_name;
    $middleName = $value1->attributes->middle_name . " ";
    $familyName = $value1->attributes->family_name;
  }

/* 

-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

Paste out 'till here

-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

*/  

echo "BEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($startTime))."\nDTEND:".date("Ymd\THis\Z",strtotime($endTime))."\nLOCATION:".$address."\nTRANSP:OPAQUE\nSEQUENCE:0\nUID:".md5($customerCode)."\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$givenName . " " . $middleName . $familyName . " " . $customerCode."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nEND:VEVENT\n";
}
?>
END:VCALENDAR<?php
// Eind van ICS file
} else{
  echo "Ongeldige URL";
}