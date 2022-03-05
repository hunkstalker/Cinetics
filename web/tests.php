<?php

// IP address
//$userIP = $_SERVER['REMOTE_ADDR'];
$userIP = '213.195.120.26';
// API end URL
$apiURL = 'https://freegeoip.app/json/' . $userIP;
// Create a new cURL resource with URL
$ch = curl_init($apiURL);
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Execute API request
$apiResponse = curl_exec($ch);
// Close cURL resource
curl_close($ch);
// Retrieve IP data from API response
$ipData = json_decode($apiResponse, true);
if (!empty($ipData)) {
  $country_code = $ipData['country_code'];
  $country_name = $ipData['country_name'];
  $region_code = $ipData['region_code'];
  $region_name = $ipData['region_name'];
  $city = $ipData['city'];
  $zip_code = $ipData['zip_code'];
  $latitud = $ipData['latitude'];
  $longitud = $ipData['longitude'];
  $time_zone = $ipData['time_zone'];

  echo 'País: ' . $country_name . '<br/>';
  echo 'Código: ' . $country_code . '<br/>';
  echo 'Región: ' . $region_name . '<br/>';
  echo 'Ciudad: ' . $city . '<br/>';
  echo 'Código Postal: ' . $zip_code . '<br/>';
  echo 'Latitud: ' . $latitud . '<br/>';
  echo 'Longitud: ' . $longitud . '<br/>';
  echo 'Zona Horaria: ' . $time_zone . '<br/><br/>';
} else {
  echo 'IP data is not found!';
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
    return ($miles * 0.8684);
  } else {
    return $miles;
  }
}

// Barcelona, coordenadas obtenidas desde la IP
$punto1 = [$latitud, $longitud];
// Sant Celoni, coordenadas obtenidas manualmente
$punto2 = [41.69, 2.49];

echo "La distancia desde {$city} ({$region_name}, {$country_name}) al destino (Sant Celoni) es de: " . floor(distance($punto1[0], $punto1[1], $punto2[0], $punto2[1], 'K')*100)/100 . " Km";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

</body>
</html>