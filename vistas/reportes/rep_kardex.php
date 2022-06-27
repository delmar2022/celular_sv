<?php
session_start();
$user_id = $_SESSION['id_users'];
$id_producto = $_SESSION['id'];
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Incluimos la libreria PDF
include_once('libs/fpdf.php');
//consulta a la tabla perfil
$nombre_producto = get_row('productos', 'nombre_producto', 'id_producto', $id_producto);
//$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
$daterange = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
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
$tables    = "kardex, productos";
$campos    = "*";
$sWhere    = "kardex.producto_kardex=productos.id_producto";
if (!empty($daterange)) {
    list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
    list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
    $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
    list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
    $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

    $sWhere .= " and kardex.fecha_kardex between '$fecha_inicial' and '$fecha_final' ";
}
$sWhere .= " and kardex.producto_kardex='" . $id_producto . "'";
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
$pdf->SetFont('Arial','B',12);//Formato del texto
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$pdf->setFillColor(235, 237, 239);//Fondo de las celdas
$pdf->Cell(280,12,'PRODUCTOx:'.$nombre_producto.'',1,0,'C',1);
$pdf->Ln();
//Encabezados Principales
$pdf->SetFont('Arial','B',12);//Formato del texto
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$pdf->setFillColor(133, 193, 233);//Fondo de las celdas
    $pdf->Cell(55,12,'FECHA',1,0,'C',1);
    $pdf->Cell(75,12,'ENTRADA',1,0,'C',1);
    $pdf->Cell(75,12,'SALIDA.',1,0,'C',1);
    $pdf->Cell(75,12,'SALDO',1,0,'C',1);
    $pdf->Ln();

$pdf->SetFont('Arial','B',12);//Formato del texto
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$pdf->setFillColor(133, 193, 233);//Fondo de las celdas de los encabezados
// Declaramos el ancho de las columnas
$w = array(30,25, 25, 25, 25, 25, 25, 25, 25, 25, 25);
//Declaramos el encabezado de la tabla
$pdf->Cell(30,12,'',1,0,'C',1);
$pdf->Cell(25,12,'DETALLE',1,0,'C',1);
$pdf->Cell(25,12,'CANT.',1,0,'C',1);
$pdf->Cell(25,12,'COSTO',1,0,'C',1);
$pdf->Cell(25,12,'TOTAL',1,0,'C',1);
$pdf->Cell(25,12,'CANT.',1,0,'C',1);
$pdf->Cell(25,12,'COSTO',1,0,'C',1);
$pdf->Cell(25,12,'TOTAL',1,0,'C',1);
$pdf->Cell(25,12,'CANT.',1,0,'C',1);
$pdf->Cell(25,12,'COSTO',1,0,'C',1);
$pdf->Cell(25,12,'TOTAL',1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->setFillColor(213, 216, 220);
$bandera = false; //Para alternar el relleno
//Mostramos el contenido de la tabla
while($row = mysqli_fetch_array($resultado))
    {
        if ($row['tipo_movimiento'] == 1) {
            $movto = 'COMPRA';
        } else if ($row['tipo_movimiento'] == 3 or $row['tipo_movimiento'] == 4) {
            $movto = 'AJUSTE';
        } else {
            $movto = 'VENTA';
        }
        $pdf->Cell($w[0],6,date("d/m/Y", strtotime($row['fecha_kardex'])),1, 0 , 'L', $bandera);
        $pdf->Cell($w[1],6,$movto,1, 0 , 'L', $bandera);
        $pdf->Cell($w[2],6,$row['cant_entrada'],1, 0 , 'L', $bandera);
        $pdf->Cell($w[3],6,($moneda.' '.formato($row['costo_entrada'])),1, 0 , 'L', $bandera);
        $pdf->Cell($w[4],6,($moneda.' '.formato($row['total_entrada'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[5],6,$row['cant_salida'],1,0 , 'L', $bandera);
        $pdf->Cell($w[6],6,($moneda.' '.formato($row['costo_salida'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[7],6,($moneda.' '.formato($row['total_salida'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[8],6,$row['cant_saldo'],1,0 , 'L', $bandera);
        $pdf->Cell($w[9],6,($moneda.' '.formato($row['costo_saldo'])),1,0 , 'L', $bandera);
        $pdf->Cell($w[10],6,($moneda.' '.formato($row['total_saldo'])),1,0 , 'L', $bandera);
        $pdf->Ln();
        $bandera = !$bandera;//Alterna el valor de la bandera
    }
$pdf->Output();
?>
