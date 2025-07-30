// Muestra el overlay con el mensaje y luego ejecuta un callback
function mostrarOverlaySesion(mensaje, callback) {
  let overlay = document.getElementById('sesion-overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'sesion-overlay';
    overlay.className = 'sesion-overlay';
    overlay.innerHTML = `<div class=\"spinner\"></div><span class=\"sesion-msg\"></span>`;
    document.body.appendChild(overlay);
  }
  overlay.querySelector('.sesion-msg').textContent = mensaje;
  overlay.classList.add('active');
  setTimeout(() => {
    overlay.classList.remove('active');
    if (typeof callback === 'function') callback();
  }, 2000);
} 