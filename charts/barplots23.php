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
//http://rpk-su.info/charts/barplots23.php?x0name=%D4%E5%E2%F0%E0%EB%FC&x0-1-1=0&x0-1-2=0&x0-1-3=0&x0-2-1=0&x0-2-2=2.845504467&x0-2-3=0.3&x0-3-1=0&x0-3-2=0&x0-3-3=0&x0-4-1=0&x0-4-2=24.3&x0-4-3=0&x1name=%CC%E0%F0%F2&x1-1-1=0&x1-1-2=13.1211175935&x1-1-3=0&x1-2-1=0&x1-2-2=8.2999717725&x1-2-3=0.75&x1-3-1=0&x1-3-2=0&x1-3-3=0&x1-4-1=0&x1-4-2=0&x1-4-3=0&x2name=%C0%EF%F0%E5%EB%FC&x2-1-1=0&x2-1-2=0&x2-1-3=0&x2-2-1=0&x2-2-2=41.460579216&x2-2-3=4.2&x2-3-1=0&x2-3-2=0&x2-3-3=0&x2-4-1=0&x2-4-2=0&x2-4-3=0&x3name=%CC%E0%E9&x3-1-1=0&x3-1-2=0&x3-1-3=0&x3-2-1=0&x3-2-2=87.985064976&x3-2-3=14.4&x3-3-1=0&x3-3-2=0&x3-3-3=0&x3-4-1=0&x3-4-2=0&x3-4-3=0&x4name=%C8%FE%ED%FC&x4-1-1=0&x4-1-2=0&x4-1-3=0&x4-2-1=0&x4-2-2=44.61468957&x4-2-3=6.75&x4-3-1=0&x4-3-2=0&x4-3-3=0&x4-4-1=0&x4-4-2=0&x4-4-3=0&x5name=%C8%FE%EB%FC&x5-1-1=0&x5-1-2=0&x5-1-3=0&x5-2-1=0&x5-2-2=0&x5-2-3=0&x5-3-1=0&x5-3-2=0&x5-3-3=0&x5-4-1=0&x5-4-2=0&x5-4-3=0&
for ($cn=0;$cn<24;$cn++)
{
 $nn='x'.$cn.'n';
 if ($_GET[$nn]!='')
	{
	 $dat[$cn]=$_GET[$nn];	
	 $nn='x'.$cn.'-1-1'; $data11[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-1-2'; $data12[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-1-3'; $data13[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-2-1'; $data21[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-2-2'; $data22[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-2-3'; $data23[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-3-1'; $data31[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-3-2'; $data32[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-3-3'; $data33[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-4-1'; $data41[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-4-2'; $data42[$cn]=$_GET[$nn];
	 $nn='x'.$cn.'-4-3'; $data43[$cn]=$_GET[$nn];
	}
}

$graph = new Graph(600,250,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot11=new BarPlot($data11);
$lineplot11->SetFillColor("blue");
$lineplot12=new BarPlot($data12);
$lineplot12->SetFillColor("aqua");
$lineplot13=new BarPlot($data13);
$lineplot13->SetFillColor("darkblue");

$lineplot21=new BarPlot($data21);
$lineplot21->SetFillColor("red");
$lineplot22=new BarPlot($data22);
$lineplot22->SetFillColor("pink");
$lineplot23=new BarPlot($data23);
$lineplot23->SetFillColor("indianred");

$lineplot31=new BarPlot($data31);
$lineplot31->SetFillColor("yellow");
$lineplot32=new BarPlot($data32);
$lineplot32->SetFillColor("yellowgreen");
$lineplot33=new BarPlot($data33);
$lineplot33->SetFillColor("green");

$lineplot41=new BarPlot($data41);
$lineplot41->SetFillColor("gray");
$lineplot42=new BarPlot($data42);
$lineplot42->SetFillColor("black");
$lineplot43=new BarPlot($data43);
$lineplot43->SetFillColor("darkgray");

$graph ->legend->Pos( 0.02,0.07,"right" ,"top");
$lineplot11->SetLegend("ХВС:давление");
$lineplot12->SetLegend("ХВС:бесперебойность");
$lineplot21->SetLegend("ГВС:давление");
$lineplot22->SetLegend("ГВС:бесперебойность");
$lineplot23->SetLegend("ГВС:температура");
$lineplot32->SetLegend("Тепло:бесперебойность");
$lineplot42->SetLegend("ЭЭ:бесперебойность");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
$graph->title->Set("Переплата за некачественно предоставленные услуги (%)");
//$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Add the plot to the graph
$graph->img->SetMargin(25,28,33,25);
//----------- title --------------------
$acbplot1 = new AccBarPlot(array($lineplot11,$lineplot12,$lineplot13));
$acbplot2 = new AccBarPlot(array($lineplot21,$lineplot22,$lineplot23));
$acbplot3 = new AccBarPlot(array($lineplot31,$lineplot32,$lineplot33));
$acbplot4 = new AccBarPlot(array($lineplot41,$lineplot42,$lineplot43));

$acbplot1->value->Show();
$acbplot2->value->Show();
$acbplot3->value->Show();
$acbplot4->value->Show();

$gbplot  = new GroupBarPlot (array($acbplot1,$acbplot2,$acbplot3,$acbplot4)); 
$graph->Add($gbplot);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>