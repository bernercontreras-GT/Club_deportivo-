document.addEventListener('DOMContentLoaded', () => {
  cargarUsuarios();

  document.getElementById('formUsuario').addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);

    fetch('api.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);

      e.target.reset();
      document.getElementById('idusuario').value = '';
      btnGuardar.textContent = 'Registrar';
      titulo.textContent = 'Registrar usuario';

      cargarUsuarios();
    });
  });
});

function cargarUsuarios() {
  fetch('api.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('contenidoUsuarios');
      tbody.innerHTML = '';
      data.forEach((u, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${u.nombre}</td>
            <td>${u.correo}</td>
            <td>${u.rol}</td>
            <td><button onclick="eliminarUsuario(${u.id})">Eliminar</button>
          
            <button onclick="editarUsuario(${u.id}, '${u.nombre}','${u.correo}','${u.clave }', '${u.rol}')">Editar </button>
            </td>
          </tr>
        `;
      });
    });
}

function editarUsuario(id, Nombre, Email, Clave, Rol) {
  document.getElementById('idusuario').value = id;
  document.querySelector('[name="nombre"]').value = Nombre;
  document.querySelector('[name="correo"]').value = Email;
  document.querySelector('[name="clave"]').value = '';
  document.querySelector('[name="rol"]').value = Rol;
  document.getElementById('btnGuardar').textContent = 'Actualizar';
  document.getElementById('tituloFormulario').textContent = 'Editar usuario';
} 


function eliminarUsuario(id) {
  if (!confirm('¿Eliminar este usuario?')) return;

  fetch(`api.php?id=${id}`, { method: 'DELETE' })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarUsuarios();
    });
}

