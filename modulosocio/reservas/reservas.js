document.addEventListener('DOMContentLoaded', () => {
  cargarInstalaciones();
  cargarReservas();

  document.getElementById('formReserva').addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);
    datos.append('id_usuario', usuarioId);

    fetch('api.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      e.target.reset();
      cargarReservas();
    });
  });
});

function cargarInstalaciones() {
  fetch('api.php?instalaciones=1')
    .then(res => res.json())
    .then(data => {
      const select = document.querySelector('select[name="instalacion"]');
      select.innerHTML = '';
      data.forEach(inst => {
        select.innerHTML += `<option value="${inst.ID}">${inst.Nombre}</option>`;
      });
    });
}

function cargarReservas() {
  fetch(`api.php?id=${usuarioId}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoReservas');
      tbody.innerHTML = '';
      data.forEach((r, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${r.instalacion}</td>
            <td>${r.fecha}</td>
            <td>${r.Hora_inicio}</td>
            <td>${r.Hora_fin}</td>
            <td><button onclick="cancelarReserva(${r.id})">Cancelar</button></td>
          </tr>
        `;
      });
    });
}

function cancelarReserva(id) {
  if (!confirm('¿Cancelar esta reserva?')) return;

  fetch(`api.php?id=${id}`, { method: 'DELETE' })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarReservas();
    });
}

