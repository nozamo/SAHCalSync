<?php

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
  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: attachment; filename=SAH_cal.ics'); 
  // Begin van ICS file?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//basvli v0.1//SAH Calendar//EN
CALSCALE:GREGORIAN
METHOD:PUBLISH
BEGIN:VTIMEZONE
TZID:Europe/Berlin
TZURL:http://tzurl.org/zoneinfo-outlook/Europe/Berlin
X-LIC-LOCATION:Europe/Berlin
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:+0100
TZNAME:CET
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU
END:STANDARD
END:VTIMEZONE
<?php foreach($data->items as $value){
  if($value->status !== "Cancelled"){
    $customerUsername = $value->customerUsername;
    $customerCode = $value->customerNumber;
    $pin = $value->pin;
    $description = $value->description;
    $startTime = $value->scheduledStartDateTime;
    $endTime = $value->scheduledEndDateTime;
    $address = $value->address->street . " " . $value->address->streetNumber . ", " . $value->address->postalCode . " " . $value->address->city;


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
  
  $phonenumber = $customerInfo->user->attributes->phone_number;
  $customeremail = $customerInfo->user->attributes->email;
  
  $totaldes = $description .
  "\\nPin: " . $pin .
   "\\nTelefoonnummer: " . $phonenumber .
   "\\nEmail: " . $customeremail;
  

  $gender = $customerInfo->user->attributes->gender;

    if(isset($gender)){
      if($gender == "M"){
        $name = "Meneer ";
      } else if($gender == "F"){
        $name = "Mevrouw ";
      } else{
        $name = "";
      }
    if(isset($customerInfo->user->attributes->middle_name)) {
      $middleName = $customerInfo->user->attributes->middle_name . " ";
    } else{
      $middleName = "";
    }
    if(isset($customerInfo->user->attributes->family_name)) {
      $familyName = $customerInfo->user->attributes->family_name . " | ";  
    } else{
      $familyName = "";
    }

echo "BEGIN:VEVENT\nDTSTART;TZID=Europe/Berlin:".date("Ymd\THis",strtotime($startTime))."\nDTEND;TZID=Europe/Berlin:".date("Ymd\THis",strtotime($endTime))."\nLOCATION:".$address."\nTRANSP:OPAQUE\nSEQUENCE:0\nUID:".md5($customerCode)."\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:". $name . $middleName . $familyName . $customerCode."\nDESCRIPTION:".$totaldes. "\nPRIORITY:1\nCLASS:PRIVATE\nEND:VEVENT\n";
  }
}
}
?>
END:VCALENDAR<?php
// Eind van ICS file
} else{
  echo "Ongeldige URL. Gebruik yourdomain.com/calendar.php?id=YOUR_ID_TOKEN&api=YOUR_API_KEY";
}
