document.addEventListener('DOMContentLoaded', () => {
  cargarMembresias();

const form = document.getElementById('formMembresia');
const BTNGuardar = document.getElementById('BTNGuardar');
const titulo = document.getElementById('Tituloformulario')

  form.addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);

    fetch('api.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);

      form.reset();
      document.getElementById('idmembresia').value = '';
      BTNGuardar.textContent = 'Registrar';
      titulo.textContent = 'Crear membresia';

      cargarMembresias();
    });
  });
});

function cargarMembresias() {
  fetch('api.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoMembresias');
      tbody.innerHTML = '';
      data.forEach((m, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${m.nombre}</td>
            <td>${m.descripcion}</td>
            <td>Q${m.precio}</td>
            <td>
            <button onclick="editarMembresia(${m.id},'${m.nombre}', '${m.descripcion}','${m.precio}')">Editar Membresia</button>
            <button onclick="eliminarMembresia(${m.id})">Eliminar</button>
            </td>
          </tr>
        `;
      });
    });
}

function editarMembresia(id, nombre, descripcion, precio){
  document.getElementById('idmembresia').value = id;
  document.querySelector('[name ="nombre"]').value = nombre;
  document.querySelector('[name = "descripcion"]').value = descripcion;
  document.querySelector('[name = "precio"]').value = precio ;
  document.getElementById('BTNGuardar').textContent = "Actualizar";
  document.getElementById('Tituloformulario').textContent = "Editar Membresia";

}



function eliminarMembresia(id) {
  if (!confirm('¿Eliminar esta membresía?')) return;

  fetch(`api.php?id=${id}`, { method: 'DELETE' })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarMembresias();
    });
}


