<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_bar.php");
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

	 $nn='x'.$cn.'-1-1'; $data[$cn]+=$_GET[$nn]/100*12.41*$vh1;
	 $nn='x'.$cn.'-1-2'; $data[$cn]+=$_GET[$nn]/100*12.41*$vh1;
	 $nn='x'.$cn.'-2-1'; $data[$cn]+=$_GET[$nn]/100*12.41*$vh2;
	 $nn='x'.$cn.'-2-2'; $data[$cn]+=$_GET[$nn]/100*12.41*$vh2;
	 $nn='x'.$cn.'-2-3'; $data[$cn]+=$_GET[$nn]/100*12.41*$vh2;
	 $nn='x'.$cn.'-3-2'; $data[$cn]+=$_GET[$nn]/100*537*$vh3;
	 $nn='x'.$cn.'-4-2'; $data[$cn]+=$_GET[$nn]/100*1.14*$vh4;
	}
}

$graph = new Graph(400,250,"auto");	
$graph->img->SetMargin(50,15,5,30);

$graph->SetScale("textlin");
$graph->SetShadow();
$graph->title->SetFont(FF_ARIAL,FS_BOLD,9);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 

// Create the linear plot
$lineplot=new LinePlot($data);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->SetMarginColor('white');
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
//----------- legend -------------------
//$graph->xaxis->SetLabelAngle(45);
$lineplot->SetColor("blue");
$lineplot->SetWeight(2);

$graph->yaxis->SetWeight(1);
$graph->xaxis->SetTickLabels($dat);
$graph->title->Set("Возврат жителям (руб.)");
//--------------------------------------
// Display the graph
$graph->Stroke();
?>