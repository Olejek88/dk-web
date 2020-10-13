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
$today=getdate();
 if ($_GET["year"]>2000) $today["year"]=$_GET["year"];

 if ($_GET["date"]=='') 
	{ 
	 $st=sprintf ("%d%02d000000",$today["year"],$today["mon"]-1);
	 $fn=sprintf ("%d%02d000000",$today["year"],$today["mon"]);
	 $k=1; 
	}
 else 
	{ 
	 if ($_GET["date"]!=$today["mon"]) $k=1;
	 else $k=$today["mday"]/31;

	 $st=sprintf ("%d%02d01000000",$today["year"],$_GET["date"]);
	 $fn=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]+1);
	}

$query = 'SELECT * FROM flats WHERE ent='.$_GET["n1"].' ORDER BY flat';
$a = mysql_query ($query,$i); $cn=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $data1[$cn]=$data2[$cn]=0;
     $query = 'SELECT * FROM device WHERE type=2 AND flat='.$uy[1];
	//echo $query;
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e); $ust=$ui[21];
     if ($ui) 
	{
	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date>'.$st.' AND device='.$ui[1].' ORDER BY date LIMIT 1';
	 //echo $query;
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui)
	    {
	     $data01[$cn]=$ui[5];
	     $dat[$cn]=$uy[1];
	    }                                                
	 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date<'.$fn.' AND device='.$ui[1].' ORDER BY date DESC LIMIT 1';
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui)
	    {
	     $data02[$cn]=$ui[5];
	     $dat[$cn]=$uy[1];
	    }
	 $data0[$cn]=5.4;
	 //if ($uy[10]==0) $uy[10]=1;
	 if ($data02[$cn]<$data01[$cn]) $data01[$cn]=0;
	 if ($uy[10]>0) $data1[$cn]=($data02[$cn]-$data01[$cn])/$uy[10];
	 else $data1[$cn]=($data02[$cn]-$data01[$cn]);

	 if ($ust==1) { $data2[$cn]=$data0[$cn]; $data1[$cn]=0; }
	 //echo $uy[10].' '.$ust.' '.$data1[$cn].' '.$data02[$cn].' '.$data01[$cn].'<br>';

	 if ($uy[10]==0 && $ust==0 && $data1[$cn]>0) { $data4[$cn]=$data1[$cn]; $data1[$cn]=0; }
	 else $data4[$cn]=0;
	 if ($data1[$cn]>30) $data1[$cn]=0;
         //$data2[$cn]=$data12[$cn]-$data11[$cn];
	 $cn++;
	}
     $uy = mysql_fetch_row ($a);
    }

$graph = new Graph(1200,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$lineplot->SetFillColor("blue");
$lineplot2=new BarPlot($data2);
$lineplot2->SetFillColor("orange");
$lineplot3=new BarPlot($data4);
$lineplot3->SetFillColor("violet");

$l1plot=new LinePlot($data0);
$l1plot->SetColor("red");
$l1plot->SetWeight(2);

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();
$graph->Add($l1plot);

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
$title='Приведенное потребление потребление холодной воды, квартиры '.$_GET["n1"].' подъезда (м3/чел.)';
$graph->title->Set($title);

// Add the plot to the graph
$graph->img->SetMargin(30,10,5,23);
//----------- title --------------------
$gbplot = new AccBarPlot(array($lineplot,$lineplot2,$lineplot3));
//$gbplot->value->Show();
$graph->Add($gbplot);
//$graph->Add($lineplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>