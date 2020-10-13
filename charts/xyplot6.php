<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$today=getdate();
$ye=$today["year"];
$mm=$today["mon"];
$mx=$today["mday"];
$mn=1; $nx=6; $nn=1;
$x=0;
$month=''.$month;

$query = 'SELECT SUM(square),SUM(rnum) FROM flats';
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $kk=$uy[0];

for ($tn=$nx; $tn>=$nn; $tn--)
for ($tm=$mx; $tm>=$mn; $tm--)
    {
     $data0[$x]=0; $data1[$x]=0; $data2[$x]=0; 
     $date1=sprintf ("%d%02d%02d000000",$today["year"],$today["mon"],$tm);
     $dats[$x]=$tm.'/'.$today["mon"];

     if ($_GET["type"]=='1')
	{
	     $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=5 AND flat=0 AND date='.$date1;
	     //echo $query.'<br>';
	     $a = mysql_query ($query,$i);
	     if ($a) $uy = mysql_fetch_row ($a);
	     if ($uy) $datas0[$x]=$uy[3];
	     //if ($datas0[$x]<40) $datas0[$x]=$datas0[$x-1];
	     $datas1[$x]=60;	     if ($tn==1) $mn=10;
	     $x++;
	}

     if ($_GET["type"]=='2') 
	{
	     $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=3 AND flat=0 AND date='.$date1;
	     $a = mysql_query ($query,$i);
	     if ($a) $uy = mysql_fetch_row ($a);
	     if ($uy) $datas2[$x]=$uy[3];
	     $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0 AND date='.$date1;
	     $a = mysql_query ($query,$i);
	     if ($a) $uy = mysql_fetch_row ($a);
	     if ($uy) $datas3[$x]=$uy[3];
	     $query = 'SELECT * FROM data WHERE type=2 AND prm=12 AND source=5 AND flat=0 AND date='.$date1;
	     $a = mysql_query ($query,$i);
	     if ($a) $uy = mysql_fetch_row ($a);
	     if ($uy) $datas4[$x]=$uy[3];
	     //echo $date1.' '.$datas4[$x].' '.$datas2[$x].' '.$datas3[$x];
	     if ($datas4[$x]<1) if ($datas4[$x-1]>0) $datas4[$x]=$datas4[$x-1];
	     if ($datas4[$x]>1 && ($datas2[$x]-$datas3[$x])>0)
		{
		  $datas2[$x]=($datas2[$x]-$datas3[$x])/$datas4[$x];
		  $datas3[$x]=0.0467;
		  $x++;		   
		}
	 if ($tn==1) $mn=10;
	}
     if ($_GET["type"]=='3' || $_GET["type"]=='4') 
	{
	 $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=0 AND flat=0 AND date='.$date1;
         $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
         if ($uy) $datas5[$x]=$uy[3];
         $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=1 AND flat=0 AND date='.$date1;
         $a = mysql_query ($query,$i);
         if ($a) $uy = mysql_fetch_row ($a);
         if ($uy) $datas6[$x]=$uy[3];
         $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0 AND date='.$date1;
         $a = mysql_query ($query,$i);
         if ($a) $uy = mysql_fetch_row ($a);
         if ($uy) $datas7[$x]=$uy[3];

          //echo $datas7[$x].'<br>';
          $datas7[$x]=number_format($datas7[$x],0);
          if ($datas7[$x]<=-24) { $datas8[$x]=93; $datas9[$x]=76; }
          if ($datas7[$x]==-23) { $datas8[$x]=92; $datas9[$x]=75; }
          if ($datas7[$x]==-22) { $datas8[$x]=91; $datas9[$x]=74; }
          if ($datas7[$x]==-21) { $datas8[$x]=90; $datas9[$x]=73; }
          if ($datas7[$x]==-20) { $datas8[$x]=88; $datas9[$x]=72; }
          if ($datas7[$x]==-19) { $datas8[$x]=87; $datas9[$x]=71; }
          if ($datas7[$x]==-18) { $datas8[$x]=86; $datas9[$x]=70; }
          if ($datas7[$x]==-17) { $datas8[$x]=84; $datas9[$x]=69; }
          if ($datas7[$x]==-16) { $datas8[$x]=83; $datas9[$x]=68; }
          if ($datas7[$x]==-15) { $datas8[$x]=81; $datas9[$x]=67; }
          if ($datas7[$x]==-14) { $datas8[$x]=80; $datas9[$x]=66; }
          if ($datas7[$x]==-13) { $datas8[$x]=79; $datas9[$x]=65; }
          if ($datas7[$x]==-12) { $datas8[$x]=77; $datas9[$x]=64; }
          if ($datas7[$x]==-11) { $datas8[$x]=76; $datas9[$x]=63; }
          if ($datas7[$x]==-10) { $datas8[$x]=74; $datas9[$x]=61; }
          if ($datas7[$x]==-9) { $datas8[$x]=73; $datas9[$x]=60; }
          if ($datas7[$x]==-8) { $datas8[$x]=71; $datas9[$x]=59; }
          if ($datas7[$x]==-7) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-6) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-5) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-4) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-3) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-2) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==-1) { $datas8[$x]=70; $datas9[$x]=60; }
          if ($datas7[$x]==0) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]==1) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]==2) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]==3) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]==4) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]==5) { $datas8[$x]=70; $datas9[$x]=61; }
          if ($datas7[$x]>=6) { $datas8[$x]=70; $datas9[$x]=62; }
	  if ($datas5[$x]>40 && $datas6[$x]>40) $x++;
	}
     if ($_GET["type"]=='5') 
	{
	 $query = 'SELECT * FROM data WHERE type=2 AND prm=13 AND source=2 AND flat=0 AND date='.$date1;
         $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
         if ($uy) $datas6[$x]=$uy[3];
         $query = 'SELECT * FROM data WHERE type=2 AND prm=4 AND source=10 AND flat=0 AND date='.$date1;
         $a = mysql_query ($query,$i);
         if ($a) $uy = mysql_fetch_row ($a);
         if ($uy) $datas7[$x]=$uy[3];

	 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];
	 $datas8[$x]=$kk*0.0322/31;
	 $datas9[$x]+=0.291*24*(18-$datas7[$x])/52;
	 //echo $datas6[$x].' - '.$datas9[$x].'<br>';
	 if ($datas6[$x]>0 && $datas9[$x]<30) { $x++; }
	 $ct++;
	 if ($tn==1) $mn=10;
	}
     if ($tm==1)
	{
	 if ($today["mon"]>1) $today["mon"]--;
	 else { $today["mon"]=12; $today["year"]--; }
	 $today["mday"]=31;
	 if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	 if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	 if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	 $mx=$today["mday"];
	}
    }
