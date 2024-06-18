<!DOCTYPE html>
<html>
<head>
	<?php require_once 'connect.php'; ?>
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	 <script src="https://www.gstatic.com/charts/loader.js"></script>
    <style type="text/css">
    	
body{
	text-align: center;
	margin: 0;
    padding: 0;
}

.pad{
	border-collapse: collapse;
	border-bottom: 1px solid lightgrey;
	padding: 5px;
	text-align: center;
	width: 100px;
}

.th1{
color: white;
background-color: black;
text-align: center;
vertical-align: middle;
font-weight: bold;
font-size: 11px;
padding-top: 2px;
padding-bottom: 2px;
}

.th2{
	border: none; 
	text-align: right;
	font-size: 15px;
	font-weight: bold;
}

.table1{
	vertical-align: top;
	display: inline-block;
	border-collapse: collapse;
	margin-bottom: 10px;
	border-bottom: 2px double lightgrey;
	font-size: 10px;
	width: 690px;
}

.table2{
	border-bottom: none;
	margin-top: -75px;
}

.kh{
	text-align: right;
	width: 120px;
}

.b1{
	font-size: 12px;
}

p{
display: inline-block;
}

.ta1{
	text-align: right;
	font-size: 12px;
	margin-right: 10px;
}

.month{
display: inline-block;
margin-right: 2px;
}

.year{
display: inline-block;
}

.st{
	margin-top: 0;
	margin-bottom: -2px;
	font-size: 15px;
	font-weight: bold;
}

.ok{
	font-size: 15px;
	font-weight: bold;
	margin-top: -10px;
}

.inf{
	font-size: 15px;
	margin-top: -3px;
}

.m1{
	margin-top: 4px;
}

.img1{
display: block;
margin-left: 400px;
position: absolute;
align-self: center;
width: 100px;
height: 100px;
}

.kh2{
	width: 2px;
}

#donutchart{
width: 200px;
height: 90px;
margin-top: 100px;
margin-left: -300px;
vertical-align: top;
float: left;
}

#top_x_div{
width: 350px;
height: 90px;
margin-left: 10px;
vertical-align: top;
float: left;
}

    </style>
	<title>التقرير الميداني</title>
