document.getElementById('registerForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const data = {
    nombre: document.getElementById('nombre').value,
    apaterno: document.getElementById('apaterno').value,
    amaterno: document.getElementById('amaterno').value,
    direccion: document.getElementById('direccion').value,
    telefono: document.getElementById('telefono').value,
    ciudad: document.getElementById('ciudad').value,
    estado: document.getElementById('estado').value,
    usuario: document.getElementById('usuario').value,
    password: document.getElementById('password').value,
    rol: document.getElementById('rol').value
  };

  const response = await fetch('http://localhost:8888/php-aplicaciones/backend/index.php/create', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });

  const result = await response.json();
  if (result.message === 'success' && result.data === 'Usuario creado exitosamente') {
    mostrarAlerta('Usuario creado correctamente. Ahora puedes iniciar sesión.', 'success');
    window.location.href = "index.html";
  } else {
    mostrarAlerta(result.message || 'Error al registrar usuario.', 'danger');
  }
});
