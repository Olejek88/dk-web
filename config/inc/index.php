<meta http-equiv="Pragma" content="no-cache">
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=koi-8r">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Интерфейс доступа к данным и редактирования конфигурации</title>
<script language="JavaScript" type="text/javascript" src="view.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar-1.0/skins/aqua/theme.css" title="Aqua" />
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript">setActiveStyleSheet(this, 'Aqua');</script>
</head>
<body onLoad="startShow()" leftmargin=0 topmargin=1 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table cellpadding="0" cellspacing="0" border="0" style="width:1250px">
<tr><td bgcolor=#617a94 width=100% height=15><div id="top"></div></td></tr>
<tr><td width=100%>
    <table cellpadding="0" cellspacing="0" border="0" style="width:1250px">
    <tr>	
	<td width="250px">
	<table cellpadding="0" cellspacing="1" border="0" style="width:250px">
	    <tr><td>
		<div id="top_flats">
		</div>
	    </td></tr>
	    <tr><td align=center bgcolor=#617a94 height=15><font class="menu">Отчет по квартире</font>
	    </td></tr>
	    <tr><td align=center>
    		<div id="calendar-container"></div>
	    </td></tr>
	    <tr><td align=center>
    		<div id="report" class="calendar"></div>
	    </td></tr>	    
	    <tr><td align=center bgcolor=#617a94 height=15><font class="menu">Статистика</font></td></tr>
	    <tr><td>
		<div id="stats">
		</div>
	    </td></tr>
	</table>	
	</td>
	
	<td width="1000px">
	<table cellpadding="0" cellspacing="0" border="0" style="width:1000px">
    	    <tr><td width="1000px">
		<table cellpadding="0" cellspacing="0" border="0" style="width:1000px">
		<tr>
		    <td style="width:500px"><div id="hour_charts">
		    </div></td>
		    <td style="width:500px"><div id="hour_report">
		    </div></td>
		</tr>
		</table>
	    </td></tr>
    	    <tr><td width="1000px">
		<table cellpadding="0" cellspacing="0" border="0" style="width:1000px">
		<tr>
		    <td width="850px">
			<table cellpadding="0" cellspacing="0" border="0" style="width:850px">
			<tr>
			    <td style="width:550px">
			    <div id="devices">
			    </div></td>
			    <td style="width:300px">
			    <div id="current">
			    </div></td>	    
			</tr>
			<tr>
			    <td style="width:850px">
			    <div id="events">
			    </div></td>
			</tr>
			</table>
		    </td>
		    <td width="150px">
			<table cellpadding="0" cellspacing="0" border="0" style="width:150px">
			<tr><td>
			<div id="login"></div>
		        </td></tr>
			<tr><td>
			<div id="menu"></div>
		        </td></tr>				
			</table>
		    </td>
		</tr>
		</table>
	    </td></tr>
	    
	</table>
	</td>
	
    </tr>
    </table>
</td></tr>
<tr><td bgcolor=#617a94 width=100% height=15><div id="down"></div></td></tr>
</table>

<script type="text/javascript">
// the default multiple dates selected,
// first time the calendar is displayed
var MA = [];
	    
function dateChanged(calendar) {
  // Beware that this function is called even if the end-user only
  // changed the month/year.  In order to determine if a date was
  // clicked you can use the dateClicked property of the calendar:
  if (calendar.dateClicked) {
    // OK, a date was clicked, redirect to /yyyy/mm/dd/index.php
    var y = calendar.date.getFullYear();
    var m = calendar.date.getMonth();     // integer, 0..11
    var d = calendar.date.getDate();      // integer, 1..31
				        // redirect...
    window.location = "report.php?beg=" + y + "&end=" + m;
      }
    };
  Calendar.setup(
      {
        flat         : "calendar-container", // ID of the parent element
	multiple    : MA, // pass the initial or computed array of multiple dates
        flatCallback : dateChanged           // our callback function
      }
    );
</script>

</body>
</html>
