document.addEventListener('DOMContentLoaded', () => {
  cargarConfiguracion();

  document.getElementById('formConfig').addEventListener('submit', e => {
    e.preventDefault();
    const datos = new FormData(e.target);

    fetch('api.php', {
      method: 'POST',
      body: datos
    })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarConfiguracion();
    });
  });
});

function cargarConfiguracion() {
  fetch('api.php')
    .then(res => res.json())
    .then(data => {
      const form = document.getElementById('formConfig');
      form.nombre_club.value = data.nombre_club || '';
      form.moneda.value = data.moneda || '';
      form.horario.value = data.horario || '';

      const preview = document.getElementById('previewLogo');
      if (data.logo) {
        preview.innerHTML = `<p>Logo actual:</p><img src="../../${data.logo}" alt="Logo" style="height:60px;">`;
      } else {
        preview.innerHTML = '';
      }
    });
}

