function generarReportePagos() {
  const estado = document.getElementById('filtroEstado').value;
  const mes = document.getElementById('filtroMes').value;
  const url = `api.php?estado=${estado}&mes=${mes}`;
  window.open(url, '_blank');
}

