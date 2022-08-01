<?php
include "config.inc";
define('FPDF_FONTPATH','./font/');
require('./fpdf.php');



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
	global $sklep_adres;

	$this->SetFont('arialpl', '', 8); 
	$this->SetTextColor(0);
	$this->SetFillColor(255,255,255);
	$this->Cell(0,4,"Dnia: ".date("Y-m-d"),0,0,'R',1);
	$this->Ln(4);


	$this->SetFont('arialpl', '', 10); 
	//$w=$this->GetStringWidth($title)+32;
	$w=180;
	$this->SetX((210-$w)/2);
	$this->SetDrawColor(0,80,180);
	$this->SetFillColor(230,230,230);
	$this->SetTextColor(50,50,220);
	$this->SetLineWidth(1);
	$this->Cell($w,6,$title,0,0,'C',1);
	$this->Ln(8);
	$this->SetTextColor(0);
	$this->SetFillColor(255,255,255);
	$this->SetFont('arialpl', '', 8); 
	$this->Cell($w,4,$sklep_adres,0,0,'C',1);
	$this->Ln(4);


	//$this->Cell($w,4,'email: combit_sc@wp.pl      czynne: pon.-pi±t. - 10-18, sobota 10-14',0,0,'C',1);
	//$this->Ln(8);
	//Save ordinate
	$this->y0=$this->GetY();
}

function Footer()
{
	//Stopka strony
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetY(-20);
	$this->SetX(40);
	$this->SetFont('arialpl', '', 10); 
	$this->SetX(20);
	$this->Cell(100,6,'Zapraszamy do zakupów :-)',0,0,'L',1);
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
	$this->Cell(52,2,$nazwa,'LR');
	$this->Cell(9,2,$brutto,0,0,'R',0);
	$this->MultiCell(1,2,'','R');

	//Powróæ do pierwszej kolumny...
	//$this->SetCol(0);
}

function Kategoria($nazwa)
{
        //$this->MultiCell(62,2,'','T');
	$this->SetFont('arialpl', '', 8); 

	$this->SetDrawColor(11,12,13);
	$this->SetFillColor(200,200,200);
	$this->SetTextColor(0,0,0);

	$this->Cell(62,4,$nazwa,1,0,'C',1);
	$this->Ln(3);
	$this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	//$this->MultiCell(62,0,'','T');
	$this->SetFont('arialpl', '', 6);
	//$this->Ln();
}

}


// dane z mysql
include "config.inc";
$db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
@mysql_select_db("$databasename",$db);

$pdf=new PDF();
$pdf->Open();

$pdf->AddFont('arialpl', '', 'arialpl.php'); 
$title=$ordersubject;
$sklep_adres = $nazwa_sklepu . ' - ' . $adres_sklepu;

$pdf->AddPage();

$pdf->SetFont('arialpl', '', 8); 
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(0,0,0);

// margines lewy tabeli na stronie...
$tabela_x=19;



  // wy³uskanie danych
  $subtotal = 0;
  $subtotal2 = 0;
  $subtotal3 = 0;
  $_basket=$_COOKIE["basket"];
  $items = explode("&", $_basket);
  if (count($items)>1)
  {

    //kolumny nazwa, brutto, netto, sumabrutto, sumanetto    
    $w=array(8,70,15,15,15,12,18,18);
    //Nag³ówek
    for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    $pdf->SetX($tabela_x); 
    $pdf->Cell($w[0],6,'Lp.','LRTB');
    $pdf->Cell($w[1],6,'Nazwa','LRTB');
    $pdf->Cell($w[2],6,'Brutto','LRTB',0,'R');
    $pdf->Cell($w[3],6,'Netto','LRTB',0,'R');
    $pdf->Cell($w[4],6,'VAT','LRTB',0,'R');
    $pdf->Cell($w[5],6,'jm','LRTB',0,'R');
    $pdf->Cell($w[6],6,'Wart. Bruto','LRTB',0,'R');
    $pdf->Cell($w[7],6,'Wart. Netto','LRTB',0,'R');
    $pdf->Ln();


    for ($i = 0; $i < count($items)-1; $i++) 
    {
      // dane z bazy o cenie i nazwie produktu...
      // wy³uskanie ilo¶ci i identyfikatora z $items
      $items_values = explode("=", $items[$i]);
      $items_id = $items_values[0];
      $items_val = $items_values[1];
      $sql="SELECT * FROM produkty WHERE id=$items_id";
      $result = @mysql_query("$sql",$db);
      $nazwa = @mysql_result($result, 0, "nazwa");
      $brutto = @mysql_result($result, 0, "brutto");
      $netto = @mysql_result($result, 0, "netto");
      $vat = $brutto-$netto;
      $jm = $items_val;
      $wart_brutto=$items_val*$brutto;
      $wart_netto=$items_val*$netto;

      $sql2="SELECT kategorie.nazwa FROM kategorie, produkty WHERE produkty.kategorie_id=kategorie.id AND produkty.id=$items_id";
      $result2=@mysql_query("$sql2",$db);
      $nazwa2 = @mysql_result($result2, 0, "nazwa");
      $wartosc = $brutto*$items_val;
      $subtotal = $subtotal+$wart_brutto;
      $subtotal2 = $subtotal2+$wart_netto;


        $subtotal3 += $vat;
	$pdf->SetX($tabela_x); 
	$pdf->Cell($w[0],6,$i+1,'LR');
	$pdf->Cell($w[1],6,$nazwa,'LR');
	$pdf->Cell($w[2],6,number_format($brutto,2),'LR',0,'R');
	$pdf->Cell($w[3],6,number_format($netto,2),'LR',0,'R');
	$pdf->Cell($w[4],6,number_format($vat,2),'LR',0,'R');
	$pdf->Cell($w[5],6,number_format($jm,2),'LR',0,'R');
	$pdf->Cell($w[6],6,number_format($wart_brutto,2),'LR',0,'R');
	$pdf->Cell($w[7],6,number_format($wart_netto,2),'LR',0,'R');
	$pdf->Ln();
    }
    //zamkniêcie tabelki
    $pdf->SetX($tabela_x); 
    $pdf->Cell(array_sum($w),0,'','T');

    // i dodrukowanie sumy
    $pdf->Ln();
    $pdf->SetX($tabela_x); 
    $pdf->Cell($w[0],6,'','RT');
    $pdf->Cell($w[1],6,'','B',0,'R');
    $pdf->Cell($w[2],6,'','B',0,'R');
    $pdf->Cell($w[3],6,'','B',0,'R');
    $pdf->Cell($w[4],6,'','B',0,'R');
    $pdf->Cell($w[5],6,'Suma pozycji:','RB',0,'R');
    $pdf->Cell($w[6],6,number_format($subtotal,2),'LRB',0,'R');
    $pdf->Cell($w[7],6,number_format($subtotal2,2),'LRB',0,'R');

    $pdf->Ln();


  }
  else
  {
    $pdf->SetX(40); 
    // zamówienie puste...
    $pdf->Cell($w,4,'Puste zamówienie - zapraszamy do zakupów!',0,0,'C',1);
  }

$pdf->Output();
?>
