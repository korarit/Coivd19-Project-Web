<?php
//get functions
include('functions.php');



$lastPCRUpdate = getLastTestPCR();
$LastVaccineUpdata = getLastVaccineUpdate();
//print_r($lastPCRUpdate);
//print_r($LastVaccineUpdata);

//ดึงข้อมูล อันดับจำนวนการฉีดวัคซีนทังหมด

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.js" integrity="sha512-lUsN5TEogpe12qeV8NF4cxlJJatTZ12jnx9WXkFXOy7yFbuHwYRTjmctvwbRIuZPhv+lpvy7Cm9o8T9e+9pTrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>	
<body>
<center>
<button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#Modalprovince">ข้อมูลรายจังหวัด</button>
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
	<div class="card text-white mt-4 bg-success align-item-center mx-auto" style="width: 14em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:20">รักษาหาย</p>
			<b><p style="font-size:25">+<?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "todayRecovered")); ?></p></b>
			</center>
		</div>
		<div class="card-footer" style="width: 14em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "recovered")); ?></p></b></center>
		</div>
	</div>
	</div>
	<div class="col">
	<div class="card text-white mt-4 bg-danger mx-auto" style="width: 14em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:20">ติดเชื้อเพิ่ม</p>
			<b><p style="font-size:25">+<?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "todayCases")); ?></p></b>
			</center>
		</div>
		<div class="card-footer" style="width: 14em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "cases")); ?></p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<div class="d-flex justify-content-center mx-auto">
<div class="row">
	<div class="col">
	<div class="card text-white mt-4 bg-warning mx-auto" style="width: 14em;height: 11.6em">
		<div class="card-body">
		<center>
			<p style="font-size:20">รักษาตัวในร.พ.เพิ่มขึ้น</p>
			<b><p style="font-size:25">+ <?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "active") - getDataYesterday("Hospitalized", "https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/national-timeseries.json", "date")); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width: 14em">
			<center><b><p style="font-size:15">กำลังรักษาตัว <?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "active")); ?></p></b></center>
		</div>
	</div>
	</div>
	<div class="col mx-auto">
	<div class="card text-white mt-4 bg-secondary mx-auto" style="width: 14em;height: 11.6em">
		<div class="card-body mx-auto">
		<center>
			<p style="font-size:20">เสียชีวิต</p>
			<b><p style="font-size:25">+<?php echo getDataNow("https://disease.sh/v3/covid-19/countries/th", "todayDeaths"); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width:14em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format(getDataNow("https://disease.sh/v3/covid-19/countries/th", "deaths")); ?></p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<hr class="my-4">
<h5 style="text-align:center">กราฟในแต่ละวัน 7วันที่ผ่านมา</h5>
<div class="d-flex justify-content-center mx-auto">
<div class="row">
<div class="card mt-4 bg-light mx-auto" style="width: 40em;height: 20em">
		<div class="card-body mx-auto">
		<center>
			<canvas id="ChartDead" width="600" height="300"></canvas>
			</center>
		</div>
</div>
<div class="col">
<div class="card mt-4 bg-light mx-auto" style="width: 40em;height: 20em">
		<div class="card-body mx-auto">
		<center>
			<canvas id="ChartCase" width="600" height="300"></canvas>
			</center>
		</div>
</div>
</div>
</div>
</div>
<?php
$url_thai_series = "https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/cases/national-timeseries.json";
$dategrap = array(date('Y-m-d', strtotime("-6 day")), date('Y-m-d', strtotime("-5 day")), date('Y-m-d', strtotime("-4 day")), date('Y-m-d', strtotime("-3 day")), date('Y-m-d', strtotime("-2 day")), date('Y-m-d', strtotime("-1 day")), date('Y-m-d'));
$deadgrap = array(getDataAgoday("NewDeaths", 6, "$url_thai_series", "date"), getDataAgoday("NewDeaths", 5, "$url_thai_series", "date"), getDataAgoday("NewDeaths", 4, "$url_thai_series", "date"), getDataAgoday("NewDeaths", 3, "$url_thai_series", "date"), getDataAgoday("NewDeaths", 2, "$url_thai_series", "date"), getDataAgoday("NewDeaths", 1, "$url_thai_series", "date"), getDataLast("NewDeaths", "$url_thai_series", "date"));
$casegrap = array(getDataAgoday("NewConfirmed", 6, "$url_thai_series", "date"), getDataAgoday("NewConfirmed", 5, "$url_thai_series", "date"), getDataAgoday("NewConfirmed", 4, "$url_thai_series", "date"), getDataAgoday("NewConfirmed", 3, "$url_thai_series", "date"), getDataAgoday("NewConfirmed", 2, "$url_thai_series", "date"), getDataAgoday("NewConfirmed", 1, "$url_thai_series", "date"), getDataLast("NewConfirmed", "$url_thai_series", "date"));
?>
<script>
var ctx = document.getElementById('ChartDead').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dategrap)?>,
        datasets: [{
            label: 'เสียชีวิตเพิ่มขึ้นในแต่ละวัน 7 วันที่ผ่านมา',
            data: <?php echo json_encode($deadgrap)?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
		}]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>
