document.addEventListener('DOMContentLoaded', () => {
  cargarSocios();

  const form = document.getElementById('formSocio');
  const btnGuardar = document.getElementById('btnGuardar');
  const tituloFormulario = document.getElementById('tituloFormulario');

  form.addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(form);
    const id = datos.get('id');

    fetch('api.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarSocios();
      form.reset();
      btnGuardar.textContent = 'Guardar';
      tituloFormulario.textContent = 'Añadir nuevo socio';
    });
  });
});

function cargarSocios() {
  fetch('api.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoTabla');
      tbody.innerHTML = '';
      data.forEach((socio, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${socio.nombre}</td>
            <td>${socio.telefono}</td>
            <td>${socio.direccion}</td>
            <td>${socio.fecha_ingreso}</td>
            <td>${socio.estado}</td>
            <td>
              <button onclick="editarSocio(${socio.id}, '${socio.nombre}', '${socio.telefono}', '${socio.direccion}', '${socio.fecha_ingreso}', ${socio.numero_socio})">Editar</button>
              <button onclick="eliminarSocio(${socio.id})">Eliminar</button>
              
            </td>
          </tr>
        `;
      });
    });
}

function editarSocio(id, nombre, telefono, direccion, fecha, numero) {
  document.getElementById('idSocio').value = id;
  document.querySelector('[name="nombre"]').value = nombre;
  document.querySelector('[name="telefono"]').value = telefono;
  document.querySelector('[name="direccion"]').value = direccion;
  document.querySelector('[name="fecha_ingreso"]').value = fecha;
  document.querySelector('[name="numero_socio"]').value = numero;
  document.getElementById('btnGuardar').textContent = 'Actualizar';
  document.getElementById('tituloFormulario').textContent = 'Editar socio';
}

function eliminarSocio(id) {
  if (confirm('¿Eliminar este socio?')) {
    fetch('api.php?id=' + id, { method: 'DELETE' })
      .then(res => res.json())
      .then(data => {
        alert(data.mensaje);
        cargarSocios();
      });
  }
}
