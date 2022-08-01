//-------------------------- BLOKADA PRAWEGO KLAWISZA ---------------------------
var message="Witaj na naszej stronie!";
///////////////////////////////////
function clickIE() {if (document.all) {alert(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {alert(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

//-------------------------- KONIEC BLOKADY--------------------------------------
nn4 = (document.layers) ? true : false;
ie4 = (document.all) ? true : false;
All=new Array("tip1","tip2");
function Pokaz(Blok, e)
{
  if (nn4)
    {
      	document.layers[Blok].left=e.pageX+10;
	document.layers[Blok].top=e.pageY+10;
	document.layers[Blok].visibility="visible";	
    }	
  if (ie4)	
    {	
	document.all[Blok].style.pixelLeft=document.body.scrollLeft+event.clientX+10;
	document.all[Blok].style.pixelTop=document.body.scrollTop+event.clientY+10;
	document.all[Blok].style.visibility="visible";	
    }	
  setTimeout("Ukryj()",4000);
}

function Ukryj()
{ 
  for (i in All)	
  {
    if (nn4) document.layers[All[i]].visibility="hidden";
    if (ie4) document.all[All[i]].style.visibility="hidden";	
  }
}

function pokazImage(co)
{
  //features="toolbar=no, menubar=no, location=no, left=200, top=100, width="+x+", height="+y
  window.open("pokazimage.php?productid="+co,"_blank2","toolbar=no, location=no, width=1, height=1, left=0, top=0");
}

function buyItem(itemno)
{
  window.open("buy.php?"+itemno,"_blank","toolbar=no, location=no, resizable=yes, scrollbars=no, width=500, height=200, left=200, top=100, menubar=no");
}

function PokazKategorie(cid)
{
  window.location.href="main.php?cat="+cid; 
}

function PokazTyp(mid)
{
  window.location.href="main.php?mid="+mid; 
}

function SzukajProduktu(s)
{
  window.location.href="main.php?ssid="+s;
}

function DodajDoUlubionych()
{
  window.external.addFavorite('http://www.onet.pl','ONET')
}
