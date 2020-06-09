<?php

$middleName = "";
$familyName = "";
$api = "APIkeyhier";
$email = "EMAILHIER";
$pass = "WACHTWOORDHIER";

if(isset($api) && (isset($email) && (isset($pass) ))){
$postdata1 = array(
    'username' => $email,
    'password' => $pass
);
$payload = json_encode($postdata1);
 
// Prepare new cURL resource
$ch = curl_init('https://mijnstudent.studentaanhuis.nl/auth/signin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
 
// Set HTTP Header for POST request 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload))
);
 
// Submit the POST request
$result = curl_exec($ch);

$data1 = json_decode($result);

$id = $data1->tokens->idToken;

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
      "idtoken:  ". $id,
      "x-api-key:  ". $api
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
PRODID:-//basvli & Nozamo//SAH Calendar//EN
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
        "idtoken:  ". $id,
        "x-api-key:  ". $api
        ),
    ));

    $customerJson = curl_exec($curl);
    curl_close($curl);
$string = $value->description;
$customerInfo = json_decode($customerJson);

		if( strlen( $string ) > 450 ) {
   $string = substr( $string, 0, 450 ) . '...';
}
    $string = str_replace(array("\n", "\r"), '', $string);
    $customerCode = $value->customerNumber;
    $pin = $value->pin;
    $phone = $customerInfo->user->attributes->phone_number;
    $description = "Telefoon: ". $phone .
    "\\nPin: " . $pin .
    "\\n\\nOmschrijving: " . $string;
    $startTime = $value->scheduledStartDateTime;
    $endTime = $value->scheduledEndDateTime;
    $address = $value->address->street . " " . $value->address->streetNumber . ", " . $value->address->postalCode . " " . $value->address->city;

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

echo "BEGIN:VEVENT\nDTSTART;TZID=Europe/Berlin:".date("Ymd\THis",strtotime($startTime))."\nDTEND;TZID=Europe/Berlin:".date("Ymd\THis",strtotime($endTime))."\nLOCATION:".$address."\nTRANSP:OPAQUE\nSEQUENCE:0\nUID:".md5($customerCode)."\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:". $name . $middleName . $familyName . $customerCode."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nEND:VEVENT\n";  }
}
}
?>
END:VCALENDAR<?php
// Eind van ICS file
} else{
  echo "Ongeldig";
}