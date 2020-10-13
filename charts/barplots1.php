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

 $query = 'SELECT * FROM flats WHERE ent='.$_GET["ent"].' ORDER BY flat';
 $a = mysql_query ($query,$i); $count=1; $contdev=0;
 $uy = mysql_fetch_row ($a);
 while ($uy)
      {
       $name[$count]=$uy[5]; $nab[$count]=$uy[10]; $count++;
       $query = 'SELECT * FROM device WHERE type=2 AND flat='.$uy[1];
       $a2 = mysql_query ($query,$i); 
       if ($uy2 = mysql_fetch_row ($a2)) 
	      {
	       $dev2ip[$contdev]=$uy2[1];
	       $dev2ip_fl[$contdev]=$uy2[10];
	 	//echo $contdev.' '.$uy2[10].' '.$dev2ip[$uy2[10]].'<br>';
	       $contdev++;
	      }
       $uy = mysql_fetch_row ($a);
      }
 $contdev--;

 $today=getdate (); if ($today["mon"]>1) $today["mon"]--;
 $cn=1; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
 $today=getdate();  if ($today["mon"]>1) $today["mon"]--;
 while ($cn)
      {
        $summa=0; $sm=$sums=0; $month=$today["mon"]; 
	$st=sprintf ("%d%02d01000000",$today["year"],$today["mon"]);
	$fn=sprintf ("%d%02d01000000",$today["year"],$today["mon"]+1);

        if ($today[mon]>1) $today["mon"]--;
        else { $today[year]--; $today[mon]=12; }

 	$query = 'SELECT * FROM prdata WHERE type=2 AND (prm=6 OR prm=8) AND date<'.$st.' AND value>0 AND value<10000 ORDER BY date DESC LIMIT 20000';
	$e = mysql_query ($query,$i);
	if ($e) $ui = mysql_fetch_row ($e);
	while ($ui)
	      {
		if ($ui[2]==6)
			{
			 for ($ll=1;$ll<=$contdev;$ll++)
			 if ($n2ipg[$cn][$ll]<=0 && $dev2ip[$ll]==$ui[1]) { $n2ipg[$cn][$ll]=$ui[5]; break; }
			}
		else
			{
			 for ($ll=1;$ll<=$contdev;$ll++)
			 if ($n2iph[$cn][$ll]<=0 && $dev2ip[$ll]==$ui[1]) { $n2iph[$cn][$ll]=$ui[5]; break; }
			}
	        $ui = mysql_fetch_row ($e);
	      } 
	 $cn--;
	}

 $query = 'SELECT * FROM flats WHERE ent='.$_GET["ent"].' ORDER BY flat';
 $a = mysql_query ($query,$i); $cm=0;
 $uy = mysql_fetch_row ($a);
 while ($uy)
         {	  
	  $flat=$uy[1]; $dat[$cm]=$flat;
	  $ssum0=$ssum1=0;
	  $dev=1000;

	  for ($ll=1;$ll<=$contdev;$ll++)
	  if ($dev2ip_fl[$ll]==$flat) { $dev=$dev2ip[$ll]; break; }

	  for ($cn=1;$cn>0;$cn--)
		{
		 $sum0=$n2iph[$cn][$ll];
		  if ($sum0<0) $sum0=0; $ssum0+=$sum0;
		 $sum1=$n2ipg[$cn][$ll];
		  //echo $flat.' '.$k2iph[$cn][$ll].' / '.$n2iph[$cn][$ll].'<br>';
		  if ($sum1<0) $sum1=0; $ssum1+=$sum1;
		}
	  if ($_GET["source"]==6) $data[$cm]=$ssum0;
	  if ($_GET["source"]==8) $data[$cm]=$ssum1;
	  $uy = mysql_fetch_row ($a);  $cm++;
	}

$graph = new Graph(600,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
if ($_GET["source"]==6) $lineplot->SetFillColor("blue");
if ($_GET["source"]==8) $lineplot->SetFillColor("red");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
if ($_GET["source"]==6) $title='Потребление холодной воды, квартиры '.$_GET["ent"].' подъезда (м3)';
if ($_GET["source"]==8) $title='Потребление горячей воды, квартиры '.$_GET["ent"].' подъезда (м3)';
$graph->title->Set($title);

// Add the plot to the graph
$graph->img->SetMargin(30,10,5,23);
//----------- title --------------------
$graph->Add($lineplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
$graph->xaxis->SetTextTickInterval(2,0);
// Display the graph
$graph->Stroke();
?>