document.addEventListener('DOMContentLoaded', () => {
  cargarInstalaciones();

const form= document.getElementById('formInstalacion');
const BTNGuardar = document.getElementById('BTNGuardar');
const titulo = document.getElementById('Tituloformulario');

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
      document.getElementById('idinstalacion').value = '';
      BTNGuardar.textContent = 'Registrar';
      titulo.textContent = 'Crear instalaciones';

      cargarInstalaciones();
    });
  });
});


function cargarInstalaciones() {
  fetch('api.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoInstalaciones');
      tbody.innerHTML = '';
      data.forEach((inst, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${inst.nombre}</td>
            <td>${inst.descripcion}</td>
            <td>${inst.capacidad}</td>
            <td><button onclick="eliminarInstalacion(${inst.id})">Eliminar</button>
            <button onclick="editarInstalacion(${inst.id},'${inst.nombre}','${inst.descripcion}',${inst.capacidad})">Editar Instalacion</button>
            </td>
          </tr>
        `;
      });
    });
}

function editarInstalacion(id,nombre,descripcion,capacidad){
  document.getElementById('idinstalacion').value = id;
  document.querySelector('[name="nombre"]').value = nombre;
  document.querySelector('[name="descripcion"]').value = descripcion;
  document.querySelector('[name= "capacidad"]').value = capacidad;
  document.getElementById('BTNGuardar').textContent = 'Actualizar';
  document.getElementById('Tituloformulario').textContent = 'Editar instalacion';

}


function eliminarInstalacion(id) {
  if (!confirm('¿Eliminar esta instalación?')) return;

  fetch(`api.php?id=${id}`, { method: 'DELETE' })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarInstalaciones();
    });
}

