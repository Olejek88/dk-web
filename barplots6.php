<?php
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_log.php");
include ("jpgraph/jpgraph_bar.php");
include("config/local.php");
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
	  $query = 'SELECT * FROM prdata WHERE (prm=1 OR prm=11) AND type=0 AND device='.$uy[1].' ORDER BY prm,pipe';
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  while ($ui)
         	{
		  $query = 'SELECT * FROM prdata WHERE type=1 AND device='.$uy[1].' AND prm='.$ui[2].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  if (!$ui[5]) $ui[5]=$ur[5];
			else $prev=$ui[5];
		  if ($ui[2]==1) if ($ui[7]==0) $data[0]=$ui[5];
		  if ($ui[2]==1) if ($ui[7]==1) $data[10]=$ui[5];
		  if ($ui[2]==11) if ($ui[7]==0) $data0[0]=$ui[5];
		  if ($ui[2]==11) if ($ui[7]==1) $data0[10]=$ui[5];
		  $ui = mysql_fetch_row ($e);
		}
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
	 $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1];
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e);
	 if ($ui)
	 while ($ui)
        	{
		  $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$uy[1].' AND pipe='.$ui[7].' AND value>0 ORDER BY date DESC';
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  if (!$ui[5]) $ui[5]=$ur[5];
			else $prev=$ui[5];
		  $data[$cn]=1*$ui[5];	
		  $ui = mysql_fetch_row ($e);
		}
	 //else $data[$cn]=$data[$cn-1];
	 $dat[$cn]='lv'.$cn; $cn++;
	 $uy = mysql_fetch_row ($a);        
	}
for ($u=1; $u<=9; $u++)  if (!$data[$u]) $data[$u]=($data[$u+1]+$data[$u-1])/2;

$graph = new Graph(400,160,"auto");
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
$graph->img->SetMargin(28,18,15,28);
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