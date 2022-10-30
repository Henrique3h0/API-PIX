<?php

function criar($bearer, $valor, $description, $email, $cidade, $last_name, $cpf, $cep, $address, $numero, $name, $bairro, $estado){
$ch = curl_init(); 
 
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments'); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n      \"transaction_amount\": $valor,\n      \"description\": \"$description\",\n      \"payment_method_id\": \"pix\",\n      \"payer\": {\n        \"email\": \"$email\",\n        \"first_name\": \"$name\",\n        \"last_name\": \"$last_name\",\n        \"identification\": {\n            \"type\": \"CPF\",\n            \"number\": \"$cpf\"\n        },\n        \"address\": {\n            \"zip_code\": \"$cep\",\n            \"street_name\": \"$address\",\n            \"street_number\": \"$numero\",\n            \"neighborhood\": \"$bairro\",\n            \"city\": \"$cidade\",\n            \"federal_unit\": \"$estado\"\n        }\n      }\n    }"); 
 
$headers = array(); 
$headers[] = 'Accept: application/json'; 
$headers[] = 'Content-Type: application/json'; 
$headers[] = "Authorization: Bearer $bearer"; 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
 
$result2 = curl_exec($ch); 
$data = json_decode($result2);


$qr_code = $data->point_of_interaction->transaction_data->qr_code;
$status = $data->status;
$valor = $data->transaction_amount;
$txid = $data->id;

$txt = '{"txid":"'.$txid.'","qr":"'.$qr_code.'"}';

return $txt;}

function verificar($txid, $bearer){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/$txid");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = "Authorization: Bearer $bearer";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
$result = curl_exec($ch); 

$result=str_replace('},

]',"}

]",$result);

$data = json_decode($result);

$status = $data->status;
$valor = $data->transaction_amount;
$txid = $data->id;


return $status;
}
