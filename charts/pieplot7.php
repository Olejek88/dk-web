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

 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=2  AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; 
 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); 
 while ($uy)
        {
	 $query = 'SELECT SUM(value) FROM prdata WHERE type=1 AND prm=13 AND device='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	 $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);
	 $irpdata[$uy[2]]=$ui[0]; $sums+=$irpdata[$uy[2]];
	 $uy = mysql_fetch_row ($a); 
	}

 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);  $data[0]=$data[1]=$data[0];
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold=number_format($ui[8]*0.0322*(31)/31,2);
	  $nab=$ui[10];
	  $cold0+=$cold;
	  $query = 'SELECT * FROM dev_bit WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); $data01=$data02=0;
	  while ($ut)
	         {
		  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
		  $data01+=$irpdata[$ui[2]]/(9*4190);
		//echo $query.' '.$irpdata[$ui[1]];	
		  $ut = mysql_fetch_row ($b); 
		 }
	  $data01+=(($sum-$sums/4190))*($square/$kk);
		//echo $data01.' '.$cold.'<br>';
	  $sum0=$data01;
	  $ssum0+=$data01;

	  while (1)
		{
		 if ($sum0>($cold+$cold)) { $data[1]++; break; }
		 if ($sum0>$cold) { $data[2]++; break; }
		 $data[0]++; break;
		}
	 $cm++;	 
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