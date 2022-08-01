<?php
define('FPDF_FONTPATH','./font/');
require('./fpdf.php');
include "config.inc";

class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

function Header()
{
	//Page header
	global $title;
	global $logo;

	$y2=$this->GetY();
	//Logo
	$this->Image($logo,10,8,48);
	$this->SetFont('arialpl', '', 10); 
	$w=$this->GetStringWidth($title)+48;
	$this->SetX(100);
	$this->SetDrawColor(0,80,180);
	$this->SetTextColor(50,50,220);
	$this->SetLineWidth(1);
	$this->SetTextColor(0);
	$this->SetFillColor(255,255,255);
	$this->SetFont('arialpl', '', 8); 
	$this->SetY($y2-2);
	$this->SetX(15);
	$this->MultiCell($w-40,6,'Cennik ze sklepu internetowego  97-300 Piotrków Tryb. ul.S³owackiego 138a I piêtro,',0,0,'C',1);
	//$this->SetX(8);
	$this->MultiCell($w-23,6,'tel./fax: (0-44) 646-84-71  email: combit_sc@wp.pl      czynne: pon.-pi±t. - 10-18, sobota 10-14',0,0,'C',1);
	$this->Ln(4);
	$this->y0=$this->GetY();

}

function Footer()
{
	global $logo_stopka;

	//Stopka strony
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetY(-20);
	$this->SetX(60);
	$this->SetFont('arialpl', '', 12); 
	$this->Cell(80,6,$logo_stopka,0,0,'C',1);
	$this->Ln(6);
	$this->SetFont('arialpl', '', 6); 
	$this->SetX(15);
	$this->Cell(100,6,'* ceny zawieraj± podatek VAT',0,0,'R',1);
	$this->SetFont('arialpl', '', 8); 
	$this->Ln(1);
	$this->SetX(0);
	$this->Cell(0,10,'Strona '.$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
	//Ustala pozycje podanej kolumny
	$this->col=$col;
	$x=8+$col*65;
	$this->SetLeftMargin($x);
	$this->SetX($x);
}

function AcceptPageBreak()
{
	//Method accepting or not automatic page break
	if($this->col<2)
	{
		//Go to next column
		$this->SetCol($this->col+1);
		//Set ordinate to top
		$this->SetY($this->y0);
		//Keep on page
		return false;
	}
	else
	{
		//Go back to first column
		$this->SetCol(0);
		//Page break
		return true;
	}
}

function ChapterBody($nazwa,$brutto)
{
	$this->SetFont('arialpl', '', 6); 

	$w=array(40,8);
	$this->Cell(52,3,$nazwa,'LR');
	$this->Cell(9,3,$brutto,0,0,'R',0);
	$this->MultiCell(1,3,'','R');

	//Powróæ do pierwszej kolumny...
	//$this->SetCol(0);
}

function Kategoria($nazwa)
{
        //$this->MultiCell(62,2,'','T');
	$this->SetFont('arialpl', '', 7); 

	$this->SetDrawColor(11,12,13);
	$this->SetFillColor(200,200,200);
	$this->SetTextColor(0,0,0);

	$this->Cell(62,3,$nazwa,1,0,'C',1);
	$this->Ln(3);
	$this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('arialpl', '', 6);
	//	$this->MultiCell(62,2,'','T');
}

function PodKategoria($nazwa)
{
        //$this->MultiCell(62,4,'','T');
	$this->SetFont('arialpl', '', 6); 

	//$this->SetDrawColor(11,12,13);
	//$this->SetFillColor(200,200,200);
	//$this->SetTextColor(0,0,0);

	$this->Cell(62,3,$nazwa,1,0,'C',1);
	$this->Ln(3);
	$this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	//$this->MultiCell(62,0,'','T');
	$this->SetFont('arialpl', '', 6);
}

}
// koniec: class PDF extends FPDF

// dane z mysql
include "config.inc";
$db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
@mysql_select_db("$databasename",$db);


$pdf=new PDF();
$pdf->Open();

$pdf->AddFont('arialpl', '', 'arialpl.php'); 
$title='                                                                     Cennik                                                                     ';
$pdf->SetTitle($title);
$pdf->SetAuthor('jjprojekt');

$pdf->AddPage();

$pdf->SetFont('arialpl', '', 8); 

// czy nad-kategoria zawiera podkategorie
$sql="SELECT * FROM kategorie WHERE nadrzedny_id = id order by kolejnosc";
$result = @mysql_query($sql,$db);
for ($i = 0; $i < @mysql_num_rows($result); $i++) 
{

  $nazwa = @mysql_result($result, $i, "nazwa");
  $nadrzedny_id = @mysql_result($result, $i, "nadrzedny_id");

  $sql2="SELECT * FROM kategorie WHERE nadrzedny_id = $nadrzedny_id and nadrzedny_id<>id order by kolejnosc";
  $result2 = @mysql_query($sql2,$db);

  $pdf->Kategoria($nazwa);	
 
  // potem podkategorie...
  for ($j = 0; $j < @mysql_num_rows($result2); $j++)
  {
    $categoryname2 = @mysql_result($result2, $j, "nazwa");
    $categoryid = @mysql_result($result2, $j, "id");
    // liczba produktów w kategorii
    $sql3="SELECT id FROM produkty WHERE kategorie_id=$categoryid";
    $result3 = @mysql_query($sql3,$db);
    $count3 = @mysql_num_rows($result3);

    // je¶li w danej kategorii s± jakie¶ produkty... pokazuj j± :-)
    if ($count3>0) 
    {
      $pdf->PodKategoria($categoryname2);

      $sql4="SELECT * from produkty WHERE kategorie_id=$categoryid order by nazwa";
      $result4 = @mysql_query($sql4,$db);
      $k = 0;
      while ($k < @mysql_num_rows($result4))
      {
        $nazwa  = @mysql_result($result4, $k, "nazwa");
    	$brutto = @mysql_result($result4, $k, "brutto");
     	$netto  = @mysql_result($result4, $k, "netto");
	$miniatura = @mysql_result($result4, $k, "miniatura");
	 
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('arialpl', '', 6);

	//pokazanie produktu i ceny        
        if ($k==0)
	  $pdf->MultiCell(62,0,'','B');
	$pdf->ChapterBody($nazwa, $brutto,$miniatura);
	$k++;
        if ($k==@mysql_num_rows($result4))
	  {
	    //$pdf->MultiCell(62,1,'','T');
	    //$pdf->Ln(1);
          } 
      }
    }
  }
  $pdf->MultiCell(62,1,'','T');
}

$pdf->Output();
?>
