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
$date=$_GET["date"];
if ($date=='') $date='20090408';
//------------------------------------------------------------------------
  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$_GET["type"];
  $a = mysql_query ($query,$i);
  $uy = mysql_fetch_row ($a); $cn=1;
  if ($uy[0]==8) { $data[1]=0; $cn++; }

  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$_GET["type"].' ORDER BY flat_number';
  $a = mysql_query ($query,$i);
  $uy = mysql_fetch_row ($a);
  while ($uy)
	{
	  $query = 'SELECT SUM(value) FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1].' AND value>0 AND date='.$date.'000000';
	  // echo $query;
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  $data[$cn]=$ur[0]; $cn++;	
	  $uy = mysql_fetch_row ($a);        
	}
$ct=0; $sum=0;
for ($u=1; $u<=8; $u++)  
{
 $d=$u+1;
 $dat[$u-1]='lv'.$u.'-'.$d;
 //echo $data[$u].' '.$data[$u+1].'('.$data[9].')<br>';
 if ($u==1)	
	{
	 if (($data[1]-$data[9]<400)) { $data0[$u-1]=($data[$u]-$data[9]);  $dat[$u-1]='lv1-9'; }
	 else if (($data[1]-$data[9]>400)) $data0[$u-1]=($data[2]-$data[1]);
	 if ($data0[$u-1]<0) $data0[$u-1]=0;
        }
 if ($u>1)
 if (($data[$u+1]-$data[$u]<400) && ($data[$u+1]-$data[$u]>0)) $data0[$u-1]=($data[$u+1]-$data[$u]); 
 else $data0[$u-1]=0;

 if ($data0[$u-1]>0) { $sum+=$data0[$u-1]; $ct++; }
}
for ($u=1; $u<=8; $u++) if ($data0[$u-1]==0) $data0[$u-1]=$sum/$ct;


$graph = new Graph(200,100,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(2,8,12,25);
//----------- title --------------------
$graph->Add($lineplot);
$name='Temperature strut '.$_GET["type"];
$graph->title->Set($name);

//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>