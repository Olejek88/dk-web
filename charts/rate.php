<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_bar.php");

include("config/local.php"); 
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='utf8'"; mysql_query ($query,$i);
$query = "set character_set_results='utf8'"; mysql_query ($query,$i);
$query = "set collation_connection='utf8_general_ci'"; mysql_query ($query,$i);

$query = 'SELECT * FROM scada_products';
$r = mysql_query ($query,$i); $cnt=0;
if ($r) $uo = mysql_fetch_row ($r);
while ($uo)
	{	
	 $datay[$cnt]=$uo[9];
	 $datax[$cnt]=$uo[3];
	 $uo = mysql_fetch_row ($r); $cnt++;
	}

$width=470; 
$height=1000;

// Set the basic parameters of the graph 
$graph = new Graph($width,$height,'auto');
$graph->SetScale("textlin");

$top = 60;
$bottom = 20;
$left = 150;
$right = 20;
$graph->Set90AndMargin($left,$right,$top,$bottom);

$graph->SetMarginColor('lavender');

// Nice shadow
$graph->SetShadow();

// Setup title
$graph->title->Set("SCADA Rating");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,12);

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);

// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(5);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);
$graph->yaxis->SetLabelAlign('center','bottom');
$graph->yaxis->SetLabelAngle(45);
$graph->yaxis->SetLabelFormat('%d');
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,9);

// We don't want to display Y-axis
//$graph->yaxis->Hide();

// Now create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillColor("orange");
$bplot->SetShadow();

//You can change the width of the bars if you like
//$bplot->SetWidth(0.5);

// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_BOLD,11);
$bplot->value->SetAlign('left','center');
$bplot->value->SetColor("black","darkred");
$bplot->value->SetFormat('%.2f');

// Add the bar to the graph
$graph->Add($bplot);


$graph->Stroke();
?>