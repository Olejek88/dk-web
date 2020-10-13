function setULPosition()
{
	var uls = document.getElementById("main-menu").getElementsByTagName("UL");
	for (var i=0; i<uls.length; i++) 
	{
		rightCorner =  coord(uls[i]).x + uls[i].clientWidth + 20;
		if ( rightCorner >= getWindowSize().width )
		{
			uls[i].style.marginLeft = '-'+ (uls[i].clientWidth-30) +'px';
			uls[i].style.marginTop = '-20px';
		}
	}
}

function fr(mid) {
	obj = document.getElementById(mid);
	rightCorner =  coord(obj).x + obj.clientWidth + 20;
	if ( rightCorner >= getWindowSize().width )
	{
		obj.style.marginLeft = '-'+ (obj.clientWidth-30) +'px';
		obj.style.marginTop = '-20px';
	}
	obj.style.display = 'block';
	obj.style.visibility = 'visible';
}

function fo(mid) {
	obj = document.getElementById(mid);
	obj.style.display = 'none';
}

function coord(e)
{
	var x=0, y=0;
	do {
		x += e.offsetLeft || 0;
		y += e.offsetTop || 0;
	} while (e = e.offsetParent)
	return {x:x, y:y};
}

function getWindowSize() {
    var myWidth = 0, myHeight = 0;
    if( typeof( window.innerWidth ) == 'number' ) {
        //Non-IE
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;
    } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
        //IE 6+ in 'standards compliant mode'
        myWidth = document.documentElement.clientWidth;
        myHeight = document.documentElement.clientHeight;
    } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
        //IE 4 compatible
        myWidth = document.body.clientWidth;
        myHeight = document.body.clientHeight;
    }
    return {height:myHeight, width:myWidth};
}