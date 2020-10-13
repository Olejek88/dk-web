<?php
include "../jpgraph/jpgraph.php";
include "../jpgraph/jpgraph_polar.php";
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$type=$_GET["type"];
if ($type=='') $type=0;
$strut[0] = array (39,40,41,42,1,2,3,4,5,6,7);
$strut[1] = array (8,9,10,32,33,34,35,36,37,38);
$strut[2] = array (29,30,31,11,12,13,14,15,16,17);
$strut[3] = array (18,19,20,21,22,23,24,25,26,27,28);

$strut[10] = array (72,73,74,75,76,1,2,3,4,0,0);
$strut[11] = array (5,6,7,8,9,67,68,69,70,71,0);
$strut[12] = array (62,63,64,65,66,10,11,12,13,0,0);
$strut[13] = array (14,15,16,17,18,57,58,59,60,61,0);
$strut[14] = array (52,53,54,55,56,19,20,21,22,0,0);
$strut[15] = array (23,24,25,26,27,47,48,49,50,51,0);
$strut[16] = array (42,43,44,45,46,28,29,30,31,32,0);
$strut[17] = array (33,34,35,36,37,38,39,40,41,0,0);

$strut[61] = array (71,32,33,70,78,36,77,37,38,76,39,24,75,25,26,80,79,22,74,73,72);
$strut[62] = array (71,61,63,88,64,92,66,67,68,91,69,24,75,25,26,80,79,22,74,73,72);
$strut[63] = array (71,32,33,70,36,37,77,37,38,76,39,54,87,55,86,56,85,22,74,73,72);
$strut[64] = array (71,32,33,70,78,36,77,37,38,76,39,24,75,25,26,80,79,22,74,73,72);
$strut[65] = array (71,32,33,70,78,36,77,37,38,76,39,24,75,25,26,80,79,22,74,73,72);
$strut[66] = array (71,32,33,70,78,36,77,37,38,76,39,24,75,25,26,80,79,22,74,73,72);

$napr[61] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);
$napr[62] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);
$napr[63] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);
$napr[64] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);
$napr[65] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);
$napr[66] = array (10,30,50,65,80,100,120,140,160,175,190,205,220,235,250,265,280,295,310,325,345);

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

$ip[10][9]  = array (1, 5,11,17,23,29,35,41,47);
$ip[10][10] = array (1, 6,12,18,24,30,36,42,48);
$ip[10][11] = array (2, 7,13,19,25,31,37,43,49);
$ip[11][10] = array (3, 8,14,20,26,32,38,44,50);
$ip[11][11] = array (4, 9,15,21,27,33,39,45,51);
$ip[11][12] = array (4,10,16,22,28,34,40,46,52);

$ip[12][9]  = array (53, 56,62,68,74,80,86,92,98);
$ip[12][10] = array (53, 57,63,69,75,81,87,93,99);
$ip[12][11] = array (54, 58,64,70,76,82,88,94,100);
$ip[13][10] = array (55, 59,65,71,77,83,89,95,101);
$ip[13][11] = array (208,60,66,72,78,84,90,96,102);
$ip[13][12] = array (208,61,67,73,79,85,91,97,103);

$ip[14][9]  = array (104,108,114,120,126,132,138,144,150);
$ip[14][10] = array (104,109,115,121,127,133,139,145,151);
$ip[14][11] = array (105,110,116,122,128,134,140,146,152);
$ip[15][10] = array (106,111,117,123,129,135,141,147,153);
$ip[15][11] = array (107,112,118,124,130,136,142,148,154);
$ip[15][12] = array (107,113,119,125,131,137,143,149,155);

$ip[16][10] = array (156,160,166,172,178,184,190,196,202);
$ip[16][11] = array (156,161,167,173,179,185,191,197,203);
$ip[16][12] = array (157,162,168,174,180,186,192,198,204);
$ip[17][9]  = array (158,163,169,175,181,187,193,199,205);
$ip[17][10] = array (159,164,170,176,182,188,194,200,206);
$ip[17][11] = array (159,165,171,177,183,189,195,201,207);

$napr[0] = array (275,255,217,200,145,120,105,65,50,30,15,315,170,90,80);
$napr[1] = array (120,90,60,330,300,280,245,225,205,190,140,355,270,255);
$napr[2] = array (275,255,215,145,120,105,65,50,30,15,315,170,90,80);
$napr[3] = array (120,105,80,55,330,290,280,255,240,205,190,140,355,270,255);

