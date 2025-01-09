/**
 * @file pantalla-cuestionario.js
 * @description Gestiona la pantalla de cuestionarios y las preguntas.
 */

document.addEventListener("DOMContentLoaded", () => {
  const btnPreguntas = document.getElementById("btn-preguntas");

  if (btnPreguntas) {
      btnPreguntas.addEventListener("click", cargarPantallaCuestionario);
  }

  cargarPreguntas(true);
});

/**
* Carga la pantalla de cuestionarios y muestra las preguntas.
*/
function cargarPantallaCuestionario() {
  const pantallaUsuario = document.getElementById("pantalla-bienvenida-usuario");
  const pantallaCuestionario = document.getElementById("pantalla-cuestionario");

  if (pantallaUsuario) pantallaUsuario.style.display = "none";
  if (pantallaCuestionario) pantallaCuestionario.style.display = "block";

  cargarPreguntas(true);
}

/**
* Carga las preguntas almacenadas desde las cookies.
* @param {boolean} [conRetraso=false] - Indica si se debe esperar 5 segundos antes de cargar las preguntas.
*/
function cargarPreguntas(conRetraso = false) {
  const tablaPreguntas = document.getElementById("tabla-preguntas");
  const listadoPreguntas = document.getElementById("listado-preguntas");

  if (conRetraso) {
      listadoPreguntas.innerHTML = "<p>Cargando preguntas...</p>";
      setTimeout(() => {
          const preguntasCookie = leerCookie("preguntas");
          const preguntas = preguntasCookie ? JSON.parse(preguntasCookie) : [];
          if (tablaPreguntas) {
              tablaPreguntas.innerHTML = ""; // Limpiar la tabla
              preguntas.forEach(({ pregunta, respuesta, puntuacion, estado }) => {
                  const fila = document.createElement("tr");
                  fila.innerHTML = `
                      <td>${pregunta}</td>
                      <td>${respuesta}</td>
                      <td>${puntuacion}</td>
                      <td>${estado}</td>
                  `;
                  tablaPreguntas.appendChild(fila);
              });
          }
          // Ocultar el mensaje de 'Cargando preguntas...'
          listadoPreguntas.querySelector("p").style.display = "none";
      }, 5000);
  } else {
      const preguntasCookie = leerCookie("preguntas");
      const preguntas = preguntasCookie ? JSON.parse(preguntasCookie) : [];
      if (tablaPreguntas) {
          tablaPreguntas.innerHTML = ""; // Limpiar la tabla
          preguntas.forEach(({ pregunta, respuesta, puntuacion, estado }) => {
              const fila = document.createElement("tr");
              fila.innerHTML = `
                  <td>${pregunta}</td>
                  <td>${respuesta}</td>
                  <td>${puntuacion}</td>
                  <td>${estado}</td>
              `;
              tablaPreguntas.appendChild(fila);
          });
      }
      // Ocultar el mensaje de 'Cargando preguntas...'
      listadoPreguntas.querySelector("p").style.display = "none";
  }
}

/**
* Lee una cookie por su nombre.
* 
* @param {string} nombre - El nombre de la cookie a leer.
* @returns {string|null} El valor de la cookie o null si no existe.
*/
function leerCookie(nombre) {
  const cookies = document.cookie.split("; ");
  const cookie = cookies.find((c) => c.startsWith(`${nombre}=`));
  return cookie ? decodeURIComponent(cookie.split("=")[1]) : null;
}

/**
 * Guarda una nueva pregunta en las cookies.
 *
 * Simula un retraso de 5 segundos para replicar la experiencia de grabar en un servidor.
 *
 * @param {string} pregunta - La pregunta ingresada por el usuario.
 * @param {string} respuesta - La respuesta seleccionada (verdadero/falso).
 * @param {number} puntuacion - La puntuación asignada a la pregunta.
 * @returns {Promise<boolean>} - Promesa que se resuelve cuando se guarda la pregunta.
 */
async function grabarPregunta(pregunta, respuesta, puntuacion) {
  return new Promise((resolve) => {
    setTimeout(() => {
      try {
        const preguntasCookie = leerCookie("preguntas");
        const preguntas = preguntasCookie ? JSON.parse(preguntasCookie) : [];
        preguntas.push({ pregunta, respuesta, puntuacion, estado: "OK" });
        document.cookie = `preguntas=${encodeURIComponent(JSON.stringify(preguntas))}; path=/; max-age=${7 * 24 * 60 * 60}`;
        resolve(true);
      } catch (error) {
        resolve(false);
      }
    }, 5000);
  });
}

/**
 * Gestiona el envío del formulario de preguntas.
 * Guarda una nueva pregunta en cookies y la muestra en la tabla.
 *
 * @param {Event} event - Evento de envío del formulario.
 */
document
  .getElementById("form-preguntas")
  .addEventListener("submit", async function (event) {
    event.preventDefault();
    const pregunta = document.getElementById("pregunta").value;
    const respuesta = document.querySelector(
      "input[name='respuesta']:checked"
    ).value;
    const puntuacion = document.getElementById("puntuacion").value;

    const fila = document.createElement("tr");
    fila.innerHTML = `<td>${pregunta}</td><td>${respuesta}</td><td>${puntuacion}</td><td>Guardando...</td>`;
    document.getElementById("tabla-preguntas").appendChild(fila);

    await grabarPregunta(pregunta, respuesta, puntuacion);
    fila.lastChild.textContent = "OK";
    document.getElementById("btn-atras").disabled = false;
  });

document.getElementById("btn-atras").addEventListener("click", () => {
  window.location.href = "pantalla2.html";
});
