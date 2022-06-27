<?php
session_start();
$user_id = $_SESSION['id_users'];
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Incluimos la libreria PDF
include_once('libs/fpdf.php');
//consulta a la tabla perfil
//$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
$id_categoria = intval($_REQUEST['categoria']);
$sql           = mysqli_query($conexion, "SELECT moneda, nombre_empresa, logo_url FROM perfil");
    $rw            = mysqli_fetch_array($sql);
    $moneda        = $rw["moneda"];
    $bussines_name = $rw["nombre_empresa"];
    $logo      = $rw["logo_url"];
// Consulta de los usuarios
    $user           = mysqli_query($conexion, "SELECT nombre_users, apellido_users FROM users WHERE id_users = $user_id");
    $row            = mysqli_fetch_array($user);
    $users = $row['nombre_users'].' '.$row['apellido_users'];
//Consulta de la Tabla Proveedores
$tables       = "productos";
$campos       = "id_producto, codigo_producto, nombre_producto, id_linea_producto, costo_producto, valor1_producto, valor2_producto, valor3_producto, valor4_producto, stock_producto, estado_producto";
$sWhere       = "id_producto <> 0";
if ($id_categoria > 0) {
    $sWhere .= " and id_linea_producto = '" . $id_categoria . "' ";
}
$sWhere .= " order by id_producto";
$resultado = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere ");

class PDF extends FPDF
{
// Funcion encargado de realizar el encabezado
function Header()
{
    global $logo;
    global $user_id;
    global $users;
    // Logo
        $this->Image($logo, 10, 5, 40); //Insertamos el logo si es en PNG su calidad o formato debe estar entre PNG 8/PNG 24
        $this->SetFont('Arial', 'B', 16);//Tamanio del encabezado
        $this->Cell(300, 30, "Reporte de Productos", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $ancho = 220;//mover el encabezado derecho
            $horizontal = 60; //Permitirá que las dimensiones que abarca horizontalmente sea 85 puntos más que cuando es vertical
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
 
//$pdf = new PDF();
//Horientacion de las paginas
$pdf=new PDF('L','mm','A4', true, 'UTF-8', false);
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
//Color de Fondo de las celdas del encabezado
$pdf->setFillColor(133, 193, 233);
// Declaramos el ancho de las columnas
$w = array(40, 75, 25, 25, 25, 25, 25, 20, 20);
//Declaramos el encabezado de la tabla
$pdf->Cell(40,12,'CODIGO',1,0,'C',1);
$pdf->Cell(75,12,'NOMBRE',1,0,'C',1);
$pdf->Cell(25,12,'COSTO',1,0,'C',1);
$pdf->Cell(25,12,'P.VENTA 1.',1,0,'C',1);
$pdf->Cell(25,12,'P.VENTA 2',1,0,'C',1);
$pdf->Cell(25,12,'P.VENTA 3',1,0,'C',1);
$pdf->Cell(25,12,'P.VENTA 4',1,0,'C',1);
$pdf->Cell(20,12,'STOCK',1,0,'C',1);
$pdf->Cell(20,12,'ESTADO',1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->setFillColor(213, 216, 220);
$bandera = false; //Para alternar el relleno
//Mostramos el contenido de la tabla
while($row = mysqli_fetch_array($resultado))
    {
      if ($row['estado_producto'] == 1) {
        $estado = "ACTIVO";
      } else {
        $estado = "INACTIVO";
      }
        $pdf->Cell($w[0],6,utf8_decode($row['codigo_producto']),1, 0 , 'L', $bandera);
        $pdf->Cell($w[1],6,utf8_decode($row['nombre_producto']),1, 0 , 'L', $bandera);
        $pdf->Cell($w[2],6,($moneda.' '.formato($row['costo_producto'])),1, 0 , 'L', $bandera);
        $pdf->Cell($w[3],6,($moneda.' '.formato($row['valor1_producto'])),1, 0 , 'L', $bandera);
        $pdf->Cell($w[4],6,($moneda.' '.formato($row['valor2_producto'])),1, 0 , 'L', $bandera);
        $pdf->Cell($w[5],6,($moneda.' '.formato($row['valor3_producto'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[6],6,($moneda.' '.formato($row['valor4_producto'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[7],6,$row['stock_producto'],1, 0 , 'C', $bandera);
        $pdf->Cell($w[8],6,$estado,1,0 , 'L', $bandera);
        $pdf->Ln();
        $bandera = !$bandera;//Alterna el valor de la bandera
    }
$pdf->Output();
?>
