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
if ($_GET["year"]=='') $ye=$today["year"];
else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn='0'.$today["mon"];
else $mn=$_GET["month"];
if ($today["mday"]<20) 
	{ 
	 if ($today["mon"]>1) 
		{
		 $today["mon"]--; 
		 $today["mday"]=31; 
		}
	 else 
		{
		 $today["mon"]=12; 
		 $today["year"]--; 
		 $today["mday"]=31; 
		}
	}

$query = 'SELECT SUM(rnum),SUM(square) FROM flats';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);  $sum=$uy[0]; $sum0=$uy[1];

$cn=8; $count=8;
$tm=$today["mon"];

while ($cn>=0)
    {	 
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }

     $sts=sprintf("%d%02d01000000",$today["year"],$tm); 
     $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);

     if ($_GET["n1"]=='6') 
	{

	 //if ($tm!=$today["mon"]) $query = 'SELECT SUM(value) FROM data WHERE date='.$sts.' AND type=4 AND flat=0 AND prm=12 AND source=5';
	 //else  
	 $query = 'SELECT SUM(value) FROM data WHERE  date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=5';   

	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e); 
	 if ($ui) $data1[$cn]=$ui[0]; else $data1[$cn]=0;

	    if ($today["mon"]!=$tm) $data0[$cn]=3.6*$sum*($tod/31);
	    else $data0[$cn]=3.6*$sum*($today["mday"]/31);
	    $data2[$cn]=0;
	    
         $query = 'SELECT SUM(value) FROM data WHERE flat>0 AND (prm=11 OR prm=12) AND source=6 AND date>'.$sts.' AND date<'.$fns.' AND value<50';
         $e = mysql_query ($query,$i);
	 if ($e) 
		{
		 $ui = mysql_fetch_row ($e);
	         if ($ui) $data2[$cn]=$ui[0]; 
		 else $data2[$cn]=0;
		 if ($data2[$cn]=='') $data2[$cn]=$data1[$cn];
		}
	 if ($data1[$cn]>=$data2[$cn]) $data1[$cn]=$data1[$cn]-$data2[$cn]; 
	 if (!$is_tekon) { $data1[$cn]=0.1; }
	 if ($data2[$cn]=='') $data1[$cn]=$data2[$cn]=0;
	 //echo $data1[$cn].' /  '.$data0[$cn].' / '.$data2[$cn].'<br>';
	}
     if ($_GET["n1"]=='8') 
	{
	    if ($tm!=$today["mon"]) $query = 'SELECT SUM(value) FROM data WHERE date='.$sts.' AND type=4 AND flat=0 AND prm=12 AND source=6';   
	    else  $query = 'SELECT SUM(value) FROM data WHERE  date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=6';   
  	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0];
	 if ($tm!=$today["mon"]) $query = 'SELECT SUM(value) FROM data WHERE date='.$sts.' AND type=4 AND flat=0 AND prm=12 AND source=5';
	 else  $query = 'SELECT SUM(value) FROM data WHERE  date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=12 AND source=5';   
  	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e); $data1[$cn]-=$ui[0];

	 if ($today["mon"]!=$tm) $data0[$cn]=5.4*$sum*($tod/31);
	 else $data0[$cn]=5.4*$sum*($today["mday"]/31);
	 $data2[$cn]=0;

	 $query = 'SELECT SUM(value) FROM data WHERE flat>0 AND (prm=11 OR prm=12) AND source=5 AND date>'.$sts.' AND date<'.$fns.' AND value<50';
	 $e = mysql_query ($query,$i);
	 if ($e) $ui = mysql_fetch_row ($e);
	 if ($ui) $data2[$cn]=$ui[0];
	 //echo $data1[$cn].' /  '.$data0[$cn].' / '.$data2[$cn].'<br>';
	 if ($data1[$cn]>=$data2[$cn]) $data1[$cn]=$data1[$cn]-$data2[$cn];
	 if (!$is_tekon) { $data1[$cn]=0.1; }
	 if ($data2[$cn]=='') $data1[$cn]=$data2[$cn]=0;
	 //$data1[$cn]=$data2[$cn]; 
	 //echo $data1[$cn].' /  '.$data0[$cn].' / '.$data2[$cn].'<br>';
	}
     if ($_GET["n1"]=='13') 
	{
	 $query = 'SELECT COUNT(id) FROM device WHERE type=5';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); 
	 if ($tm==$today["mon"]) $numm=($today["mday"]-1)*$uy[0];
	 else $numm=31*$uy[0];


	 if ($is_tekon || $_GET["obj"]==7)
		{
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=13 AND source=2 AND value>0.1';
		 //echo $query.'<br>';
		 $e = mysql_query ($query,$i);
		 $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0]; $ssum=$ui[1];
		 if ($data1[$cn]==0)
		    {
		     $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=4 AND flat=0 AND prm=13 AND source=0 AND value>0.1';
		     $e = mysql_query ($query,$i);
    		     $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0]; $ssum=$ui[1];    		     
		    }
		}
	 else	{
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat>0 AND prm=13 AND value>0.1';
		 //echo $query.'<br>';
		 $e = mysql_query ($query,$i);
		 $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0]/4184; $ssum=$ui[1];
		}

	    if ($cn==0) 
		{
		    $query = 'SELECT AVG(value) FROM data WHERE date>'.$today["year"].$tm.'00000000 AND date<'.$today["year"].$tn.'00000000 AND type=2 AND flat=0 AND prm=13 AND source=2';
		//echo $query;		   
		    $e = mysql_query ($query,$i);
		    $ui = mysql_fetch_row ($e); $data1[$cn]+=$ui[0]*7;
		}
	    $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>'.$sts.' AND date<'.$fns.' AND type=2 AND prm=13 AND value>0';
		//echo $query.'<br>';
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); 
	    $cntid=$ui[1];
