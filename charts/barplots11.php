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
 $query = 'SELECT * FROM dev_irp WHERE strut='.$_GET["type"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
  	  if ($_GET["date"]=='') $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND pipe=0 AND value>0 AND date=20090703000000';
	  else $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND pipe=0 AND value>0 AND date='.$_GET["date"];
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  $data[0]=$ur[5];
  	  if ($_GET["date"]=='') $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND pipe=1 AND value>0 AND date=20090703000000';
	  else $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND prm=1 AND pipe=1 AND value>0 AND date='.$_GET["date"];
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  $data[10]=$ur[5];

	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
//  $data[0]=$data[0]/$data0[0];   $data[10]=$data[10]/$data0[10];
  //$data[0]=number_format($data[0],2);   $data[10]=number_format($data[10],2);
  //echo $data[0];

  $dat[0]='in'; $dat[10]='out';
  for ($u=1; $u<=9; $u++)  $dat[$u]='lv'.$i;
  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$_GET["type"];
  $a = mysql_query ($query,$i);
  $uy = mysql_fetch_row ($a); $cn=1;
  if ($uy[0]==8) { $data[1]=0; $cn++; }

  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$_GET["type"].' ORDER BY flat_number';
  $a = mysql_query ($query,$i);
  $uy = mysql_fetch_row ($a);
  while ($uy)
	{
	  if ($_GET["date"]=='') $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1].' AND value>0 AND date=20090703000000';
	  else $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1].' AND value>0 AND date='.$_GET["date"];
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  $data[$cn]=$ur[5];	
	  //else $data[$cn]=$data[$cn-1];
	  $dat[$cn]='lv'.$cn; $cn++;
	  $uy = mysql_fetch_row ($a);        
	}
for ($u=3; $u<=8; $u++)  if (!$data[$u]) $data[$u]=($data[$u+1]+$data[$u-1])/2;
for ($u=1; $u<=9; $u++)  if (!$data[$u]) $data[$u]=($data[$u+1]);

$graph = new Graph(400,160,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLabels();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(8,18,14,25);
//----------- title --------------------
$graph->Add($lineplot);
$name='Ёнтальпи€ сто€ка '.$_GET["type"];
$graph->title->Set($name);

//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>