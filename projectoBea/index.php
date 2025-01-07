<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <title>Questionario Personal</title>
</head>

<body>

    <div id="pantalla-bienvenida">
        <h1>Bienvenido, pulsa Control + F10 o espera 5 segundos</h1>
    </div>

    <div id="pantalla-login" style="display: none;">
        <form id="form-login">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" required>
            <span id="error-correo" style="color: red; display: none;">Correo incorrecto</span>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>

    <div id="pantalla-bienvenida-usuario" style="display: none;">
        <p id="mensaje-usuario"></p>
        <button id="btn-preguntas">Preguntas</button>
    </div>

    <div id="pantalla-cuestionario" style="display: none;">
        <form id="form-preguntas">
            <label for="pregunta">Pregunta:</label>
            <input type="text" id="pregunta" required>

            <label>Respuesta:</label>
            <input type="radio" name="respuesta" value="verdadero" required> Verdadero
            <input type="radio" name="respuesta" value="falso" required> Falso

            <label for="puntuacion">Puntuación:</label>
            <input type="number" id="puntuacion" min="0" max="9" required>

            <button type="button" id="btn-atras" disabled>Atrás</button>
            <button type="submit" id="btn-grabar">Grabar</button>
        </form>

        <div id="listado-preguntas">
            <p>Cargando preguntas...</p>
            <table>
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Puntuación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tabla-preguntas"></tbody>
            </table>
        </div>
    </div>
    <footer class="footer">
        <div class="Name">
            <span>Jordi Santos Torres</span>
            <img src="/images/footer/fotoJordi.png" alt="Foto mia de ejemplo">
        </div>
        <div class="wrap-footer">
            <div class="rrss">
                <h5>Redes Sociales</h5>
                <ul>
                    <li><a href="https://www.facebook.com">
                            <img src="/images/footer/face.png" alt="Facebook">
                        </a></li>
                    <li><a href="https://www.instagram.com">
                            <img src="/images/footer/insta.png" alt="Instagram">
                        </a></li>
                    <li><a href="https://twitter.com">
                            <img src="/images/footer/x.png" alt="X">
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="footer-creds">
            <div class="copy-creds">
                <p>©2024 · Todos los derechos reservados.</p>
            </div>
            <div class="legal-creds">
                <ul>
                    <li><a href="">Política de Privacidad</a></li>
                    <li><a href="">Política de Cookies</a></li>
                    <li><a href="">Aviso Legal</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="vanilla.js"></script>
</body>

</html>l