//		echo $numm.' '.$ui[0].' '.$ui[1].' '.$ui[2].'<br>';

	    $data2[$cn]=($ui[0]/4184); 
	    if ($data1[$cn]-$data2[$cn]>0) $data1[$cn]=$data1[$cn]-$data2[$cn]; else $data1[$cn]=0;

	 if ($ssum>27) $data0[$cn]=0.0322*$sum0;
	 else $data0[$cn]=($ssum/31)*0.0322*$sum0;
	 //echo $data1[$cn].' /  '.$data0[$cn].' / '.$data2[$cn].'<br>';
	}
     if ($tm==1) $dat[$cn]='Январь '.$today["year"];
     if ($tm==2) $dat[$cn]='Февраль '.$today["year"];
     if ($tm==3) $dat[$cn]='Март '.$today["year"];
     if ($tm==4) $dat[$cn]='Апрель '.$today["year"];
     if ($tm==5) $dat[$cn]='Май '.$today["year"];
     if ($tm==6) $dat[$cn]='Июнь '.$today["year"];
     if ($tm==7) $dat[$cn]='Июль '.$today["year"];
     if ($tm==8) $dat[$cn]='Август '.$today["year"];
     if ($tm==9) $dat[$cn]='Сентябрь '.$today["year"];
     if ($tm==10) $dat[$cn]='Октябрь '.$today["year"];
     if ($tm==11) $dat[$cn]='Ноябрь '.$today["year"];
     if ($tm==12) $dat[$cn]='Декабрь '.$today["year"];
     $cn--;
     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $uy = mysql_fetch_row ($a);
    }

$graph = new Graph(800,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$lineplot->SetFillColor("orange");
$lineplot2=new BarPlot($data0);
$lineplot2->SetFillColor("blue");
$lineplot3=new BarPlot($data2);
$lineplot3->SetFillColor("red");

$lineplot->value->SetFormat('%d');
$lineplot2->value->SetFormat('%d');
$lineplot3->value->SetFormat('%d');

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
if ($_GET["n1"]==2) $graph->title->Set("Потребление электроэнергии (кВт)");
if ($_GET["n1"]==8) $graph->title->Set("Потребление холодной воды без учета норматива(м3)");
if ($_GET["n1"]==6) $graph->title->Set("Потребление горячей воды без учета норматива(м3)");
if ($_GET["n1"]==13) $graph->title->Set("Потребление тепловой энергии (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(30,8,33,25);
//----------- title --------------------
$lineplot3->value->Show();
$lineplot2->value->Show();

$name3='Индивидуальное потребление     ';
$name='Общедомовые потери     ';
$name2='Нормативное потребление     ';

$graph ->legend->Pos( 0.03,0.01,"right" ,"top");
$lineplot->SetLegend($name);
$lineplot3->SetLegend($name3);
$lineplot2->SetLegend($name2);

$acbplot = new AccBarPlot(array($lineplot3,$lineplot));
$acbplot->value->Show();
$gbplot  = new GroupBarPlot (array($acbplot ,$lineplot2)); 
$graph->Add($gbplot);
$gbplot->SetWidth(0.7);
//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>