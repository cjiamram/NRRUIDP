<?php
$url = 'https://jsonplaceholder.typicode.com/posts/1';


$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,$url);
curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
$query = curl_exec($curl_handle);
$data = json_decode($query, true);
curl_close($curl_handle);

//print complete object, just echo the variable not work so you need to use print_r to show the result
print_r( $data);
//at first layer
//echo $data["tradedDate"];
//Inside the second layer
//echo $data["data"][0]["companyName"];
?>