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
$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"];
else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn=$today["mon"];
else $mn=$_GET["month"];
if ($mn>1) $mn--; else { $mn=12; $ye--; } 

if ($_GET["src"]==5 || $_GET["src"]==6) $query = 'SELECT * FROM device WHERE type=2 AND flat='.$_GET["flat"];
if ($_GET["src"]==2) $query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["flat"];
if ($_GET["src"]==13) $query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["flat"];

$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $cm=0;
if ($uy) $dev=$uy[1];
$query = 'SELECT SUM(square),SUM(rnum) FROM flats';
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];
$query = 'SELECT square,rnum FROM flats WHERE flat='.$_GET["flat"];
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); 
if ($uy) { $square=$uy[0]; $rnum=$uy[1]; }

$x=0;
$dy=31;
if (!checkdate ($mn,31,$ye)) { $dy=30; }
if (!checkdate ($mn,30,$ye)) { $dy=29; }
if (!checkdate ($mn,29,$ye)) { $dy=28; }

for ($tm=1; $tm<=$dy; $tm++)
    {
     $data0[$x]=0; $data1[$x]=0;     
	 $tn=$tm; $tb=$tm+1;
	 $date0=sprintf ("%d%02d%02d000000",$ye,$mn,$tn);
	 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $date2=sprintf ("%d%02d%02d000000",$ye,$mn,$tb);
	 $dat[$x]=$tm;

     if ($_GET["src"]==5 || $_GET["src"]==6 || $_GET["src"]==2)
	{
    	 if ($_GET["src"]==5) $query = 'SELECT * FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source='.$_GET["src"].' AND date='.$date0.' AND flat='.$_GET["flat"];
	 if ($_GET["src"]==6) $query = 'SELECT * FROM data WHERE type=2 AND (prm=11 OR prm=12) AND source='.$_GET["src"].' AND date='.$date0.' AND flat='.$_GET["flat"];	
	 if ($_GET["src"]==2) $query = 'SELECT * FROM data WHERE type=2 AND prm=2 AND date='.$date0.' AND flat='.$_GET["flat"];	
	 $e = mysql_query ($query,$i);
     	 if ($e) $ui = mysql_fetch_row ($e);
     	 if ($ui) $data0[$x]=$ui[3];
       	 //echo ' - '.$ui[3].'<br>';
	 if ($_GET["src"]==5 || $_GET["src"]==6)
	 if ($data0[$x]<0.1 || $data0[$x]>30 || $data0[$x-1]==$data0[$x]) { $data0[$x-1]=$data0[$x-1]/2; $data0[$x]=$data0[$x-1]; }
	 if ($_GET["src"]==2)
	 if (($data0[$x]<0.1 || $data0[$x]>50) || $data0[$x-1]==$data0[$x]) { $data0[$x-1]=$data0[$x-1]/2; $data0[$x]=$data0[$x-1]; }

    	 if ($_GET["src"]==5) $query = 'SELECT value FROM data WHERE type=2 AND prm=12 AND source='.$_GET["src"].' AND date='.$date0.' AND flat=0';
	 if ($_GET["src"]==6) $query = 'SELECT value FROM data WHERE type=2 AND prm=12 AND source='.$_GET["src"].' AND date='.$date0.' AND flat=0';
     	 //echo $query;
	 $e = mysql_query ($query,$i);
     	 if ($e) $ui = mysql_fetch_row ($e);
     	 if ($ui) $data1[$x]=$ui[0];
	 if ($data0[$x]<0.1) $data0[$x]+=($data1[$x])*$rnum/$kk1;
	 //echo $data1[$x].' '.$rnum.'<br>';
	}
     if ($_GET["src"]==13)
	{
	  $query = 'SELECT * FROM flats WHERE flat='.$_GET["flat"];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat[$cn]=$ui[1]; $square=$ui[8];
	  $query = 'SELECT value FROM data WHERE type=2 AND prm=13 AND source=0 AND flat='.$flat[$cn].' AND date='.$date0;
	  $e = mysql_query ($query,$i);
          if ($e) $ui = mysql_fetch_row ($e);
          if ($ui) $data01=$ui[0];
//echo $query.' '.$data01.'<br>';
          //$data0[$x]=$data01*($square/$kk)*1000;
	  $data0[$x]=$data01/4.168;
	  if ($data0[$x]<0 || $data0[$x]>200) $data0[$x]=$data0[$x-1];
	}
     $x++; 
    }
$x--;
//for ($tt=0;$tt<=$x;$tt++) print $dat[$tt].' '.$data0[$tt].'<br>';
$prm=$_GET["src"];
$graph = new Graph(600,130,"auto");
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

if ($prm==5) $graph->title->Set("Горячая вода (м3)");
if ($prm==6) $graph->title->Set("Холодная вода (м3)");
if ($prm==13) $graph->title->Set("Тепловая энергия (ККал)");
if ($prm==2) $graph->title->Set("Электрическая энергия (кВт/ч)");

// Add the plot to the graph
$graph->img->SetMargin(5,10,5,23);
//----------- title --------------------
$graph->Add($lineplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>