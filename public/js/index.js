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
  if (data.token) {
    alert('Login exitoso. Token generado.');
    localStorage.setItem('token', data.token);
  } else {
    alert(data.message || 'Credenciales inválidas');
  }
});