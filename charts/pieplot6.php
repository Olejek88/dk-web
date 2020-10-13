<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$arr = get_defined_vars();
$today=getdate ();
if ($today["mon"]>1) $today["mon"]=$today["mon"]-1;
else { $today["mon"]=12; $today["year"]=$today["year"]-1; }
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($_GET["id"]=='') $_GET["id"]=1;
$tim=$today["year"].$today["mon"].'01000000';

$st=$_GET["st"];
$fn=$_GET["fn"];

 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $data[0]=$data[1]=$data[2]=$data[3]=$data[4]=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $cold=number_format($ui[10]*130*(31)/31,2);
	  $nab=$ui[10];

	 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=2 AND date<'.$fn.' AND date>'.$st.' AND device='.$uy[1].' ORDER BY date LIMIT 1';
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui) $data01=$ui[5];

	 $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=2 AND date<'.$fn.' AND date>'.$st.' AND device='.$uy[1].' ORDER BY date DESC LIMIT 1';
         $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
         if ($ui) $data11=$ui[5];


	 $sum0=$data11-$data01;	 if ($sum0<0) $sum0=0; $ssum0+=$sum0;

	 while (1)
		{
		 if ($nab==0 && $sum0>1) { $data[3]++; break; }
		 if ($sum0>($cold+$cold)) { $data[1]++; break; }
		 if ($sum0>$cold) { $data[2]++; break; }
		 if ($nab>0 && $sum0<1) { $data[4]++; break; }
		 $data[0]++;
		 break;
		}	 
	 $uy = mysql_fetch_row ($a);
	}

// Create the Pie Graph 
$graph = new PieGraph(200,140,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,7);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(50);

$p1->SetSliceColors(array('green','#ee5544','#eeee33','#ee80ee','#775577'));
$p1->SetCenter(0.5,0.5);
$p1->SetSize(88);
$p1->SetStartAngle(20); 
//$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
$graph->Stroke();
?>