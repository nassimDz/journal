<?php

$_ENV = array(
    'TRUSTIFI_URL' => "https://be.trustifi.com",
    'TRUSTIFI_KEY' => "fff5a537541a3dc75bb838ee591a4310c663a2919dc4eb40",
    'TRUSTIFI_SECRET' => "2054c8bbb617a5450f9810b0201f698e  "
);

function sendEmail($user_email, $title, $body)
{
$curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => $_ENV['TRUSTIFI_URL'] . "/api/i/v1/email",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\"recipients\":[{\"email\":\"$user_email\"}],\"title\":\"$title\",\"html\":\"$body\"}",
      CURLOPT_HTTPHEADER => array(
          "x-trustifi-key: " . $_ENV['TRUSTIFI_KEY'],
          "x-trustifi-secret: " . $_ENV['TRUSTIFI_SECRET'],
          "content-type: application/json"
      )
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err) {
      echo "cURL Error #:" . $err;
  } else {
      echo $response;
  }
}

//sendEmail("nassim.hadjarab@gmail.com", "weclome", "hello mate");
?>
