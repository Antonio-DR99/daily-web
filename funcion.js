// Elementos del modal
const modal = document.getElementById('miModal');
const imgModal = document.getElementById('imagenModal');
const btnAnterior = document.getElementById('btnAnterior');
const btnSiguiente = document.getElementById('btnSiguiente');

// Guardamos todas las imágenes
const imagenes = document.querySelectorAll('.imagen');
let indiceActual = 0;

// Abrir modal
function abrirModal(src) {
    modal.style.display = 'flex';
    imgModal.src = src;
    // Guardar el índice de la imagen clicada
    for (let i = 0; i < imagenes.length; i++) {
        if (imagenes[i].src === src) {
            indiceActual = i;
            break; // una vez encontrado, no hace falta seguir recorriendo
        }   
    }
}

// Cerrar modal
function cerrarModal() {
    modal.style.display = 'none';
}

// Cerrar al clicar fuera
window.onclick = function(event) {
    if (event.target === modal) cerrarModal();
}

// Botones de navegación
btnAnterior.addEventListener('click', function() {
    indiceActual = indiceActual - 1;
    if (indiceActual < 0) {
        indiceActual = imagenes.length - 1; // vuelve a la última imagen
    }
    imgModal.src = imagenes[indiceActual].src;
});

btnSiguiente.addEventListener('click', function() {
    indiceActual = indiceActual + 1;
    if (indiceActual >= imagenes.length) {
        indiceActual = 0; // vuelve a la primera imagen
    }
    imgModal.src = imagenes[indiceActual].src;
});

// Botón y tbody de la tabla
const toggleBtn = document.getElementById('toggleCanciones');
const cuerpo = document.getElementById('cuerpoCanciones');

// Función para mostrar u ocultar las canciones
toggleBtn.addEventListener('click', () => {
    if (cuerpo.style.display === 'none') {
        // Mostrar canciones
        cuerpo.style.display = 'table-row-group';
        toggleBtn.textContent = 'Retraer';
    } else {
        // Ocultar canciones
        cuerpo.style.display = 'none';
        toggleBtn.textContent = 'Desplegar';
    }
});