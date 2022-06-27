<?php
//Incluimos el fichero de conexion
include_once("dbconect.php");
//Incluimos la libreria PDF
include_once('libs/fpdf.php');
 
class PDF extends FPDF
{
// Funcion encargado de realizar el encabezado
function Header()
{
    // Logo
    //$this->Image('logo.jpg',10,-1,70);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(160);
    // Title
    $this->Cell(95,10,'Lista de Clientes',1,0,'C');
    // Line break (espacio)
    $this->Ln(20);
}
// Funcion pie de pagina
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$db = new dbConexion();
$connString =  $db->getConexion();
$display_heading = array('id_cliente'=>'ID', 'nombre_cliente'=> 'NOMBRE', 'fiscal_cliente'=> 'FISCAL','telefono_cliente'=> 'TELEFONO', 'cel_cliente'=> 'CELULAR', 'email_cliente'=> 'EMAIL','tipo_cliente'=> 'TIPO',);
 
$result = mysqli_query($connString, "SELECT id_cliente, nombre_cliente, fiscal_cliente, telefono_cliente, cel_cliente, email_cliente, tipo_cliente FROM clientes") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM clientes");
 
//$pdf = new PDF();
//Horientacion de las paginas
$pdf=new PDF('L','mm','A4');
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
// Declaramos el ancho de las columnas
$w = array(10, 75, 30, 30, 30, 60, 20);
//Declaramos el encabezado de la tabla
$pdf->Cell(10,12,'ID',1);
$pdf->Cell(75,12,'NOMBRE',1);
$pdf->Cell(30,12,'FISCAL',1);
$pdf->Cell(30,12,'TELEFONO',1);
$pdf->Cell(30,12,'CELULAR',1);
$pdf->Cell(60,12,'EMAIL',1);
$pdf->Cell(20,12,'TIPO',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
//Mostramos el contenido de la tabla
 foreach($result as $row)
    {
      if ($row['tipo_cliente'] == 1) {
        $tipo_cliente = "Empresa";
      } else {
        $tipo_cliente = "Corriente";
      }
        $pdf->Cell($w[0],6,$row['id_cliente'],1);
        $pdf->Cell($w[1],6,$row['nombre_cliente'],1);
        $pdf->Cell($w[2],6,$row['fiscal_cliente'],1);
        $pdf->Cell($w[3],6,$row['telefono_cliente'],1);
        $pdf->Cell($w[4],6,$row['cel_cliente'],1);
        $pdf->Cell($w[5],6,$row['email_cliente'],1);
        $pdf->Cell($w[6],6,$tipo_cliente,1);
        $pdf->Ln();
    }
$pdf->Output();
?>
