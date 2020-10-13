<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
$query = 'SELECT * FROM flats WHERE ent='.$_GET["n1"].' ORDER BY flat';
$a = mysql_query ($query,$i); $cn=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $data1[$cn]=$data2[$cn]=0;
     $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$uy[1];
	//echo $query;
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) 
	{

	 $dat[$cn]=$uy[1];
	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date>'.$_GET["st"].' AND device='.$ui[1].' ORDER BY date LIMIT 1';	
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui)
	    {
	     $data01[$cn]=$ui[5];
	    }                                                
	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8  AND date<'.$_GET["fn"].' AND device='.$ui[1].' ORDER BY date DESC LIMIT 1';	
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui)
	    {
	     $data02[$cn]=$ui[5];
	    }

	 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=6 AND date>'.$_GET["st"].' AND device='.$ui[1].'  ORDER BY date LIMIT 1';	
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui) $data11[$cn]=$ui[5];
	 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=6  AND date<'.$_GET["fn"].' AND device='.$ui[1].'  ORDER BY date DESC LIMIT 1';	
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui) $data12[$cn]=$ui[5];
	}
     $data1[$cn]=$data02[$cn]-$data01[$cn]; if ($data1[$cn]<0 || $data1[$cn]>50) $data1[$cn]=0;
     $data2[$cn]=$data12[$cn]-$data11[$cn]; if ($data2[$cn]<0 || $data2[$cn]>50) $data2[$cn]=0;
     $cn++;
     $uy = mysql_fetch_row ($a);
    }

$graph = new Graph(1200,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$lineplot2=new BarPlot($data2);
$lineplot->SetFillColor("blue");
$lineplot2->SetFillColor("red");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();
//$lineplot2->value->Show();

$lineplot->SetLegend("Холодная вода   ");
$lineplot2->SetLegend("Горячая вода   ");
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);
$graph->legend->SetAbsPos(70,10,'right','top');

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
$lineplot2->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
if ($_GET["n1"]==1) $graph->title->Set("Потребление холодной и горячей воды квартиры 1 подъезд (м3)");
if ($_GET["n1"]==2) $graph->title->Set("Потребление холодной и горячей воды квартиры 2 подъезд (м3)");
if ($_GET["n1"]==3) $graph->title->Set("Потребление холодной и горячей воды квартиры 3 подъезд (м3)");
if ($_GET["n1"]==4) $graph->title->Set("Потребление холодной и горячей воды квартиры 4 подъезд (м3)");

// Add the plot to the graph
$graph->img->SetMargin(35,10,5,30);
//----------- title --------------------
$gbplot  = new GroupBarPlot (array($lineplot ,$lineplot2)); 
$graph->Add($gbplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,9); 
// Display the graph
$graph->Stroke();
?>