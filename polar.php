<?php
include "jpgraph/jpgraph.php";
include "jpgraph/jpgraph_polar.php";
include("config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$type=$_GET["type"];
if ($type=='') $type=0;

$strut[0] = array (39,40,41,42,1,2,3,4,5,6,7);
$strut[1] = array (8,9,10,32,33,34,35,36,37,38);
$strut[2] = array (29,30,31,11,12,13,14,15,16,17);
$strut[3] = array (18,19,20,21,22,23,24,25,26,27,28);

$ip[0][11] = array (0, 7,15,23,31,39,47,55,63);
$ip[0][12] = array (1, 8,16,24,32,40,48,56,64);
$ip[0][13] = array (0, 9,17,25,33,41,49,57,65);
$ip[0][14] = array (2,10,18,26,34,42,50,58,66);
$ip[1][10] = array (3,11,19,27,35,43,51,59,67);
$ip[1][11] = array (4,12,20,28,36,44,52,60,68);
$ip[1][12] = array (5,13,21,29,37,45,53,61,69);
$ip[1][13] = array (6,14,22,30,38,46,54,62,70);
$ip[2][10] = array (0, 78,86,94,102,110,118,126,134);
$ip[2][11] = array (71,79,87,95,103,111,119,127,135);
$ip[2][12] = array (72,80,88,96,104,112,120,128,136);
$ip[2][13] = array (73,81,89,97,105,113,121,129,137);
$ip[3][11] = array (74,82,90,98,106,114,122,130,138);
$ip[3][12] = array (75,83,91,99,107,115,123,131,139);
$ip[3][13] = array (76,84,92,100,108,116,124,132,140);
$ip[3][14] = array (77,85,93,101,109,117,125,133,141);

$napr[0] = array (275,255,217,200,145,120,105,65,50,30,15,315,170,90,80);
$napr[1] = array (120,90,60,330,300,280,245,225,205,190,140,355,270,255);
$napr[2] = array (275,255,215,145,120,105,65,50,30,15,315,170,90,80);
$napr[3] = array (120,90,60,20,330,300,280,245,225,205,190,140,355,270,255);

$data = array(0,1,10,2,30,25,40,60,50,110,60,160,70,210,75,230,80,260,85,270);

for ($r=0;$r<=10;$r++)
  {
   $query = 'SELECT * FROM dev_bit WHERE strut_number='.$strut[$type][$r];
   $a = mysql_query ($query,$i);
   $value=0; $cn=0;
   if ($a) $uy = mysql_fetch_row ($a);
   while ($uy)
	{
 	 $query = 'SELECT value FROM prdata WHERE type=0 AND prm=32 AND device='.$uy[1];
	 //echo $query;
	 $e = mysql_query ($query,$i);
	 if ($e) $ui = mysql_fetch_row ($e);
	 if ($ui)
		{
		 //echo $value.'<br>';
	         $value+=$ui[0]; $cn++;
	         //printf ("%.1f     ",$ui[0]);
		 $ui = mysql_fetch_row ($e);
		}
	 //else printf ("n/u&nbsp;&nbsp;",$ui[0]);
	 $uy = mysql_fetch_row ($a);         
	}
   //printf ("<br>\n");
   if ($cn) $data[$r*2+1]=100+($value/$cn);
   if ($data[$r*2+1]<0) $data[$r*2+1]=0;
   $data[$r*2]=$napr[$type][$r];
  }

if ($type==0 || $type==3) { $r=11; $en=14; }
if ($type==1 || $type==2) { $r=10; $en=13; }

for (;$r<=$en;$r++)
  {
   $value=0; $cn=0;   
   for ($lv=1;$lv<=9;$lv++)
      {
       $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$ip[$type][$r][$lv-1];
       $e = mysql_query ($query,$i);
       if ($e) $ui = mysql_fetch_row ($e);
       $query = 'SELECT value FROM prdata WHERE type=0 AND prm=32 AND device='.$ui[1];
       //echo $query;
       $e = mysql_query ($query,$i);
       if ($e) $ui = mysql_fetch_row ($e);
       if ($ui) { $value+=$ui[0]; $cn++; }
      }
   if ($cn) $data[$r*2+1]=100+($value/$cn);
   $data[$r*2]=$napr[$type][$r];
  }

//for ($r=0;$r<28;$r++) print $data[$r].'<br>';
for ($pr=0;$pr<=10;$pr++) 
for ($r=0;$r<$en;$r++) 
    {
     if ($data[$r*2] > $data[$r*2+2]) 
	{ $ang=$data[$r*2]; $val=$data[$r*2+1]; 
	  $data[$r*2]=$data[$r*2+2]; $data[$r*2+1]=$data[$r*2+3];
	  $data[$r*2+2]=$ang; $data[$r*2+3]=$val;}
    }
for ($r=0;$r<30;$r++) 
if ($data[$r])
{
if ($r%2==0) $data2[$r]=$data[$r];
else  $data2[$r]=$data[$r]+15;
 //print $data[$r].' '.$data2[$r].'<br>';
}

$graph = new PolarGraph(450,450);
$graph->SetScale('lin');

if ($type==0) $graph->title->Set('Ослабление сигнала 1подъезд лев');
if ($type==1) $graph->title->Set('Ослабление сигнала 1подъезд прв');
if ($type==2) $graph->title->Set('Ослабление сигнала 2подъезд лев');
if ($type==3) $graph->title->Set('Ослабление сигнала 2подъезд прв');
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor('navy');
if ($type==0 || $type==2) $graph->SetBackgroundImage("mnem/1/2mm.jpg",BGIMG_CENTER);
if ($type==1 || $type==3) $graph->SetBackgroundImage("mnem/1/3mm.jpg",BGIMG_CENTER);

// Hide last labels on the Radius axis
// They intersect with the box otherwise
$graph->axis->HideLastTickLabel();

$p = new PolarPlot($data);
$p2 = new PolarPlot($data2);
$p->SetFillColor('lightblue@0.5');
$p2->SetFillColor('lightred@0.5');

$graph->Add($p);
$graph->Add($p2);
$graph->Stroke();
?>                      