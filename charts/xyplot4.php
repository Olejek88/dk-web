<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_line.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$today=getdate();
$ye=$today["year"];
$mm=$today["mon"];
$mx=$today["hours"]-1; 
$mn=1; $nx=5; $nn=1;
if ($mx>1) $mx--;

$x=$today["hours"]+48;
$month=''.$month;
//echo $mx.'<br>';
if ($today["mon"]<10) $today["mon"]='0'.$today["mon"];
if ($today["mday"]<10) $today["mday"]='0'.$today["mday"];

for ($tn=$nx; $tn>=$nn; $tn--)
for ($tm=$mx; $tm>=$mn; $tm--)
    {
     $data0[$x]=0; $data1[$x]=0; $dtt=-1;     
     if ($tm<10) 
	{
	 $date1=$today["year"].$today["mon"].$today["mday"].'0'.$tm.'0000';
	 $dat[$x]='0'.$tm.':00';
	}
     else
	{
	 $date1=$today["year"].$today["mon"].$today["mday"].$tm.'0000';
	 $dat[$x]=$tm.':00';
	}     
     $query = 'SELECT * FROM data WHERE type=1 AND flat=0 AND date='.$date1;
     //echo $query.'<br>';
     $dt0=0; $dt1=0;
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
         {          
	  if ($uy[8]==11 && $uy[6]==0) $data0[$x]=$uy[3];
	  if ($uy[8]==11 && $uy[6]==1) $data1[$x]=$uy[3];	  
	  $uy = mysql_fetch_row ($a);	     
         }
     //echo  $data0[$x].'<br>';
     
     //if ($data0[$x]>$max) { $max=$data0[$x]; $datemax=$dat[$x]; }
     //if ($data0[$x]<$min) { $min=$data0[$x]; $datemin=$dat[$x]; }
     if ($x==0) break; 
     $x--; 
     if ($tn<5 && $tm==1)
	{
	 $mx=23;
         if ($today["mday"]>1) 
	    { 
	     $today["mday"]--; 
	     if ($today["mday"]<10) $today["mday"]='0'.$today["mday"]; 
    	    } 
	 else 
	    { 
	     $today["mday"]=31;
	     if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	     if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	     if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	     
	     if ($arr["month"]>1) $arr["month"]--;
	     else { $arr["month"]=12; $arr["year"]--; }
	     if ($arr["month"]<10) $arr["month"]='0'.$arr["month"];
	    }
	}
    }

//for ($i=0; $i<31; $i++) print $dat[$i].' '.$data0[$i];
// Create the graph. These two calls are always required
$graph = new Graph(500,220,"auto");	
$graph->img->SetMargin(30,15,5,30);

$graph->SetScale("textlin");

$graph->SetShadow();

$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);

// Create the linear plot
$lineplot=new LinePlot($data0);
$lineplot2=new LinePlot($data1);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->Add($lineplot2);

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
$graph->xaxis->SetTextTickInterval(5,0);

$graph->legend->Pos(0.15,0.02);
//--------------------------------------
// Display the graph
$graph->Stroke();
?>