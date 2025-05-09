// Función para mostrar alertas con Bootstrap (ES6)
const mostrarAlerta = (message, tipo = 'success') => {
  const alerta = document.createElement('div');
  alerta.classList.add('alert', `alert-${tipo}`, 'alert-dismissible', 'fade', 'show');
  alerta.setAttribute('role', 'alert');

  alerta.innerHTML = `
    <strong>${message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  `;

  // Insertar la alerta en el contenedor de alertas
  const contenedorAlertas = document.getElementById('contenedorAlertas');
  contenedorAlertas.appendChild(alerta);

  // Eliminar la alerta después de 5 segundos
  setTimeout(() => alerta.remove(), 5000);
};
