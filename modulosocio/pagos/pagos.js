document.addEventListener('DOMContentLoaded', () => {
  fetch(`api.php?id=${usuarioId}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoPagos');
      tbody.innerHTML = '';
      data.forEach((pago, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${pago.membresia}</td>
            <td>Q${pago.monto}</td>
            <td>${pago.fecha}</td>
            <td class="${pago.estado.toLowerCase()}">${pago.estado}</td>
          </tr>
        `;
      });
    });
});


