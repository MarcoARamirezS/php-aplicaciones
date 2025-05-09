document.getElementById('loginForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const usuario = document.getElementById('usuario').value;
  const password = document.getElementById('password').value;

  const response = await fetch('http://localhost:8888/php-aplicaciones/backend/index.php/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ usuario, password })
  });

  const data = await response.json();
  console.log("@@@ usuaurio => ", data.data)
  if (data.message === 'success') {
    const usuario = {
      id: data.data.id,
      usuario: data.data.usuario,
      password: data.data.password,
      rol: data.data.rol
    };
    mostrarAlerta('Login exitoso. Usuario guardado.', 'success');
    localStorage.setItem('usuario', JSON.stringify(usuario));
    window.location.href = 'dashboard.html';
  } else {
    mostrarAlerta(data.message || 'Credenciales inválidas', 'danger');
  }
});