$napr[10] = array (290,270,255,215,135,105,75,60,50,315,240,30);
$napr[11] = array (130,115,100,75,45,320,295,280,260,240,155,315,220);
$napr[12] = array (305,290,285,270,240,130,90,75,55,330,275,30);
$napr[13] = array (130,120,100,75,45,315,300,285,270,240,160,330,220);
$napr[14] = array (135,120,100,75,45,310,295,280,260,240,155,315,220);
$napr[15] = array (130,120,100,75,45,315,300,285,270,240,160,330,220);
$napr[16] = array (135,120,100,75,45,310,295,280,260,240,155,315,220);
$napr[17] = array (135,120,100,75,45,310,295,280,260,240,155,315,220);

$data = array(0,1,10,2,30,25,40,60,50,110,60,160,70,210,75,230,80,260,85,270);

for ($r=0;$r<count ($strut[$type]);$r++)
  {
   $query = 'SELECT * FROM dev_bit WHERE strut_number='.$strut[$type][$r];
   if ($_GET["obj"]==6) $query = 'SELECT * FROM dev_bit WHERE imitate_tem='.($_GET["type"]-60).' AND strut_number='.$strut[$type][$r];
   //echo $query;
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
   if ($r>0 && $value==0) $value=$prvalue;
   if ($cn) $data[$r*2+1]=100+($value/$cn); else if ($ccn>0) $data[$r*2+1]=100+($prvalue/$ccn); else $data[$r*2+1]=30;
   if ($data[$r*2+1]<0) $data[$r*2+1]=0;
   $data[$r*2]=$napr[$type][$r];
   if ($value) $prvalue=$value; else $prvalue=-70;
   if ($cn) $ccn=$cn; else if ($r==0) $ccn=1;
   if ($data[$r*2+1]==0 || $data[$r*2+1]>50) $data[$r*2+1]=30;
   //echo '['.$r.'] '.$cn.' ; '.$data[$r*2].' '.$data[$r*2+1].'<br>';
  }

if ($type==0 || $type==3) { $r=11; $en=14; }
if ($type==1 || $type==2) { $r=10; $en=13; }
if ($type==10 || $type==12 || $type==14 || $type==17) { $r=9; $en=11; }
if ($type==11 || $type==13 || $type==15 || $type==16) { $r=10; $en=12; }


if ($_GET["obj"]!=6)
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

for ($r=0;$r<count ($strut[$type])*2;$r++) 
if ($data[$r])
{
if ($r%2==0) $data2[$r]=$data[$r];
else  $data2[$r]=$data[$r]+5;

//print $data[$r].' '.$data2[$r].'<br>';
}

if ($type>=61) $graph = new PolarGraph(450,320);
else $graph = new PolarGraph(450,450);

$graph->SetScale('lin');

if ($type==0) $graph->title->Set('Ослабление сигнала 1подъезд лев');
if ($type==1) $graph->title->Set('Ослабление сигнала 1подъезд прв');
if ($type==2) $graph->title->Set('Ослабление сигнала 2подъезд лев');
if ($type==3) $graph->title->Set('Ослабление сигнала 2подъезд прв');
if ($type==4) $graph->title->Set('Ослабление сигнала 3подъезд лев');
if ($type==5) $graph->title->Set('Ослабление сигнала 3подъезд прв');
if ($type==6) $graph->title->Set('Ослабление сигнала 4подъезд лев');
if ($type==7) $graph->title->Set('Ослабление сигнала 4подъезд прв');

if ($type==61) $graph->title->Set('Ослабление сигнала 1секция');
if ($type==62) $graph->title->Set('Ослабление сигнала 2секция');
if ($type==63) $graph->title->Set('Ослабление сигнала 3секция');
if ($type==64) $graph->title->Set('Ослабление сигнала 4секция');
if ($type==65) $graph->title->Set('Ослабление сигнала 5секция');
if ($type==66) $graph->title->Set('Ослабление сигнала 6секция');

$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor('navy');

if ($type==0 || $type==2 || $type==10 || $type==12) $img='../mnem/'.$_GET["obj"].'/2mm.jpg';
if ($type==1 || $type==3 || $type==11 || $type==15) $img='../mnem/'.$_GET["obj"].'/3mm.jpg';
if ($type==4 || $type==16 || $type==14) $img='../mnem/'.$_GET["obj"].'/4mm.jpg';
if ($type==5 || $type==13 || $type==17) $img='../mnem/'.$_GET["obj"].'/5mm.jpg';
if ($type==12) $img='../mnem/'.$_GET["obj"].'/6mm.jpg';

if ($type>=61) $img='../mnem/6.jpg';

//echo $img;
$graph->SetBackgroundImage($img,BGIMG_CENTER);

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