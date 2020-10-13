<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

//------------------------------------------------------------------------
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 while ($uy)
         {
	  $data[$cn]=0;
	  if ($_GET["type"]==11) $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=11 AND date='.$_GET["date"];
	  if ($_GET["type"]==13) $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=13 AND date='.$_GET["date"];
	  if ($_GET["type"]==14) $query = 'SELECT AVG(value) FROM prdata WHERE type=2 AND device='.$uy[1].' AND (prm=13 OR prm=11) AND value>20 AND date>'.$_GET["st"].' AND date<'.$_GET["fn"];
//echo $query;
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		 $data[$cn]=1*$ui[5];
		 if ($_GET["type"]==14) $data[$cn]=1*$ui[0];
			
		  if ($data[$cn]>=0) $data[$cn]=number_format($data[$cn],2);
		  else $data[$cn]=0;
		  //echo $data[$cn].'<br>';
		  $ui = mysql_fetch_row ($e);
		}
	  $dat[$cn]=$cn+1;
	  $cn++;
	  $uy = mysql_fetch_row ($a);
         }

$graph = new Graph(800,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(30,15,20,30);
//----------- title --------------------
$graph->Add($lineplot);
if ($_GET["type"]==14) 
	{
	 if ($_GET["st"]=='20090200000000') $_GET["date"]='Февраль';
	 if ($_GET["st"]=='20090300000000') $_GET["date"]='Март';
	 if ($_GET["st"]=='20090400000000') $_GET["date"]='Апрель';
	}
$title='Расход тепловой энергии (кДж) за '.$_GET["date"];
$graph->title->Set($title);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>