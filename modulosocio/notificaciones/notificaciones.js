document.addEventListener('DOMContentLoaded', () => {
  fetch(`api.php?id=${usuarioId}`)
    .then(res => res.json())
    .then(data => {
      const contenedor = document.getElementById('contenedorNotificaciones');
      contenedor.innerHTML = '';

      if (data.length === 0) {
        contenedor.innerHTML = '<p>No tienes notificaciones por el momento.</p>';
        return;
      }

      data.forEach(n => {
        contenedor.innerHTML += `
          <div class="notificacion">
            <h3>${n.asunto}</h3>
            <p>${n.mensaje}</p>
            <span class="fecha">${n.fecha}</span>
          </div>
        `;
      });
    });
});
