document.addEventListener("keydown", function (event) {
  if (event.ctrlKey && event.key === "F10") {
    cargarLogin();
  }
});

setTimeout(cargarLogin, 5000);

function cargarLogin() {
  document.getElementById("pantalla-bienvenida").style.display = "none";
  mostrarLogin();
}

function mostrarLogin() {
    const loginDiv = document.getElementById("pantalla-login");
    loginDiv.style.display = "block";
}

document.getElementById("correo").addEventListener("blur", function () {
  const correo = this.value;
  const regex = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;

  if (!regex.test(correo)) {
    document.getElementById("error-correo").style.display = "inline";
    this.select();
  } else {
    document.getElementById("error-correo").style.display = "none";
  }
});

document
  .getElementById("form-login")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const correo = document.getElementById("correo").value;
    localStorage.setItem("usuario", correo);
    localStorage.setItem("ultimaEntrada", new Date().toISOString());
    cargarPantalla2();
  });

function cargarPantalla2() {
  document.getElementById("pantalla-login").style.display = "none";
  const usuario = localStorage.getItem("usuario");
  const ultimaEntrada = new Date(localStorage.getItem("ultimaEntrada"));

  const opcionesFecha = {
    year: "numeric",
    month: "short",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  };
  document.getElementById(
    "mensaje-usuario"
  ).textContent = `Hola ${usuario}, la última vez que entraste fue el ${ultimaEntrada.toLocaleDateString(
    "es-ES",
    opcionesFecha
  )}`;

  document.getElementById("pantalla-bienvenida-usuario").style.display =
    "block";

  document
    .getElementById("btn-preguntas")
    .addEventListener("click", cargarPantalla3);
}

async function grabarPregunta(pregunta, respuesta, puntuacion) {
  return new Promise((resolve) => {
    setTimeout(() => {
      const preguntas = JSON.parse(localStorage.getItem("preguntas")) || [];
      preguntas.push({ pregunta, respuesta, puntuacion, estado: "OK" });
      localStorage.setItem("preguntas", JSON.stringify(preguntas));
      resolve(true);
    }, 5000);
  });
}

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

  function cargarPantalla3() {
    document.getElementById("pantalla-bienvenida-usuario").style.display = "none";
    const pantallaCuestionario = document.getElementById("pantalla-cuestionario");
    pantallaCuestionario.style.display = "block";

    // Mostrar el texto de 'Cargando preguntas...'
    const listadoPreguntas = document.getElementById("listado-preguntas");
    listadoPreguntas.querySelector("p").style.display = "block";

    // Llamar a la función que carga las preguntas con un retraso de 5 segundos
    cargarPreguntas(true);
}

function cargarPreguntas(conRetraso = false) {
    if (conRetraso) {
        setTimeout(() => {
            actualizarListadoPreguntas();
        }, 5000);
    } else {
        actualizarListadoPreguntas();
    }
}

function actualizarListadoPreguntas() {
    const preguntas = JSON.parse(localStorage.getItem("preguntas")) || [];
    const tablaPreguntas = document.getElementById("tabla-preguntas");

    tablaPreguntas.innerHTML = ""; // Limpia la tabla

    preguntas.forEach(pregunta => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
            <td>${pregunta.pregunta}</td>
            <td>${pregunta.respuesta}</td>
            <td>${pregunta.puntuacion}</td>
            <td>${pregunta.estado}</td>
        `;
        tablaPreguntas.appendChild(fila);
    });

    // Ocultar el mensaje de 'Cargando preguntas...'
    document.getElementById("listado-preguntas").querySelector("p").style.display = "none";
}