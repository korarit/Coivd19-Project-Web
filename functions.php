<?php

//ดึงข้อมูล json
function GetJson($url){
$curl = curl_init();
 
curl_setopt_array($curl, array(
CURLOPT_URL => "$url",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
"accept: application/json"
)
));

$response = curl_exec($curl);
$err = curl_error($curl);
 
curl_close($curl);
 
if ($err) {
	return "cURL Error #:" . $err;
}else{
	$responses = json_decode($response, true);
	return $responses;
}
}
function getDataNow($url, $data){
	$responses = GetJson("$url");
	$datanow = $responses[$data];
	return $datanow;
}

function getDataLast($data, $url){
$dataJson = json_decode(file_get_contents("$url"), true);
	foreach($dataJson as $index => $animal){
		if ($index === array_key_last($dataJson)){
			$datanow = $dataJson[$index][$data];
			return $datanow;
		}
	}
}

//ดึงข้อมูล เมื่อวาน input ข้อมูลที่ต้องการ, ผ่านมากี่วัน, ลิ้ง (json)
function getDataYesterday($data, $url, $dates){
$dataJson = json_decode(file_get_contents("$url"), true);
$date = getDataLast("$dates", "$url");
$days = date('Y-m-d', strtotime("$date -1 day"));
	foreach($dataJson as $index => $animal){
		if ($dataJson[$index]["$dates"] == "$days"){
			$datanow = $dataJson[$index][$data];
			return $datanow;
		}
	}
}

//ดึงข้อมูล ตามวันที่ผ่านมา เช่น 5วัน input ข้อมูลที่ต้องการ, ผ่านมากี่วัน, ลิ้ง (json)
function getDataAgoday($data, $day, $url, $dates){
$dataJson = json_decode(file_get_contents("$url"), true);
$date = getDataLast("$dates", "$url");
$days = date('Y-m-d', strtotime("$date -$day day"));
	foreach($dataJson as $index => $animal){
		if ($dataJson[$index]["$dates"] == "$days"){
			$datanow = $dataJson[$index][$data];
			return $datanow;
		}
	}
}

//ดึงข้อมูลวันล่าสุด ที่มีการเผยแพร่ จำนวนการตรวจ
function getLastTestPCR(){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/testing-data.json"), true);
//print_r($dataJson);
foreach($dataJson as $index => $animal){
    if ($index === array_key_last($dataJson)){
		$lasttests = $dataJson[$index]["tests"]; // output: tests
		$lastdate = $dataJson[$index]["date"]; // output: date
		$lastpositive = $dataJson[$index]["positive"]; // output: positive
	return array($lastdate, $lasttests, $lastpositive);
	}
}
}
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/national-vaccination-timeseries.json"), true);
//print_r($dataJson);
//ดึงข้อมูลวันล่าสุด ที่มีการเผยแพร่ จำนวนการฉีดวัคซีนcovid
function getLastVaccineUpdate(){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/national-vaccination-timeseries.json"), true);
//print_r($dataJson);
foreach($dataJson as $index => $animal){
    if ($index === array_key_last($dataJson)){
		$date = $dataJson[$index]["date"]; // output: วันที่ของข้อมูล
		$total_doses = $dataJson[$index]["total_doses"]; // output: โดสทั้งหมดทีฉีด
		$first_dose = $dataJson[$index]["first_dose"]; // output: โดสแรกทั้งหมด
		$second_dose = $dataJson[$index]["second_dose"]; // output: โดสสองทั้งหมด
		//$total_supply = $dataJson[$index]["total_supply"]; // output: จำนวนวัคฉีนที่มี
		$daily_vaccinations = $dataJson[$index]["daily_vaccinations"]; // output: จำนวนวัคฉีนที่ฉีดวันนี้
		$precent_first_dose = number_format(($first_dose/66186727)*100, 2);
		$precent_second_dose = number_format(($second_dose/66186727)*100, 2);
	return array($date, $total_doses, $first_dose, $second_dose, 0, $daily_vaccinations, $precent_first_dose, $precent_second_dose);
	}
}
}

function highdosefist(){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/provincial-vaccination.json"), true);
//print_r($dataJson);
	$getjson = (array)($dataJson["data"]);
	array_multisort(array_column($getjson, 'total_1st_dose'), SORT_DESC, $getjson);
    return array_slice($getjson, 0, 5);
}