//$x--;
for ($i=0; $i<=$x; $i++) 
	{ 
	 $dat[$i]=$dats[$x-$i]; 
	 if ($_GET["type"]=='1') { $data0[$i]=$datas0[$x-$i]; $data1[$i]=$datas1[$x-$i]; }
	 if ($_GET["type"]=='2') { $data0[$i]=$datas2[$x-$i]; $data1[$i]=$datas3[$x-$i]; }
	 if ($_GET["type"]=='3') { $data0[$i]=$datas5[$x-$i]; $data1[$i]=$datas8[$x-$i]; }
	 if ($_GET["type"]=='4') { $data0[$i]=$datas6[$x-$i]; $data1[$i]=$datas9[$x-$i]; }
	 if ($_GET["type"]=='5') { $data2[$i]=$datas6[$x-$i]; $data1[$i]=$datas8[$x-$i]; $data0[$i]=$datas9[$x-$i]; }
	}

//for ($i=0; $i<31; $i++) print $dat[$i].' '.$data0[$i];
// Create the graph. These two calls are always required
$graph = new Graph(1100,300,"auto");	
$graph->img->SetMargin(50,15,5,30);

$lineplot3=new BarPlot($data2);
$lineplot3->SetFillColor("green");

if ($_GET["type"]=='1') $graph->SetScale("textlin",0,100);
if ($_GET["type"]=='2') $graph->SetScale("textlin");
if ($_GET["type"]=='3') $graph->SetScale("textlin",35,110);
if ($_GET["type"]=='4') $graph->SetScale("textlin",40,85);
if ($_GET["type"]=='5') $graph->SetScale("textlin");

$graph->SetShadow();

$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);

// Create the linear plot
$lineplot=new LinePlot($data0);
$lineplot2=new LinePlot($data1);

if ($_GET["type"]=='1') { $datw[0]='Фактическая температура горячей воды'; $datw[1]='Нормативное значение температуры горячей воды     '; }
if ($_GET["type"]=='2') { $datw[0]='Удельный расход тепловой энергии на подготовку ГВС     '; $datw[1]='Нормативное значение'; }
if ($_GET["type"]=='3') { $datw[0]='Фактическая температура подающей на входе в дом          '; $datw[1]='Договорное значение'; }
if ($_GET["type"]=='4') { $datw[0]='Фактическая температура обратной на входе в дом          '; $datw[1]='Договорное значение'; }
if ($_GET["type"]=='5') { $datw[1]='Нормативное значение'; $datw[2]='Фактический расход тепловой энергии     '; $datw[0]='Проектное значение     '; }

$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);

$lineplot->SetLegend($datw[0]);
$lineplot2->SetLegend($datw[1]);
if ($_GET["type"]=='5') { $lineplot3->SetLegend($datw[2]); }
//$lineplot3->SetLegend($datw[2]);

$graph->legend->SetAbsPos(70,10,'right','top');

// Add the plot to the graph
$graph->Add($lineplot2);
//if ($_GET["type"]!='5') 
$graph->Add($lineplot);
//else 
if ($_GET["type"]=='5') $graph->Add($lineplot3);

$graph->SetMarginColor('white');
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
//----------- legend -------------------
//$graph->xaxis->SetLabelAngle(45);
$lineplot->SetColor("blue");
$lineplot->SetWeight(2);
$lineplot2->SetColor("red");
$lineplot2->SetWeight(2);


$graph->yaxis->SetWeight(1);
$graph->xaxis->SetTickLabels($dat);
$graph->xaxis->SetTextTickInterval(7,0);

$graph->legend->Pos(0.15,0.02);
//--------------------------------------
// Display the graph
$graph->Stroke();
?>