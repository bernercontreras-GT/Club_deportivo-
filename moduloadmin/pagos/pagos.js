document.addEventListener('DOMContentLoaded', () => {
  cargarPagos();
  cargarSocios();
  cargarMembresias();

  document.getElementById('formPago').addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);

    fetch('api/pagos.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarPagos();
      e.target.reset();
    });
  });

  document.getElementById('filtroEstado').addEventListener('change', cargarPagos);
});



function cargarPagos() {
  const estado = document.getElementById('filtroEstado').value;
  fetch(`api/pagos.php?estado=${estado}`)                            // componer  <-----------------------
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoPagos');
      tbody.innerHTML = '';
      data.forEach((pago, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${pago.socio}</td>
            <td>${pago.membresia}</td>
            <td>${pago.fecha}</td>
            <td>Q${pago.monto}</td>
            <td>${pago.estado}</td>
          </tr>
        `;
      });
    });
}

function cargarSocios() {
  fetch('api/socios.php')
    .then(res => res.json())
    .then(data => {
      
      const select = document.querySelector('select[name="id_socio"]');
      data.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id;
        opt.textContent = `${s.nombre} (#${s.numero_socio})`;
        select.appendChild(opt);
      });
    });
}

function cargarMembresias() {
  fetch('api/membresias.php')
    .then(res => res.json())
    .then(data => {
      const select = document.querySelector('select[name="id_membresia"]');
      data.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = `${m.nombre} - Q${m.precio}`;
        select.appendChild(opt);
      });
    });
}

function generarReporte(tipo) {
  const estado = document.getElementById('filtroEstado').value;
  // Abrir el archivo generado por PHP
  window.open(`api/pagos.php?export=${tipo}&estado=${estado}`, '_blank');
}

