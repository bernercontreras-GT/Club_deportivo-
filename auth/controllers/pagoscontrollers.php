<?php
function obtenerPagos($socio_id) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT fecha_pago, monto, estado FROM pagos WHERE socio_id = ?");
    $stmt->bind_param("i", $socio_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}