</head>
<body>
	<br>
	<?php 
	if (isset($_GET['b_month']) and isset($_GET['b_year'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE k_month='".$_GET['b_month']."' AND k_year='".$_GET['b_year']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['b_month']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures WHERE ID=1") or die($conn->error());
	$c1 = mysqli_num_rows($re1);
	if ($c1 > 0){
	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	 ?>
	<div class="ta1">
	<div id="top_x_div" align="left"></div>
    <div id="donutchart" align="left"></div>
    <img src="<?php echo $tp1['p_source']; ?>" class="img1">
	<p class="st t11">مركز الدعوة الاسلامي</p>
	<br>
	<p class="st m1">التقرير الميداني</p>
	<br>
	<p class="month"><?php echo $tr1['m_name']; ?></p>
	<p class="year"><?php echo $ro1['k_year']; ?></p>
	<br>
	<p class="ok">تم الاطلاع على التقرير والموافقة بما ورد فيه</p>
	<br>
	<p class="inf"><?php echo $ro1['k_person']; ?></p>
	<br>
	<p class="inf"><?php echo $ro1['k_email']; ?></p>
	<br>
	<p class="inf"><?php echo $ro1['k_time']; ?></p>
	<br>
	</div>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['المركز', 'نسبة المهتدين'],
          <?php 
		$result10 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
		while ($row10 = $result10->fetch_assoc()) {
			$result111 =  $conn->query("SELECT SUM(b_attend) as b_attend, SUM(b_countm) as b_countm FROM rprograms WHERE b_markaz='".$row10['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
			$row111 = $result111->fetch_assoc();
			if ($row111['b_attend'] > 0){
			$n1 = $row111['b_countm'];
			$n2 = $row111['b_attend'];
			$n3 = $n1/$n2;
			echo "['".$row10['mname']."',".$n3."],";
			}}
          ?>
        ]);

        var options = {
          title: 'نسبة المهتدين',
          pieHole: 0.4,
          pieSliceText: 'none',
          chartArea: {width:'100%'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
     <script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var loadDaysLeadGraphData = [
         ['اعداد المهتدين', 'عدد المهتدين'],
          <?php 
			 $result10 = $conn->query("SELECT * FROM marakez WHERE myear=".$_GET['b_year']) or die($conn->error());
			 while ($row10 = $result10->fetch_assoc()) {
			 		$result11 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_markaz= '".$row10['ID']."' AND b_month= '".$_GET['b_month']."' AND b_year='".$_GET['b_year']."'") or die($conn->error());
			 		$row11 = $result11->fetch_assoc();
           echo "['".$row10['mname']."',".$row11['b_countm']."],";
	 	}         
         ?>
  ];

  var data = google.visualization.arrayToDataTable(loadDaysLeadGraphData);
   var options = {
   	title: '',
     hAxis: {
       title: "",
       textPosition: 'in',
       slantedText: true,
       slantedTextAngle: 15
    },
    width: '100%',
    vAxis: {
      title: 'اعداد المهتدين',
      titleTextStyle:{
      	bold: true
      },
      minValue: 0,
      viewWindow: { min: 0 },
      format: '0',
    },
    bar:{
    	groupWidth: '42%'
    },
    legend: {
    	position: 'none'
    },
    theme: 'material'
  };
  var chart = new google.visualization.ColumnChart(document.getElementById('top_x_div'));
  chart.draw(data, options);
}
    </script>
	<br>
	<br>
	<br>
	<br>
	<?php
	$result = $conn->query("SELECT * FROM marakez WHERE myear=".$_GET['b_year']) or die($conn->error());
	$result4 = $conn->query("SELECT * FROM marakez WHERE myear=".$_GET['b_year']) or die($conn->error());
	?>
			<table class="table1 table2">
				<thead>
					<tr>
						<td colspan="7" class="th2">الاجماليات</td>
					</tr>
					<tr>
					<th class="th1 th2"></th>
					<th class="th1">البرامج الاذاعية</th>
					<th class="th1">الخطب</th>
					<th class="th1">المهتدين</th>
					<th class="th1">الحضور التقريبي</th>
					<th class="th1">المناظرات</th>
					<th class="th1 kh">المركز</th>
				</tr>
				</thead>
		<?php while ($row4 = $result4->fetch_assoc()) {	?>
					<?php	
					$result6 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_markaz= '".$row4['ID']."' AND b_month= '".$_GET['b_month']."' AND b_year='".$_GET['b_year']."'") or die($conn->error());
					$result7 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_month='".$_GET['b_month']."' AND b_year='".$_GET['b_year']."'") or die($conn->error());
					$row6 = $result6->fetch_assoc() 
					?>
					<tr>
					<td class="pad kh2"></td>
					<td class="pad"><?php echo $row6['b_countt']; ?></td>
					<td class="pad"><?php echo $row6['b_countk']; ?></td>
					<td class="pad"><?php echo $row6['b_countm']; ?></td>
					<td class="pad"><?php echo $row6['b_attend']; ?></td>
					<td class="pad"><?php echo $row6['b_countr']; ?></td>
					<td class="pad kh"><?php echo $row4['mname']; ?></td>
						</tr>
		<?php }	$row7 = $result7->fetch_assoc() ?>
				<tr>
					<td class="th1 b1 kh2"></td>
					<td class="th1 b1"><?php echo $row7['b_countt']; ?></td>
					<td class="th1 b1"><?php echo $row7['b_countk']; ?></td>
					<td class="th1 b1"><?php echo $row7['b_countm']; ?></td>
					<td class="th1 b1"><?php echo $row7['b_attend']; ?></td>
					<td class="th1 b1"><?php echo $row7['b_countr']; ?></td>
					<td class="th1 b1">الاجمالي</td>
				</tr>
			</table>

		<?php while ($row = $result->fetch_assoc()){ ?>
		 	<table class="table1">
				<thead>
					<tr>
						<td colspan="7" class="th2"><?php echo $row['mname']; ?></td>
					</tr>
					<tr>
					<th class="th1 th2"></th>
					<th class="th1">البرامج الاذاعية</th>
					<th class="th1">الخطب</th>
					<th class="th1">المهتدين</th>
					<th class="th1">الحضور التقريبي</th>
					<th class="th1">المناظرات</th>
					<th class="th1 kh">الفرقة</th>
					</tr>
				</thead>
			<?php
					$result2 =  $conn->query("SELECT * FROM rprograms WHERE b_markaz= '".$row['ID']."' AND b_month= '".$_GET['b_month']."' AND b_year='".$_GET['b_year']."'") or die($conn->error());
					while ($row2 = $result2->fetch_assoc()) {
					$result3 = $conn->query("SELECT * from groups WHERE ID=".$row2['b_group']) or die($conn->error());

					while ($row3 = $result3->fetch_assoc()) {
					?>
						<tr>
					<td class="pad kh2"></td>
					<td class="pad"><?php echo $row2['b_countt']; ?></td>
					<td class="pad"><?php echo $row2['b_countk']; ?></td>
					<td class="pad"><?php echo $row2['b_countm']; ?></td>
					<td class="pad"><?php echo $row2['b_attend']; ?></td>
					<td class="pad"><?php echo $row2['b_countr']; ?></td>
					<td class="pad kh"><?php echo $row3['group_name']; ?></td>
					<?php	}}	?>
					</tr>
				<?php } ?>				
	</table>
<?php } }?>
</body>
</html>