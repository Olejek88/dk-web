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
if ($today["mday"]>2) $mx=$today["mday"]-2; else $mx=1;
$mn=1; $nx=$mm; $nn=$mm-3;
$x=0;
$month=''.$month;

$query = 'SELECT SUM(square),SUM(rnum) FROM flats';
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $kk=$uy[0];

if ($_GET["p"]=='1') $p=1;
if ($_GET["p"]=='' || $_GET["p"]=='2') $p=2;
if ($p==1) $mh=23; else $mh=0;
//echo $today["mday"];

for ($tn=$nx; $tn>=$nn; $tn--)
for ($tm=$mx; $tm>=$mn; $tm--)
for ($ts=$mh; $ts>=0; $ts--)
    {
     $data0[$x]=0; $data1[$x]=0; $data2[$x]=0; 
     if ($p==2) { $date1[$x]=sprintf ("%d%02d%02d000000",$today["year"],$today["mon"],$tm); 
	      $date2[$x]=sprintf ("%d-%02d-%02d 00:00:00",$today["year"],$today["mon"],$tm); }
     if ($p==1) { $date1[$x]=sprintf ("%d%02d%02d%02d0000",$today["year"],$today["mon"],$tm,$ts); 
	      $date2[$x]=sprintf ("%d-%02d-%02d %02d:00:00",$today["year"],$today["mon"],$tm,$ts); }
     $dats[$x]=$tm.'/'.$today["mon"];

//     echo $date1[$x].' '.$date2[$x].'<br>';
     if (($p==2 && $tm==1) || ($p==1 && $tm==1 && $ts==0))
	{
  	 if ($today["mon"]>1) $today["mon"]--;
	 else { $today["mon"]=12; $today["year"]--; }
	 $today["mday"]=31;
	 if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	 if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	 if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	 $mx=$today["mday"];
	 if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
	}
     if ($tn==$nn) $mn=$today["mday"];
     if ($p==1) if ($x>1000) break;
     if ($p==2) if ($x>150) break;
     $x++;
    }
$max=$x-1;

     $query = 'SELECT * FROM data WHERE type='.$p.' AND prm=13 AND value<30 AND source=3 AND flat=0';
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
	{
	 for ($rr=0;$rr<$max;$rr++)
	 if ($uy[2]==$date2[$rr]) $datas0[$rr]=$uy[3];
	 $uy = mysql_fetch_row ($a);
	}
     $query = 'SELECT * FROM data WHERE type='.$p.' AND prm=13 AND value<30 AND source=2 AND flat=0';
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
	{
	 for ($rr=0;$rr<$max;$rr++)
	 if ($uy[2]==$date2[$rr]) $datas1[$rr]=$uy[3];
	 $uy = mysql_fetch_row ($a);
	}
     //if ($datas0[$x]>0 && $datas1[$x]>0) $x++;


for ($i=0; $i<=$max; $i++) 
	{ 
	 $dat[$i]=$dats[$max-$i]; 
	 if ($_GET["type"]=='1') { if ($datas0[$max-$i]>50 && $datas1[$max-$i]>20) {$data0[$i]=$datas0[$max-$i]; $data1[$i]=$datas1[$max-$i];} else {$data0[$i]=$datas0[$max-$i-1]; $data1[$i]=$datas1[$max-$i-1];}}
	 if ($_GET["type"]=='2') { if ($datas0[$max-$i]>0 && $datas1[$max-$i]>0) {$data0[$i]=$datas0[$max-$i]; $data1[$i]=$datas1[$max-$i]; } else {$data0[$i]=$datas0[$max-$i-1]; $data1[$i]=$datas1[$max-$i-1];}}
	 if ($_GET["type"]=='3') { if ($datas0[$max-$i]>0 && $datas1[$max-$i]>0) {$data0[$i]=$datas0[$max-$i]; $data1[$i]=$datas1[$max-$i]; } else {$data0[$i]=$datas0[$max-$i-1]; $data1[$i]=$datas1[$max-$i-1];}}
	 if ($_GET["type"]=='4') { if ($datas0[$max-$i]>0 && $datas1[$max-$i]>0) {$data0[$i]=$datas0[$max-$i]; $data1[$i]=$datas1[$max-$i]; } else {$data0[$i]=$datas0[$max-$i-1]; $data1[$i]=$datas1[$max-$i-1];}}
	 if ($_GET["type"]=='5' || $_GET["type"]=='6' || $_GET["type"]=='7') 
		{ 
		 if ($datas0[$max-$i]>0 && $datas1[$max-$i]>0) 
			{$data0[$i]=$datas0[$max-$i]; $data1[$i]=$datas1[$max-$i]; } 
		 else {$data0[$i]=$datas0[$max-$i-1]; $data1[$i]=$datas1[$max-$i-1];}
		}
	}

//for ($i=0; $i<31; $i++) print $dat[$i].' '.$data0[$i];
// Create the graph. These two calls are always required
if ($_GET["size"]=='') $graph = new Graph(700,300,"auto");	
else $graph = new Graph(450,220,"auto");
$graph->img->SetMargin(30,15,5,30);

if ($_GET["type"]=='1') $graph->SetScale("textlin");
if ($_GET["type"]=='2') $graph->SetScale("textlin");
if ($_GET["type"]=='3') $graph->SetScale("textlin");
if ($_GET["type"]=='4') $graph->SetScale("textlin");
if ($_GET["type"]=='5') $graph->SetScale("textlin");
if ($_GET["type"]=='6') $graph->SetScale("textlin");
if ($_GET["type"]=='7') $graph->SetScale("textlin");

$graph->SetShadow();

$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);

// Create the linear plot
$lineplot=new LinePlot($data0);
$lineplot2=new LinePlot($data1);

if ($_GET["type"]=='1') { $datw[0]='Температура подающего     '; $datw[1]='Температура обратной     '; }
if ($_GET["type"]=='2') { $datw[0]='Тепловая энергия по подающей     '; $datw[1]='Тепловая энергия по обратной     '; }
if ($_GET["type"]=='3') { $datw[0]='Расход теплоносителя по подающей     '; $datw[1]='Расход теплоносителя по обратной     '; }
if ($_GET["type"]=='4') { $datw[0]='Потребленная тепловая энергия     '; $datw[1]='Расход тепловой энергии на СО     '; }
if ($_GET["type"]=='5') { $datw[1]='Расход ХВС     '; $datw[0]='Расход ГВС     '; }
if ($_GET["type"]=='6') { $datw[1]='Лифтовое хозяйство     '; $datw[0]='Электроэнергия на освещение     '; }
if ($_GET["type"]=='7') { $datw[1]='Тепловая энергия на отопление     '; $datw[0]='Температура наружного воздуха     '; }

$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);

$lineplot->SetLegend($datw[0]);
$lineplot2->SetLegend($datw[1]);

$graph->legend->SetAbsPos(30,10,'right','top');

// Add the plot to the graph
$graph->Add($lineplot);
$graph->Add($lineplot2);

$graph->SetMarginColor('white');
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
//----------- legend -------------------
//$graph->xaxis->SetLabelAngle(45);
$lineplot->SetColor("red");
$lineplot->SetWeight(2);
$lineplot2->SetColor("blue");
$lineplot2->SetWeight(2);

$graph->yaxis->SetWeight(1);
$graph->xaxis->SetTickLabels($dat);
if ($p==2) $graph->xaxis->SetTextTickInterval(10,0);
if ($p==1) $graph->xaxis->SetTextTickInterval(100,0);

$graph->legend->Pos(0.15,0.02);
//--------------------------------------
// Display the graph
$graph->Stroke();
?>