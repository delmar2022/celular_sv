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
$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
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
$resultado = mysqli_query($conexion,"SELECT id_proveedor, nombre_proveedor, fiscal_proveedor,telefono_proveedor, email_proveedor, tipo_proveedor FROM proveedores
WHERE nombre_proveedor LIKE '%" . $q . "%' OR fiscal_proveedor LIKE '%" . $q . "%'");
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
        $this->Cell(240, 30, "Reporte de Proveedores", 0, 1, 'C');
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
$w = array(10, 90, 35, 40, 70, 20);
//Declaramos el encabezado de la tabla
$pdf->Cell(10,12,'ID',1,0,'C',1);
$pdf->Cell(90,12,'NOMBRE',1,0,'C',1);
$pdf->Cell(35,12,'FISCAL',1,0,'C',1);
$pdf->Cell(40,12,'TELEFONO',1,0,'C',1);
$pdf->Cell(70,12,'EMAIL',1,0,'C',1);
$pdf->Cell(20,12,'TIPO',1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->setFillColor(213, 216, 220);
$bandera = false; //Para alternar el relleno
//Mostramos el contenido de la tabla
while($fila = mysqli_fetch_array($resultado))
    {
        if ($fila['tipo_proveedor'] == 1) {
            $tipo_cliente = "Empresa";
          } else {
            $tipo_cliente = "Corriente";
          }
            $pdf->Cell($w[0],6,utf8_decode($fila['id_proveedor']),1, 0 , 'L', $bandera);
            $pdf->Cell($w[1],6,utf8_decode($fila['nombre_proveedor']),1, 0 , 'L', $bandera);
            $pdf->Cell($w[2],6,utf8_decode($fila['fiscal_proveedor']),1, 0 , 'L', $bandera);
            $pdf->Cell($w[3],6,utf8_decode($fila['telefono_proveedor']),1, 0 , 'L', $bandera);
            $pdf->Cell($w[4],6,utf8_decode($fila['email_proveedor']),1,0 , 'L', $bandera);
            $pdf->Cell($w[5],6,$tipo_cliente,1,0 , 'L', $bandera);
            $pdf->Ln();
            $bandera = !$bandera;//Alterna el valor de la bandera
    }
$pdf->Output();
?>
