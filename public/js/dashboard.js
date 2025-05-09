// Verifica que el usuario esté autenticado
const usuario = localStorage.getItem('usuario');
if (!usuario) window.location.href = 'login.html';

const token = localStorage.getItem('token');
const tabla = document.getElementById('tablaUsuarios');
const crearForm = document.getElementById('crearUsuarioForm');
const editarForm = document.getElementById('editarUsuarioForm');

// Cargar usuarios
const cargarUsuarios = async () => {
  try {
    const res = await fetch('/php-aplicaciones/backend/index.php/usuarios');
    const data = await res.json();
    tabla.innerHTML = '';
    data.data.forEach(({ id, usuario, nombre, apaterno, amaterno, rol }) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${usuario}</td>
        <td>${nombre} ${apaterno} ${amaterno}</td>
        <td>${rol}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick='abrirEditar(${JSON.stringify({
            id, usuario, nombre, apaterno, amaterno, rol
          })})'>Editar</button>
          <button class="btn btn-danger btn-sm" onclick="eliminarUsuario('${id}')">Eliminar</button>
        </td>
      `;
      tabla.appendChild(tr);
    });
  } catch (error) {
    console.error('Error al cargar usuarios:', error);
  }
};

// Crear usuario
crearForm.addEventListener('submit', async e => {
  e.preventDefault();
  const formData = new FormData(crearForm);
  const dataObj = Object.fromEntries(formData.entries());

  try {
    const res = await fetch('/php-aplicaciones/backend/index.php/create', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dataObj)
    });
    const data = await res.json();
    mostrarAlerta(data.message || 'Usuario creado', 'success');
    crearForm.reset();
    bootstrap.Modal.getInstance(document.getElementById('crearModal')).hide();
    cargarUsuarios();
  } catch (error) {
    console.error('Error al crear usuario:', error);
  }
});

// Abrir modal de edición
const abrirEditar = ({ id, usuario, nombre, apaterno, amaterno, rol }) => {
  document.getElementById('editNombre').value = nombre;
  document.getElementById('editApaterno').value = apaterno;
  document.getElementById('editAmaterno').value = amaterno;
  document.getElementById('editUsuario').value = usuario;
  document.getElementById('editRol').value = rol;
  
  // Rellenar otros campos si es necesario
  const modalEditar = new bootstrap.Modal(document.getElementById('editarModal'));
  modalEditar.show();

  // Manejar la edición
  editarForm.onsubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData(editarForm);
    const dataObj = Object.fromEntries(formData.entries());
    try {
      const res = await fetch(`/php-aplicaciones/backend/index.php/usuario/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataObj)
      });
      const data = await res.json();
      mostrarAlerta(data.message || 'Usuario actualizado', 'success');
      cargarUsuarios();
      bootstrap.Modal.getInstance(document.getElementById('editarModal')).hide();
    } catch (error) {
      console.error('Error al actualizar usuario:', error);
    }
  };
};

// Eliminar usuario
const eliminarUsuario = async id => {
  const confirmacion = confirm('¿Estás seguro de que deseas eliminar este usuario?');
  if (confirmacion) {
    try {
      const res = await fetch(`/php-aplicaciones/backend/index.php/usuario/${id}`, {
        method: 'DELETE'
      });
      const data = await res.json();
      mostrarAlerta(data.message || 'Usuario eliminado', 'success');
      cargarUsuarios();
    } catch (error) {
      console.error('Error al eliminar usuario:', error);
    }
  }
};

cargarUsuarios();