<script>
var ctx = document.getElementById('ChartCase').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dategrap)?>,
        datasets: [{
            label: 'ติดเชื้อเพิ่มขึ้นในแต่ละวัน 7 วันที่ผ่านมา',
            data: <?php echo json_encode($casegrap)?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
		}
		]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>
<hr class="my-4">
<h4 style="text-align:center">ข้อมูลไม่อัพเดพทุกวัน ผมก็ไม่รู้ว่าทำไมไม่อัพเดพทุกวัน</h4>
<div class="d-flex justify-content-center mx-auto">
<div class="row">
	<div class="col">
	<div class="card text-white mt-4 bg-Primary mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body mx-auto">
		<center>
			<p style="font-size:20">จำนวนการตรวจ วันที่ <?php echo $lastPCRUpdate[0] ?></p>
			<b><p style="font-size:25">+<?php echo number_format($lastPCRUpdate[1]); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width: 22em">
			<center><b><p style="font-size:15">ติดเชื้อ <?php echo $lastPCRUpdate[2]; ?></p></b></center>
		</div>
	</div>
	</div>
	<div class="col">
	<div class="card text-white mt-4 bg-Info mx-auto" style="width: 22em;height: 11.6em">
		<div class="card-body mx-auto">
		<center>
			<p style="font-size:20">จำนวนผู้รับรับวัคซีน วันที่ <?php echo $LastVaccineUpdata[0]; ?></p>
			<b><p style="font-size:25">+<?php echo number_format($LastVaccineUpdata[5]); ?></p></b>
			</center>
		</div>
		<div class="card-footer mx-auto" style="width: 22em">
			<center><b><p style="font-size:15">สะสม <?php echo number_format($LastVaccineUpdata[1]); ?></p></b></center>
		</div>
	</div>
	</div>
</div>
</div>
<div class="d-flex justify-content-center mx-auto">
<div class="card text-white mt-4 bg-light mx-auto" style="width: 45em;height: 10em">
<table class="table mx-auto">
  <thead>
    <tr class="table-active mx-auto">
      <th scope="col"><b>เข็ม</b></th>
      <th scope="col"><b>จำนวนผู้รับรับวัคซีน</b></th>
      <th scope="col"><b>ร้อยละ ต่อ ประชากรทั้งประเทศ</b></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><?php echo number_format($LastVaccineUpdata[2]); ?></td>
      <td><?php echo $LastVaccineUpdata[6]; ?>%</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><?php echo number_format($LastVaccineUpdata[3]); ?></td>
      <td><?php echo $LastVaccineUpdata[7]; ?>%</td>
    </tr>
  </tbody>
</table>
<p style="text-align:center;color:Red;size:10"><b>หมายเหตุ : ตารางนี้เป็นข้อมูลวันที่ <?php echo $LastVaccineUpdata[0] ?></b></p>
</div>
</div>
<!--ตารางอันดับ total_doses -->
<br>
<h4 style="text-align:center">อันดับจังหวัดฉีดวัคซีน covid-19 โดส แรกมากสุด 5 จังหวัด</h4>
<div class="d-flex justify-content-center mx-auto">
<div class="card mt-4 bg-light mx-auto" style="width: 45em;height: 17em">
<table class="table">
  <thead>
    <tr class="table-active">
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
	  echo "<td>".$tabledata[$index]["province"]."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_1st_dose"])."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_2nd_dose"])."</td>";
	  echo "<td>".number_format($tabledata[$index]["total_3rd_dose"])."</td>";
	  echo "</tr>";
  }
  ?>
  </tbody>
</table>
<p style="text-align:center;color:Red;size:10"><b>หมายเหตุ : ตารางนี้เป็นข้อมูลวันที่ <?php echo getDataNow("https://raw.githubusercontent.com/wiki/porames/the-researcher-covid-data/vaccination/provincial-vaccination.json", "update_date"); ?></b></p>
</div>
</div>
<p style="text-align:center;color:Red;size:10"><b>Credit Data : https://disease.sh/ และ https://covid-19.researcherth.co/</b></p>
<hr class="my-4">
<h4 style="text-align:center">copyright © 2021 - Develop By <a href="https://www.facebook.com/krt.korarit/">Korarit Sangthong</a></h4>
<hr class="my-4">
</body>
</html>