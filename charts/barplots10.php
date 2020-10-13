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
 include("../time.inc"); 

$query = 'SELECT * FROM flats WHERE ent='.$_GET["n1"].' ORDER BY flat';
$a = mysql_query ($query,$i); $cn=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $cold=number_format($uy[10]*130*(31)/31,2);
     $data1[$cn]=$data2[$cn]=0;
     $data01[$cn]=$data02[$cn]=0;
     $query = 'SELECT * FROM device WHERE type=4 AND flat='.$uy[1];
	//echo $query;
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) 
	{
	 $device[$cn]=$ui[1]; 
	     $dolg[$cn]=$uy[12];
	     $dat[$cn]=$uy[1];
	 //echo $device[$cn].'<br>';
	 $cn++;
	}
     $uy = mysql_fetch_row ($a);
    }
$max=$cn-1; $cn=0; 
$dev=$ui[1];

$query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=2 AND date>'.$_GET["st"].' AND value>0 AND date<'.$_GET["fn"].' ORDER BY date';
//echo $query;
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e);
while ($ui)
    {
     for ($w=0;$w<$max;$w++)	
	    if ($device[$w]==$ui[1])
		{
		 if ($data01[$w]==0)  $data01[$w]=$ui[5]; 
		}
     $ui = mysql_fetch_row ($e);    
    }                                                
 //echo ' '.$data01[$cn].'<br>';
$query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=2 AND date>'.$_GET["st"].' AND date<'.$_GET["fn"].' ORDER BY date DESC';
//echo $query;
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e);
while ($ui)
    {
     for ($w=0;$w<$max;$w++)	
	    if ($device[$w]==$ui[1])
		if ($data02[$w]==0)  $data02[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                

for ($w=0;$w<$max;$w++)	
    {
     if ($data02[$w]>=$data01[$w]) $data1[$w]=($data02[$w]-$data01[$w]);
	else $data1[$w]=$data02[$w];
	//echo $data02[$w].' '.$data01[$w].'<br>';
     if ($data1[$w]<0) $data1[$w]=0;
     if ($dolg[$w]>0) { $data2[$w]=$data1[$w]; $data1[$w]=0; }
    }
$graph = new Graph(1200,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$lineplot->SetFillColor("blue");
$lineplot2=new BarPlot($data2);
$lineplot2->SetFillColor("red");

//$l1plot=new LinePlot($data0);
//$l1plot->SetColor("red");
//$l1plot->SetWeight(2);

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

$title='Потребление потребление электроэнергии, квартиры '.$_GET["n1"].' подъезда (кВт)';

$graph->title->Set($title);

// Add the plot to the graph
$graph->img->SetMargin(35,10,5,23);
//----------- title --------------------
$gbplot = new AccBarPlot(array($lineplot,$lineplot2));
//$gbplot->value->Show();
$graph->Add($gbplot);

//$graph->Add($l1plot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>