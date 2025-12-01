document.addEventListener('DOMContentLoaded', () => {
  cargarEventos();
  cargarOpciones();

  document.getElementById('formInscripcion').addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);
    datos.append('id_usuario', usuarioId);

    fetch('api/eventos.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      e.target.reset();
      cargarEventos();
    });
  });
});

function cargarEventos() {
  fetch(`api/eventos.php?id=${usuarioId}`)
    .then(res => res.json())
    .then(data => {
      const contenedor = document.getElementById('calendarioEventos');
      contenedor.innerHTML = '';
      data.forEach(ev => {
        contenedor.innerHTML += `
          <div class="evento">
            <h3>${ev.titulo}</h3>
            <p>${ev.descripcion}</p>
            <span>${ev.fecha} — ${ev.hora}</span>
            <span class="estado">${ev.inscrito ? '✅ Inscrito' : '🕒 Disponible'}</span>
          </div>
        `;
      });
    });
}

function cargarOpciones() {
  fetch('api/eventos.php?listar=1')
    .then(res => res.json())
    .then(data => {
      const select = document.querySelector('select[name="evento"]');
      select.innerHTML = '';
      data.forEach(ev => {
        select.innerHTML += `<option value="${ev.ID}">${ev.Titulo} (${ev.Fecha})</option>`;
      });
    });
}
