<?php
include('functions.php');

$LastVaccineUpdata = getLastVaccineUpdate();

function getYesterdayVaccine(){
$dataJson = json_decode(file_get_contents("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/national-vaccination-timeseries.json"), true);
//print_r($dataJson);
$LastVaccineUpdata = getLastVaccineUpdate();
$date = $LastVaccineUpdata[0];
$days = date('Y-m-d', strtotime("$date -1 day"));
foreach($dataJson as $index => $animal){
    if ($dataJson[$index]["date"] == "$days"){
		$date = $dataJson[$index]["date"]; // output: วันที่ของข้อมูล
		$total_doses = $dataJson[$index]["total_doses"]; // output: โดสทั้งหมดทีฉีด
		$first_dose = $dataJson[$index]["first_dose"]; // output: โดสแรกทั้งหมด
		$second_dose = $dataJson[$index]["second_dose"]; // output: โดสสองทั้งหมด
		$total_supply = $dataJson[$index]["third_dose"]; // output: จำนวนวัคฉีนที่มี
		$daily_vaccinations = $dataJson[$index]["daily_vaccinations"]; // output: จำนวนวัคฉีนที่ฉีดเมื่อวาน
		$precent_first_dose = number_format(($first_dose/66186727)*100, 2);
		$precent_second_dose = number_format(($second_dose/66186727)*100, 2);
		return array($date, $total_doses, $first_dose, $second_dose, $total_supply, $daily_vaccinations, $precent_first_dose, $precent_second_dose);
	}
}
}
$YesterdayVaccineUpdata = getYesterdayVaccine();

//print_r(getYesterdayVaccine());
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ข้อมูลการฉีดวัคซีน</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.js" integrity="sha512-lUsN5TEogpe12qeV8NF4cxlJJatTZ12jnx9WXkFXOy7yFbuHwYRTjmctvwbRIuZPhv+lpvy7Cm9o8T9e+9pTrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
<body>
<?php
$url_thai_series = "https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/national-vaccination-timeseries.json";
$dategrap = array(getDataAgoday("date", 6, "$url_thai_series", "date"), getDataAgoday("date", 5, "$url_thai_series", "date"), getDataAgoday("date", 4, "$url_thai_series", "date"), getDataAgoday("date", 3, "$url_thai_series", "date"), getDataAgoday("date", 2, "$url_thai_series", "date"), getDataAgoday("date", 6, "$url_thai_series", "date"), getDataLast("date", "$url_thai_series", "date"));
$totalgrap = array(getDataAgoday("total_doses", 6, "$url_thai_series", "date"), getDataAgoday("total_doses", 5, "$url_thai_series", "date"), getDataAgoday("total_doses", 4, "$url_thai_series", "date"), getDataAgoday("total_doses", 3, "$url_thai_series", "date"), getDataAgoday("total_doses", 2, "$url_thai_series", "date"), getDataAgoday("total_doses", 1, "$url_thai_series", "date"), getDataLast("total_doses", "$url_thai_series", "date"));
$fistgrap = array(getDataAgoday("first_dose", 6, "$url_thai_series", "date"), getDataAgoday("first_dose", 5, "$url_thai_series", "date"), getDataAgoday("first_dose", 4, "$url_thai_series", "date"), getDataAgoday("first_dose", 3, "$url_thai_series", "date"), getDataAgoday("first_dose", 2, "$url_thai_series", "date"), getDataAgoday("first_dose", 1, "$url_thai_series", "date"), getDataLast("first_dose", "$url_thai_series", "date"));
$secondgrap = array(getDataAgoday("second_dose", 6, "$url_thai_series", "date"), getDataAgoday("second_dose", 5, "$url_thai_series", "date"), getDataAgoday("second_dose", 4, "$url_thai_series", "date"), getDataAgoday("second_dose", 3, "$url_thai_series", "date"), getDataAgoday("second_dose", 2, "$url_thai_series", "date"), getDataAgoday("second_dose", 1, "$url_thai_series", "date"), getDataLast("second_dose", "$url_thai_series", "date"));
?>
<center>
<a class="btn btn-primary btn-lg" href="index.php" role="button">หน้าหลัก</a>
<button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#Modalprovince">ข้อมูลรายจังหวัด</button>
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
	<div class="card text-white mt-4 bg-Info mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body mx-auto">
		<center>
			<p style="font-size:18">จำนวนผู้รับรับวัคซีน วันที่ <?php echo $LastVaccineUpdata[0]; ?></p>
			<b><p style="font-size:25">+<?php echo number_format($LastVaccineUpdata[5]); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width: 22em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format($LastVaccineUpdata[1]); ?></p></b></center>
		</div>
	</div>
	</div>
	<div class="col">
	<div class="card text-white mt-4 bg-primary mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:18">รับวัคซีนเข็มแรก วันที่ <?php echo $LastVaccineUpdata[0]; ?></p>
			<b><p style="font-size:25">+ <?php echo number_format($LastVaccineUpdata[2] - $YesterdayVaccineUpdata[2]); ?></p></b>
			</center>
		</div>
		<div class="card-footer" style="width: 22em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format($LastVaccineUpdata[2]);?></p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<div class="d-flex justify-content-center mx-auto">
