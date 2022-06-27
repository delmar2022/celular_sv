<?php
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php";
//consulta a la tabla perfil
require('libs/fpdf.php');

$resultado = mysqli_query($conexion,"SELECT * FROM proveedores");
class PDF extends FPDF
{
// Funcion encargado de realizar el encabezado
function Header()
{
    global $logo;
    global $user_id;
    global $users;
    // Logo
    //$this->Image($logo,10,-5,50);
    //$this->SetFont('Arial','B',13);
    $ancho = 190;
        //$this->SetFont('Arial', 'B', 13);
        $this->Image($logo, 10, 5, 40); //Insertamos el logo si es en PNG su calidad o formato debe estar entre PNG 8/PNG 24
        $ancho = 190;
        $this->SetFont('Arial', 'B', 16);//Tamanio del encabezado
        $this->Cell(240, 30, "Reporte de Clientes", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
            $horizontal = 65; //Permitirá que las dimensiones que abarca horizontalmente sea 85 puntos más que cuando es vertical
            $this->SetY(10);
            $this->Cell($ancho + $horizontal, 10,'Usuario: '.$users.'', 0, 0, 'R');
            $this->SetY(15);
            $this->Cell($ancho + $horizontal, 10,'Fecha: '.date('d/m/Y'), 0, 0, 'R');
            $this->SetY(20);
            $this->Cell($ancho + $horizontal, 10,'Hora: '.date('H:i:s'), 0, 0, 'R');            
        
    $this->Ln(25);
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
//Instaciamos la clase para genrear el documento pdf
//$pdf=new FPDF();
$pdf=new FPDF('L','mm','A4', true, 'UTF-8', false);

//Agregamos la primera pagina al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles
$y_axis_initial = 25;

//Seteamos el tiupo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE PRODUCTOS',1,0,'C');
$pdf->Ln(10);

//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
//Color de Fondo de las celdas del encabezado
$pdf->setFillColor(133, 193, 233);
// Declaramos el ancho de las columnas
$w = array(10, 75, 30, 30, 30, 60, 20);
//Declaramos el encabezado de la tabla
$pdf->Cell(10,12,'ID',1,0,'C',1);
$pdf->Cell(75,12,'NOMBRE',1,0,'C',1);
$pdf->Cell(30,12,'FISCAL',1,0,'C',1);
$pdf->Cell(30,12,'TELEFONO',1,0,'C',1);
$pdf->Cell(30,12,'CELULAR',1,0,'C',1);
$pdf->Cell(60,12,'EMAIL',1,0,'C',1);
$pdf->Cell(20,12,'TIPO',1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->setFillColor(213, 216, 220);
$bandera = false; //Para alternar el relleno
//Comienzo a crear las fiulas de productos según la consulta MySQL
while($fila = mysqli_fetch_array($resultado))
{
//$imagen="fotos/".$row['imagen1'];
if ($fila['tipo_proveedor'] == 1) {
    $tipo_cliente = "Empresa";
  } else {
    $tipo_cliente = "Corriente";
  }
    $pdf->Cell($w[0],6,utf8_decode($fila['id_proveedor']),1, 0 , 'L', $bandera);
    $pdf->Cell($w[1],6,utf8_decode($fila['nombre_proveedor']),1, 0 , 'L', $bandera);
    $pdf->Cell($w[2],6,utf8_decode($fila['fiscal_proveedor']),1, 0 , 'L', $bandera);
    $pdf->Cell($w[3],6,utf8_decode($fila['telefono_proveedor']),1, 0 , 'L', $bandera);
    $pdf->Cell($w[4],6,utf8_decode($fila['cel_proveedor']),1, 0 , 'L', $bandera);
    $pdf->Cell($w[5],6,utf8_decode($fila['email_proveedor']),1,0 , 'L', $bandera);
    $pdf->Cell($w[6],6,$tipo_cliente,1,0 , 'L', $bandera);
    $pdf->Ln();
    $bandera = !$bandera;//Alterna el valor de la bandera
//Muestro la iamgen dentro de la celda GetX y GetY dan las coordenadas actuales de la fila

//$pdf->Cell( 30, 15, $pdf->Image($imagen, $pdf->GetX()+5, $pdf->GetY()+3, 20), 1, 0, 'C', false );

//$pdf->Ln(15);

}

//mysql_close($enlace);

//Mostramos el documento pdf
$pdf->Output();
?>