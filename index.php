<?php

function json_rpc_header($userid, $password)
{
    date_default_timezone_set("UTC");
    $inttime = strval(time() - strtotime("1970-01-01 00:00:00"));
    $value = $userid."&" . $inttime;
    $key = $password;
    $signature = hash_hmac("sha256", $value, $key, true);
    $signature64 = base64_encode($signature);
    $headers =
    [
         "userid:".$userid,
         "signature:".$signature64,
         "key:".$inttime
    ];
    return $headers;
}

$user = 'api-demo';
$pwd = 'xyNV4ifdBbkPQ5RWpEbaErBghh7cIwvoJvISAtylJH9sg1wZLG8YqezpHFPnLoTV';
$header = json_rpc_header($user, $pwd);
$urlTo = "https://sso-bsw.kotabogor.go.id/oulsso/websvc.php";

$user_login = "085773004075999";
$password = "1982";
$url_do_login = "https://sso-bsw.kotabogor.go.id/oulsso/tes/3. do_sso_login.php";
$url_form_login = "";


$aplikasi = 'tes mantap';
$data = 'data=
{
  "jsonrpc": "2.0", 
  "method": "do_login_user",
  "params": 
  { 
    "php_is_native":"1",
    "nip":"198801202010011004",
    "email":"djwiramanggala@gmail.com",
    "nik":"3271052001880002",
    "nohp":"081240700038",
    "pwd":"2088",
    "nama_aplikasi":"BSW"
  } 
} 
';

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $urlTo);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_HTTPHEADER, $header);
curl_setopt($c, CURLOPT_POSTFIELDS, $data);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);

$res = curl_exec($c);
if(curl_errno($c)) {
    echo 'Curl error: ' . curl_error($c);
}
curl_close($c);
// return $res;
echo $res;
