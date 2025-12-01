<?php
require_once '../../../config/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $estado = $_GET['estado'] ?? 'todos';
    $export = $_GET['export'] ?? null;

    // Consulta base
   $sql = "SELECT p.ID, u.Nombre AS socio, m.Nombre_membresia AS membresia, p.Fecha_pago AS fecha, p.Monto AS monto, p.Estado AS estado
            FROM pagos p
            JOIN socios s ON p.id_socio = s.ID
            JOIN usuarios u ON s.id_usuario = u.ID
            JOIN membresias m ON p.id_membresia = m.ID";


    if ($estado !== 'todos') {
        $sql .= " WHERE p.Estado = '" . $mysqli->real_escape_string($estado) . "'";
    }

    $res = $mysqli->query($sql);
    $data = $res->fetch_all(MYSQLI_ASSOC);

    // --- Exportación PDF ---
    if ($export === 'pdf') {
        require_once ('../../../fpdf/fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,'Reporte de Pagos',0,1,'C');
        $pdf->Ln(5);

        // Encabezados
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,'Socio',1);
        $pdf->Cell(40,10,'Membresia',1);
        $pdf->Cell(30,10,'Fecha',1);
        $pdf->Cell(30,10,'Monto',1);
        $pdf->Cell(30,10,'Estado',1);
        $pdf->Ln();

        // Datos
        $pdf->SetFont('Arial','',10);
        foreach ($data as $row) {
            $pdf->Cell(40,10,$row['socio'],1);
            $pdf->Cell(40,10,$row['membresia'],1);
            $pdf->Cell(30,10,$row['fecha'],1);
            $pdf->Cell(30,10,'Q'.$row['monto'],1);
            $pdf->Cell(30,10,$row['estado'],1);
            $pdf->Ln();
        }

        $pdf->Output('I','reporte_pagos.pdf');
        exit;
    }

    // --- Exportación Excel ---
    if ($export === 'excel') {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=reporte_pagos.xls");
        echo "Socio\tMembresia\tFecha\tMonto\tEstado\n";
        foreach ($data as $row) {
            echo "{$row['socio']}\t{$row['membresia']}\t{$row['fecha']}\t{$row['monto']}\t{$row['estado']}\n";
        }
        exit;
    }

    // --- JSON por defecto (para mostrar pagos en la página) ---
    header('Content-Type: application/json');
    echo json_encode($data);
}


elseif ($metodo === 'POST') {
    $fecha = limpiar($_POST['fecha_pago']);
    $monto = limpiar($_POST['monto']);
    $estado = limpiar($_POST['estado']);
    $id_socio = limpiar($_POST['id_socio']);
    $id_membresia = limpiar($_POST['id_membresia']);

    $stmt = $mysqli->prepare("INSERT INTO pagos (Fecha_pago, Monto, Estado, id_socio, id_membresia) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssii', $fecha, $monto, $estado, $id_socio, $id_membresia);
    $stmt->execute();

    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'Pago registrado correctamente']);
}
?> 