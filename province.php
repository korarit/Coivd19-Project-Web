<?php
function getDataVaccine($Names){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/provincial-vaccination.json"), true);
//print_r($dataJson);
	$getjson = (array)($dataJson["data"]);
	foreach ($getjson as $item => $animal) {
		if ($getjson[$item]["province"] == $Names) {
			$provincename = $getjson[$item]["province"];
			$province_fistdose = $getjson[$item]["total_1st_dose"];
			$province_secenddose = $getjson[$item]["total_2nd_dose"];
			$total_3rd_dose = $getjson[$item]["total_3rd_dose"];
			$updates = $dataJson["update_date"];
			return array($provincename, $province_fistdose, $province_secenddose, $total_3rd_dose, $updates);
		}
	}
}
function getDataCovid($Names){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/province-cases-data-14days.json"), true);
//print_r($dataJson);
	foreach ($dataJson as $item => $animal) {
		if ($dataJson[$item]["name"] == $Names) {
			$provincename = $dataJson[$item]["name"];
			$provincelastcases = end($dataJson[$item]["cases"]);
			$provincecase14day = $dataJson[$item]["caseCount"];
			$getlastupdate = array_keys($dataJson[$item]["cases"]);
			$update = end($getlastupdate);
			return array($provincename, $provincelastcases, $provincecase14day, $update);
		}
	}
}

function getDataAgoCovid($Names, $day){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/province-cases-data-14days.json"), true);
//print_r($dataJson);
	foreach ($dataJson as $item => $animal) {
		if ($dataJson[$item]["name"] == $Names) {
			$provincelastcases = $dataJson[$item]["cases"][$day];
			return $provincelastcases;
		}
	}
}

function getDataDayAgoCovid($Names, $day){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/province-cases-data-14days.json"), true);
//print_r($dataJson);
	foreach ($dataJson as $item => $animal) {
		if ($dataJson[$item]["name"] == $Names) {
			$provincelastcases = array_keys($dataJson[$item]["cases"][$day]);
			return $provincecases;
		}
	}
}

function getDataAmphoes($Names){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/porames/the-researcher-covid-bot/master/components/gis/data/amphoes-data-14days.json"), true);
//print_r($dataJson);	
	$last = array();
	foreach ($dataJson as $item => $animal) {
		if ($dataJson[$item]["province"] == $Names) {
			$provincename = $dataJson[$item]["province"];
			$amphoesname = $dataJson[$item]["name"];
			$amphoescase14day = $dataJson[$item]["caseCount"];
			$last[] = array($provincename, $amphoesname, $amphoescase14day);
		}
	}
	array_multisort(array_column($last, 2), SORT_DESC, $last);
    return array_slice($last, 0);
}

$getdatanow = getDataCovid($_GET["Name"]);
//print_r($getdatanow);
//print_r(getDataAmphoes($_GET["Name"]));
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ข้อมูลแต่ละจังหวัด</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.js" integrity="sha512-lUsN5TEogpe12qeV8NF4cxlJJatTZ12jnx9WXkFXOy7yFbuHwYRTjmctvwbRIuZPhv+lpvy7Cm9o8T9e+9pTrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<center>
<a class="btn btn-primary btn-lg" href="index.php" role="button">หน้าหลัก</a>
<button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#Modalprovince">ข้อมูลรายจังหวัด</button>
<a class="btn btn-success btn-lg" href="vaccine.php" role="button">ข้อมูลการฉีดวัคซีน</a>
</center>
<!-- Model province -->
<div class="modal fade" id="Modalprovince" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลรายจังหวัด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-inline my-2 my-lg-0">
			<input class="form-control" name="input_search" id="input_search" type="search" placeholder="กรุณากรอกจังหวัด" aria-label="Search">
			<hr class="my-4">
				<button type="submit" class="btn btn-primary" name="searchbtn" id="searchbtn">ค้นหา</button>
		</form>
      </div>
    </div>
  </div>