<div class="row" style="center">
	<div class="col">
	<div class="card text-white mt-4 bg-success mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body mx-auto">
		<center>
			<p style="font-size:18">รับวัคซีนเข็มที่สอง วันที่ <?php echo $LastVaccineUpdata[0]; ?></p>
			<b><p style="font-size:25">+<?php echo number_format($LastVaccineUpdata[3] - $YesterdayVaccineUpdata[3]); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width: 22em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format($LastVaccineUpdata[3]); ?></p></b></center>
		</div>
	</div>
	</div>
	<div class="col">
	<div class="card text-white mt-4 bg-warning mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:18">รับวัคซีนเข็มที่สาม วันที่ <?php echo $LastVaccineUpdata[0]; ?></p>
			<b><p style="font-size:25">+ <?php echo number_format($LastVaccineUpdata[4] - $YesterdayVaccineUpdata[4]); ?></p></b>
			</center>
		</div>
		<div class="card-footer" style="width: 22em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format($LastVaccineUpdata[4]);?></p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<div class="d-flex justify-content-center mx-auto">
<div class="card mt-4 bg-light mx-auto" style="width: 45em;height: 17em">
<table class="table">
  <thead>
    <tr class="table-active mx-auto">
      <th scope="col"><b>อันดับ</b></th>
      <th scope="col"><b>จังหวัด</b></th>
      <th scope="col"><b>เข็มที่1</b></th>
	  <th scope="col"><b>เข็มที่2</b></th>
	  <th scope="col"><b>เข็มที่3</b></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $tabledata = highdosefist();
  //print_r($tabledata);
  foreach($tabledata as $index => $animal){
	  $number = $index + 1;
	  echo "<tr>";
	  echo "<th scope='row'>".$number."</th>";
	  echo "<td>".($tabledata[$index]["province"])."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_1st_dose"])."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_2nd_dose"])."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_3rd_dose"])."</td>";
	  echo "</tr>";
  }
  ?>
  </tbody>
</table>
<p style="text-align:center;color:Red;size:10"><b>หมายเหตุ : ตารางนี้เป็นข้อมูลวันที่ <?php echo $LastVaccineUpdata[0] ?></b></p>
</div>
</div>
<hr class="my-4">
<h5 style="text-align:center">กราฟในแต่ละวัน 7วันที่ผ่านมา</h5>
<div class="d-flex justify-content-center mx-auto">
<div class="row">
<div class="card mt-4 bg-light mx-auto" style="width: 60em;height: 30em">
		<div class="card-body mx-auto">
		<center>
			<canvas id="ChartVaccine" width="850" height="450"></canvas>
			</center>
		</div>
</div>
</div>
</div>
<script>
var ctx = document.getElementById('ChartVaccine').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($dategrap)?>,
        datasets: [{
            label: 'จำนวนวัคซีนสะสมรวมสองโดส',
            data: <?php echo json_encode($totalgrap)?>,
			backgroundColor: "rgba(238, 130, 238, 0.2)",
			borderColor: "rgba(238, 130, 238, 1)",
			yAxisID: "y",
            borderWidth: 1,
			fill: false
		},{
            label: 'จำนวนวัคซีนสะสม เข็มแรก',
            data: <?php echo json_encode($fistgrap)?>,
            backgroundColor: "rgba(54, 162, 235, 0.2)",
			borderColor: "rgba(54, 162, 235, 1)",
			yAxisID: "y",
            borderWidth: 1,
			fill: true
		},{
            label: 'จำนวนวัคซีนสะสม เข็มที่สอง',
            data: <?php echo json_encode($secondgrap)?>,
            backgroundColor: "rgba(255, 206, 86, 0.2)",
			borderColor: "rgba(255, 206, 86, 1)",
			yAxisID: "y",
            borderWidth: 1,
			fill: true
		}
		]
    },
    options: {
        scales: {
            y: {
            }
        }
    }
});
</script>
<p style="text-align:center;color:Red;size:10"><b>Credit Data : https://covid-19.researcherth.co/</b></p>
<hr class="my-4">
<h4 style="text-align:center">copyright © 2021 - Develop By <a href="https://www.facebook.com/krt.korarit/">Korarit Sangthong</a></h4>
<hr class="my-4">
</body>
</html>