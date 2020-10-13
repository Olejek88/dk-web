<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

for ($cn=0;$cn<24;$cn++)
{
 $nn='x'.$cn.'n';
 if ($_GET[$nn]!='')
	{
	 $dat[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-vh1'; $vh1=$_GET[$nn];
	 $nn='x'.$cn.'-vh2'; $vh2=$_GET[$nn];
	 $nn='x'.$cn.'-vh3'; $vh3=$_GET[$nn];
	 $nn='x'.$cn.'-vh4'; $vh4=$_GET[$nn];

	 $nn='x'.$cn.'-1-1'; $data[0]+=$_GET[$nn]/100*12.41*$vh3;	
	 $nn='x'.$cn.'-1-2'; $data[1]+=$_GET[$nn]/100*12.41*$vh3;	
	 $nn='x'.$cn.'-2-1'; $data[2]+=$_GET[$nn]/100*12.41*$vh2;	
	 $nn='x'.$cn.'-2-2'; $data[3]+=$_GET[$nn]/100*12.41*$vh2;	
	 $nn='x'.$cn.'-2-3'; $data[4]+=$_GET[$nn]/100*12.41*$vh2;	
	 $nn='x'.$cn.'-3-2'; $data[5]+=$_GET[$nn]/100*537*$vh1;	 	
	 $nn='x'.$cn.'-4-2'; $data[6]+=$_GET[$nn]/100*1.14*$vh4;	
	}
}
if ($data[0]==0)
if ($data[1]==0)
if ($data[2]==0)
if ($data[3]==0)
if ($data[4]==0)
if ($data[5]==0)
if ($data[6]==0)
 { $data[0]=1; $data[2]=1; $data[3]=1; $data[4]=1; $data[5]=1; $data[6]=1; $data[1]=1;}
//echo $cn.' '.$data[0].' '.$data[1].' '.$data[2].' '.$data[3].' '.$data[4].' '.$data[5].' '.$data[6].'<br>';

// Create the Pie Graph 
$graph = new PieGraph(200,250,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(50);

$p1->SetSliceColors(array('blue','aqua','red','pink','indianred','yellowgreen','black'));

$name[0]='ХВС:давление';
$name[1]='ХВС:бесперебойность';
$name[2]='ГВС:давление';
$name[3]='ГВС:бесперебойность';
$name[4]='ГВС:температура';
$name[5]='Тепло:бесперебойность';
$name[6]='ЭЭ:бесперебойность';

$p1->SetCenter(0.5,0.65);
$p1->SetSize(92);
$p1->SetStartAngle(20); 
//$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
$graph->legend->SetAbsPos(10,10,'right','top');
$p1->SetLegends($name);

//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
$graph->Stroke();
?>