</div>
<?php
if(isset($_POST["searchbtn"])){
	$province = $_POST["input_search"];
	if($province !== ""){
		  echo "<script>window.location = 'https://www.stepklaz.tk/covid19/province.php?Name=$province'</script>";
	}
}
?>
<div class="d-flex justify-content-center mx-auto">
<div class="row" style="center">
	<div class="col">
	<div class="card text-white mt-4 bg-danger align-item-center mx-auto" style="width: 14em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:20">ติดเชื้อ</p>
			<b><p style="font-size:25">+<?php echo $getdatanow[1];?> ราย</p></b>
			</center>
		</div>
		<div class="card-footer" style="width: 14em">
			<center><b><p style="font-size:15">สะสม 14วัน <?php echo $getdatanow[2];?> ราย</p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<br>
<?php
//$daygrap = array(date('Y-m-d', strtotime("-6 day")), date('Y-m-d', strtotime("-5 day")), date('Y-m-d', strtotime("-4 day")), date('Y-m-d', strtotime("-3 day")), date('Y-m-d', strtotime("-2 day")), date('Y-m-d', strtotime("-1 day")), $getdatanow[3]);
//$casegrap = array(getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-6 day"))."T00:00:00"), getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-5 day"))."T00:00:00"), getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-4 day"))."T00:00:00"), getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-3 day"))."T00:00:00"), getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-2 day"))."T00:00:00"), getDataAgoCovid($_GET["Name"], date('Y-m-d', strtotime("-1 day"))."T00:00:00"), $getdatanow[1]);

?>
<!--
<hr class="my-4">
<h5 style="text-align:center">จำนวนผู้ติดเชื้อแต่ละอำเภอใน 14วัน</h5>
<div class="d-flex justify-content-center mx-auto">
<div class="card mt-4 bg-light mx-auto" style="width: 45em">
<table class="table">
  <thead>
    <tr class="table-active">
      <th scope="col"><b>อันดับ</b></th>
      <th scope="col"><b>อำเภอ</b></th>
      <th scope="col"><b>ผู้ติดเชื้อใน14วัน</b></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  //$tabledata = getDataAmphoes($_GET["Name"]);
  //print_r($tabledata);
  //foreach($tabledata as $index => $animal){
	  //$number = $index + 1;
	  //echo "<tr>";
	  //echo "<th scope='row'>".$number."</th>";
	  //echo "<td>".$tabledata[$index][1]."</td>";
	  //echo "<td>".$tabledata[$index][2]." ราย</td>";
	  //echo "</tr>";
  //}
  ?>
  </tbody>
</table>
</div>
</div>
-->
<hr class="my-4">
<h4 style="text-align:center">ข้อมูลไม่อัพเดพทุกวัน ผมก็ไม่รู้ว่าทำไมไม่อัพเดพทุกวัน</h4>
<div class="d-flex justify-content-center mx-auto">
<div class="card mt-4 bg-light mx-auto" style="width: 45em;height: 8em">
<table class="table">
  <thead>
    <tr class="table-active mx-auto">
      <th scope="col"><b>เข็มที่1</b></th>
      <th scope="col"><b>เข็มที่2</b></th>
	  <th scope="col"><b>เข็มที่3</b></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $tabledata = getDataVaccine($_GET["Name"]);
	  echo "<tr>";
	  echo "<td>".number_format($tabledata[1])."</td>";
	  echo "<td>".number_format($tabledata[2])."</td>";
	  echo "<td>".number_format($tabledata[3])."</td>";
	  echo "</tr>";
  ?>
  </tbody>
</table>
<p style="text-align:center;color:Red;size:10"><b>หมายเหตุ : ตารางนี้เป็นข้อมูลวันที่ <?php echo $tabledata[4]; ?></b></p>
</div>
</div>
<p style="text-align:center;color:Red;size:10"><b>Credit Data : https://covid-19.researcherth.co/</b></p>
<hr class="my-4">
<h4 style="text-align:center">copyright © 2021 - Develop By <a href="https://www.facebook.com/krt.korarit/">Korarit Sangthong</a></h4>
<hr class="my-4">
</body>
</html>