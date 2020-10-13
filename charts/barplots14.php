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
//if ($today["mday"]<20) { $today["mon"]--; $today["mday"]=31; }
$query = 'SELECT SUM(rnum),SUM(square) FROM flats';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);  $sum=$uy[0]; $sum0=$uy[1];

$query = 'SELECT * FROM device WHERE type=2 AND ust=1';
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e); $sum2=0;
while ($ui) 
	{
	 $query = 'SELECT SUM(rnum) FROM flats WHERE flat='.$ui[10];
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);  
	 $sum2+=$uy[0];	   
	 $ui = mysql_fetch_row ($e); 
	}

$cn=0;
if ($_GET["size"]=='') { if ($_GET["n1"]==8) $start=4; else $start=2;}
else if ($_GET["n1"]==8) $start=4; else $start=2;

$tm=$today["mon"];
//for ($tm=$start; $tm<=$today["mon"]; $tm++)
while ($cn<8)
    {	 
     $data0[$cn]=$data1[$cn]=$data2[$cn]=0;
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }

     $st=sprintf ("%d%02d01000000",$today["year"],$tm);
     $fn=sprintf ("%d%02d00000000",$today["year"],$tm+1);
     $stl=sprintf ("%d-%02d",$today["year"],$tm);
     if ($_GET["n1"]=='2') 
	{
	 $data1[$cn]=0;
	 
	 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
	 $e = mysql_query ($query,$i);
	 if ($e) $ui = mysql_fetch_row ($e); $cm=0;
	 while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

	    $query = 'SELECT SUM(value) FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND flat=0 AND prm=14 AND value<2000';
	    $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); if ($ui) $data1[$cn]=$ui[0];
	    $query = 'SELECT * FROM prdata WHERE type=2 AND prm=2 AND date>='.$st.' AND date<'.$fn.' ORDER BY date';
	    //echo $query;
	    $e = mysql_query ($query,$i);
	    if ($e) $ui = mysql_fetch_row ($e);
	    while ($ui)
		{ 
		 for ($b=0;$b<$cm;$b++) 
		 if ($dev[$b]==$ui[1] && $datas[$b]<0) $datas[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
 	     $query = 'SELECT * FROM prdata WHERE type=2 AND date>'.$st.' AND prm=2 AND date<'.$fn.' ORDER BY date DESC';
	     //echo $query;
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e);
	     while ($ui)
		{ 
		 for ($b=0;$b<$cm;$b++)
		 if ($dev[$b]==$ui[1] && $datad[$b]<0) $datad[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
	     for ($b=0;$b<$cm;$b++) if ($datas[$b]>0) 
				    if ($datad[$b]>$datas[$b]) $data01[$cn]+=$datas[$b];
	     for ($b=0;$b<$cm;$b++) if ($datad[$b]>0) $data02[$cn]+=$datad[$b];

	     if ($data02[$cn]-$data01[$cn]>0) $data2[$cn]=$data02[$cn]-$data01[$cn];
	     else $data2[$cn]=0;
	     
	     if ($data1[$cn]>$data2[$cn]) $data1[$cn]=$data1[$cn]-$data2[$cn]; 
	     else { if ($data1[$cn]>100) $data2[$cn]=$data1[$cn]; else $data1[$cn]=0;}

	 //$data2[$cn]+=$sum2*(130/30)*$tod;
	 if ($data2[$cn]=='') $data2[$cn]=0;
	 if ($cn!=0) $data0[$cn]=$sum*(130/30)*$tod;	 
	 else $data0[$cn]=$sum*(130/30)*$today["mday"];	 
	 //echo $data0[$cn].' ='.$data1[$cn].' ='.$data2[$cn].'<br>';
	}
     if ($_GET["n1"]=='6') 
	{
	    if ($tm==$today["mon"])
	    	 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date LIKE \'%'.$stl.'%\' AND type=2 AND flat=0 AND prm=12 AND source=5';
	    else
		 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date='.$st.' AND type=4 AND flat=0 AND prm=12 AND source=5';
	    //echo $query;
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); 
	    $data1[$cn]=$ui[0]*1;
	    //$data0[$cn]=3.6*$ui[1]*$sum;
	    //echo $tod;
	    $data0[$cn]=$sum*(3.6/30)*$ui[1];
	    //else $data0[$cn]=3.6*$sum*($today["mday"]/30);

	    $data2[$cn]=0;
 
	     $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e); $cm=0;
	     while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

	     $query = 'SELECT * FROM prdata WHERE type=2 AND prm=6 AND date<'.$st.' ORDER BY date DESC';
	     //echo $query.'<br>';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e);
	     while ($ui)
		{ 
		 for ($b=0;$b<$cm;$b++) 
		 if ($dev[$b]==$ui[1] && $datas[$b]<0) $datas[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
	     //for ($b=0;$b<$cm;$b++) if ($datas[$b]>0) $data01[$cn]+=$datas[$b];

	     $query = 'SELECT * FROM prdata WHERE type=2 AND date<'.$fn.' AND date>='.$st.' AND prm=6 ORDER BY date DESC';
	     //echo $query.'<br>';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e);
	     while ($ui)
		{ 
		 for ($b=0;$b<$cm;$b++)
		 if ($dev[$b]==$ui[1] && $datad[$b]<0) $datad[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
	     for ($b=0;$b<$cm;$b++) if ($datad[$b]-$datas[$b]>0) $data2[$cn]+=$datad[$b]-$datas[$b];
	     if ($_GET["size"]=='') $data2[$cn]+=$sum2*(3.6/30)*$tod;	     
	     //if ($tm==$today["mon"]) for ($b=0;$b<$cm;$b++) { $rff=$datad[$b]-$datas[$b]; echo '['.$b.']'.$datad[$b].'-'.$datas[$b].' '.$rff.'<br>'; if ($rff>0) $ff+=$rff; }
	     //echo $data02[$cn].' '.$data01[$cn].'<br>';
		
	 if ($data1[$cn]>$data2[$cn]) $data1[$cn]=$data1[$cn]-$data2[$cn]; 
	 else { $data2[$cn]=$data1[$cn]; $data1[$cn]=0; }
	}
     if ($_GET["n1"]=='8') 
	{
	    if ($tm==$today["mon"]) $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date LIKE \'%'.$stl.'%\' AND type=2 AND flat=0 AND prm=12 AND source=6';
	    else $query = 'SELECT SUM(value) FROM data WHERE date='.$st.' AND type=4 AND flat=0 AND prm=12 AND source=6';   
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0];
	    if ($tm==$today["mon"]) $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date LIKE \'%'.$stl.'%\' AND type=2 AND flat=0 AND prm=12 AND source=5';
	    else $query = 'SELECT SUM(value) FROM data WHERE date='.$st.' AND type=4 AND flat=0 AND prm=12 AND source=5';
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); $data0[$cn]=$ui[0];
	    $data1[$cn]=$data1[$cn]-$data0[$cn];

	    if ($today["mon"]!=$tm) $data0[$cn]=(5.4/30)*$tod*$sum;
	    else $data0[$cn]=5.4*$sum*($today["mday"]/30);

	    $data2[$cn]=0;

	     $query = 'SELECT * FROM device WHERE type=2';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e); $cm=0;
	     while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

	     $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date<'.$st.' ORDER BY date DESC';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e);
	     while ($ui)
		{ 
		 for ($b=0;$b<$cm;$b++) 
		 if ($dev[$b]==$ui[1] && $datas[$b]<0) $datas[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
	     for ($b=0;$b<$cm;$b++) if ($datas[$b]>=0) $data01[$cn]+=$datas[$b];

	     $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date<'.$fn.' AND date>='.$st.' ORDER BY date DESC';
	     $e = mysql_query ($query,$i);
	     if ($e) $ui = mysql_fetch_row ($e);
	     while ($ui)
		{ 
		 if ($ui[5]>0) 
		 for ($b=0;$b<$cm;$b++)
		 if ($dev[$b]==$ui[1] && $datad[$b]<0) $datad[$b]=$ui[5];
		 $ui = mysql_fetch_row ($e);
		}
	     for ($b=0;$b<$cm;$b++) if ($datad[$b]>=0) $data02[$cn]+=$datad[$b];
//	     echo $data1[$cn].' '.$data02[$cn].' '.$data01[$cn].'<br>';

	     if ($data02[$cn]-$data01[$cn]>0) $data2[$cn]=$data02[$cn]-$data01[$cn];  	     
	     if ($_GET["size"]=='') $data2[$cn]+=$sum2*(5.4/30)*$tod;

	 if ($data1[$cn]-$data2[$cn]>=0) $data1[$cn]=$data1[$cn]-$data2[$cn]; 
	 else { $data2[$cn]=$data1[$cn]; $data1[$cn]=0; }
	}
     if ($_GET["n1"]=='13') 
	{
	 $query = 'SELECT COUNT(id) FROM device WHERE type=5';
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a); 
	 if ($cn==0) $numm=($today["mday"]-1)*$uy[0];
	 else $numm=31*$uy[0];

            $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND flat=0 AND prm=13 AND source=2 AND value>0.1';
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); 
	    if ($ui[0]) { $data1[$cn]=$ui[0]; $cntid=$ui[1]; } else { $data1[$cn]=0; $cntid=0; }

	    if ($cn==0) 
		{
		 $query = 'SELECT AVG(value) FROM data WHERE date>'.$st.' AND date<'.$fn.' AND type=2 AND flat=0 AND prm=13 AND source=2';
		 $e = mysql_query ($query,$i);
		 //$ui = mysql_fetch_row ($e); $data1[$cn]+=$ui[0]*7;
		}
	    if ($_GET["obj"]==1) $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND (prm=13 OR prm=11) AND value>5';
	    if ($_GET["obj"]==2) $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND prm=13 AND value>5';
	    $e = mysql_query ($query,$i);
	    $ui = mysql_fetch_row ($e); 
		
	    $ui[0]=$ui[0]+($numm-$ui[1])*$ui[2];
	    if ($ui[0]) $data2[$cn]=($ui[0]/4184); 
		else $data2[$cn]=0;
	
	   if ($data1[$cn]-$data2[$cn]>0) $data1[$cn]=$data1[$cn]-$data2[$cn]; else { $data2[$cn]=$data1[$cn]; $data1[$cn]=0; }
	   if ($cntid>28) $data0[$cn]=0.0322*$sum0;
	   else $data0[$cn]=($cntid/31)*0.0322*$sum0;
	}

     if ($_GET["n1"]=='15') 
	{
         $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>'.$st.' AND date<'.$fn.' AND type=2 AND flat=0 AND prm=12 AND source=5 AND value<200 AND value>10';
         $e = mysql_query ($query,$i);
         $ui = mysql_fetch_row ($e); 
     	 $datas0[$cn]=(3.6/30)*$ui[1]*$sum;
     	 
     	 $query = 'SELECT SUM(value) FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND prm=13 AND source=3 AND flat=0';
     	 $a = mysql_query ($query,$i);
     	 if ($a) $uy = mysql_fetch_row ($a);
     	 if ($uy) $datas2[$cn]=$uy[0];
     	 $query = 'SELECT SUM(value) FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND prm=13 AND source=2 AND flat=0';
     	 $a = mysql_query ($query,$i);
     	 if ($a) $uy = mysql_fetch_row ($a);
     	 if ($uy) $datas3[$cn]=$uy[0];
     	 $query = 'SELECT SUM(value) FROM data WHERE date>='.$st.' AND date<'.$fn.' AND type=2 AND prm=12 AND source=5 AND flat=0';
     	 $a = mysql_query ($query,$i);
     	 if ($a) $uy = mysql_fetch_row ($a);
     	 if ($uy) $datas4[$cn]=$uy[0];

	 $data2[$cn]=$datas2[$cn]-$datas3[$cn];
	 if ($data2[$cn]<0) $data2[$cn]=0;
	 $data1[$cn]=0.0467*$datas4[$cn];
	 $data0[$cn]=0.0467*$datas0[$cn];
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

//     if ($data2[$cn]>0.1)      
     if ($data2[$cn]>0.1) { $ddata0[$cn]=$data0[$cn]; $ddata1[$cn]=$data1[$cn]; $ddata2[$cn]=$data2[$cn]; $ddat[$cn]=$dat[$cn]; $cn++; }
     if ($tm>0) { $today["mon"]--; $tm--; } else { $today["mon"]=12; $tm=12; $today["year"]--;}
     if ($today["year"]==2008) break;
     $uy = mysql_fetch_row ($a);
    }

for ($rr=0; $rr<$cn; $rr++) 
	{ 
	 $data2[$cn-$rr-1]=$ddata2[$rr]; 
	 $data0[$cn-$rr-1]=$ddata0[$rr]; 
	 $data1[$cn-$rr-1]=$ddata1[$rr]; 
	 $dat[$cn-$rr-1]=$ddat[$rr]; 
//	echo $cn-$rr.' 2='.$data2[$cn-$rr-1].' 0='.$data0[$cn-$rr-1].' 1='.$data1[$cn-$rr-1].'<br>';
}

if ($_GET["size"]=='') $graph = new Graph(700,250,"auto");
else $graph = new Graph(600,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data2);
$lineplot->SetFillColor("red");
$lineplot2=new BarPlot($data0);
$lineplot2->SetFillColor("blue");
$lineplot3=new BarPlot($data1);
$lineplot3->SetFillColor("orange");

$lineplot->SetWidth(0.8);
$lineplot2->SetWidth(0.8);
$lineplot3->SetWidth(0.8);

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
if ($_GET["n1"]==2) $graph->title->Set("Потребление электроэнергии (кВт)");
if ($_GET["n1"]==8) $graph->title->Set("Потребление холодной воды (м3)");
if ($_GET["n1"]==6) $graph->title->Set("Потребление горячей воды (м3)");
if ($_GET["n1"]==13) $graph->title->Set("Потребление тепловой энергии (ГКал)");

// Add the plot to the graph
$graph->img->SetMargin(38,8,33,25);
//----------- title --------------------
if ($_GET["n1"]=='13') 
{
//$lineplot3->value->Show();
$lineplot2->value->Show();
$lineplot->value->Show();

$name='Индивидуальное потребление     ';
$name3='Общедомовые потери     ';
$name2='Нормативное потребление     ';

$graph ->legend->Pos( 0.03,0.01,"right" ,"top");
$lineplot->SetLegend($name);
$lineplot3->SetLegend($name3);
$lineplot2->SetLegend($name2);

$acbplot = new AccBarPlot(array($lineplot,$lineplot3));
$acbplot->value->Show();
$gbplot  = new GroupBarPlot (array($acbplot ,$lineplot2)); 
$graph->Add($gbplot);
//$acbplot->value->Show();
//$gbplot->value->Show();
$gbplot->SetWidth(0.7);
}
else
{
 if ($_GET["n1"]!='15')
    {
     $lineplot->value->Show();
     $lineplot->value->SetFormat('%d');
     $lineplot2->value->Show();
     $lineplot2->value->SetFormat('%d');
     $acbplot = new AccBarPlot(array($lineplot,$lineplot3));
     $acbplot->value->Show();
     $acbplot->value->SetFormat('%d');
     $gbplot  = new GroupBarPlot (array($acbplot ,$lineplot2)); 
     $graph->Add($gbplot);
     $gbplot->SetWidth(0.8);
    }
 else
    {
     $name='Фактический объем потребления     ';
     $name2='Норматив на нормативный объем     ';
     $name3='Норматив на фактический объем    ';

     $graph ->legend->Pos( 0.03,0.01,"right" ,"top");
     $lineplot->SetLegend($name);
     $lineplot3->SetLegend($name3);
     $lineplot2->SetLegend($name2);

     $lineplot->value->Show();     $lineplot->value->SetFormat('%d');
     $lineplot2->value->Show();    $lineplot2->value->SetFormat('%d');
     $lineplot3->value->Show();    $lineplot3->value->SetFormat('%d');
     $gbplot  = new GroupBarPlot (array($lineplot, $lineplot2, $lineplot3)); 
     $graph->Add($gbplot);
     $gbplot->SetWidth(0.8);
    }
}
//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>