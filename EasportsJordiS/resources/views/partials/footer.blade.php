<footer class="footer">
    <div class="Name">
        <span>Jordi Santos Torres</span>
        <img src="{{ asset('images/footer/fotoJordi.png') }}" alt="Foto personal">
    </div>
    <div class="wrap-footer">
        <div class="rrss">
            <h5>Redes Sociales</h5>
            <ul>
                <li><a href="https://www.facebook.com"><img src="{{ asset('images/footer/face.png') }}" alt="Facebook"></a></li>
                <li><a href="https://www.instagram.com"><img src="{{ asset('images/footer/insta.png') }}" alt="Instagram"></a></li>
                <li><a href="https://twitter.com"><img src="{{ asset('images/footer/x.png') }}" alt="X"></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-creds">
        <div class="copy-creds">
            <p>©2025 · Todos los derechos reservados.</p>
            <p>Desarrollado por Jordi Santos.</p>
        </div>
        <div class="legal-creds">
            <ul>
                <li><a href="{{ route('privacy') }}">Política de Privacidad</a></li>
                <li><a href="{{ route('terms') }}">Términos y Condiciones</a></li>
                <li><a href="{{ route('contact') }}">Contacto</a></li>
            </ul>
        </div>
    </div>
</footer>

