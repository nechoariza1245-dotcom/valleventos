<?php
// Configuración del evento
$evento = [
    'nombre' => 'Gran Toque Vallenato',
    'subtitulo' => 'La Noche de Parranda más Esperada del Año',
    'fecha' => 'Sábado 21 de Noviembre de 2026',
    'hora' => '9:00 PM',
    'lugar' => 'Discoteca Matilde Lina',
    'direccion' => 'Calle 81 #12-96, Bogotá, Colombia',
    'empresa' => 'VALLEVENTOS',
    'contacto' => 'Juan Arevalo- Coordinador',
    'email' => 'asesoravalemonda@gmail.com',
    'telefono' => '+57 310 555 1234'
];

$tickets = [
    [
        'tipo' => 'General',
        'precio' => 65000,
        'descripcion' => 'Acceso general al evento. Vive la parranda desde el corazón de la discoteca.',
        'disponibles' => true
    ],
    [
        'tipo' => 'Preferencial',
        'precio' => 95000,
        'descripcion' => 'Zona preferencial más cerca de la tarima. Mejor visión y ambiente.',
        'disponibles' => true
    ],
    [
        'tipo' => 'VIP Mesa',
        'precio' => 350000,
        'descripcion' => 'Mesa VIP para 4 personas. Incluye botella de cortesía y atención personalizada.',
        'disponibles' => true
    ]
];

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $telefono = htmlspecialchars($_POST['telefono'] ?? '');
    $tipo_ticket = htmlspecialchars($_POST['tipo_ticket'] ?? '');
    $cantidad = intval($_POST['cantidad'] ?? 1);
    
    if ($nombre && $email && $tipo_ticket && $cantidad > 0) {
        $precio_unitario = 0;
        foreach ($tickets as $t) {
            if ($t['tipo'] === $tipo_ticket) {
                $precio_unitario = $t['precio'];
                break;
            }
        }
        $total = $precio_unitario * $cantidad;
        
        $mensaje = "¡Gracias $nombre! Tu solicitud de compra ha sido recibida. Tipo: $tipo_ticket x $cantidad. Total: $" . number_format($total, 0, ',', '.') . " COP. Te contactaremos pronto a $email para confirmar el pago y enviar tus entradas digitales.";
        $tipo_mensaje = 'success';
        
        // Aquí normalmente se enviaría un email o se guardaría en BD
        // mail($evento['email'], "Nueva compra - $evento[nombre]", "Cliente: $nombre\nEmail: $email\nTel: $telefono\nTicket: $tipo_ticket x $cantidad\nTotal: $total");
    } else {
        $mensaje = "Por favor completa todos los campos requeridos.";
        $tipo_mensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $evento['nombre']; ?> | <?php echo $evento['empresa']; ?> - Venta de Entradas</title>
    <meta name="description" content="Compra tus entradas para el Gran Toque Vallenato en Discoteca Matilde Lina, Bogotá. Organizado por VALLEVENTOS. ¡No te pierdas la mejor parranda!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #c8102e;
            --secondary: #ffd100;
            --accent: #003893;
            --dark: #1a1a1a;
            --light: #f8f9fa;
            --green: #00843d;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background: #fff;
        }
        header {
            background: rgba(0,0,0,0.95);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: white;
        }
        .logo img { height: 60px; }
        .logo-text { font-size: 1.5rem; font-weight: 800; letter-spacing: 1px; }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: 600;
            transition: color 0.3s;
        }
        nav a:hover { color: var(--secondary); }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('concert.jpg') center/cover no-repeat;
            height: 90vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }
        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
        }
        .hero-content .subtitle {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--secondary);
            font-weight: 600;
        }
        .event-meta {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            background: rgba(0,0,0,0.5);
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(200,16,46,0.4);
        }
        .btn:hover { background: #a00d24; transform: translateY(-2px); }
        .btn-secondary { background: var(--secondary); color: var(--dark); }
        .btn-secondary:hover { background: #e6bc00; }
        section { padding: 80px 0; }
        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        .section-subtitle { text-align: center; font-size: 1.1rem; color: #666; margin-bottom: 3rem; }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        .about-grid img { width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 2rem;
        }
        .ticket-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border: 3px solid transparent;
        }
        .ticket-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        .ticket-header {
            background: linear-gradient(135deg, var(--primary), #8b0a1e);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .ticket-header h3 { font-size: 1.5rem; margin-bottom: 10px; }
        .ticket-price { font-size: 2.2rem; font-weight: 800; }
        .ticket-body { padding: 25px; }
        .ticket-body p { margin-bottom: 20px; color: #555; }
        .form-compra {
            background: var(--light);
            padding: 40px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .venue-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }
        .venue-info img { width: 100%; border-radius: 15px; }
        .map-container { border-radius: 15px; overflow: hidden; height: 400px; }
        .map-container iframe { width: 100%; height: 100%; border: 0; }
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-grid h3 { margin-bottom: 20px; color: var(--secondary); }
        .footer-grid a { color: #ccc; text-decoration: none; display: block; margin-bottom: 10px; }
        .footer-grid a:hover { color: white; }
        .copyright { text-align: center; padding-top: 30px; border-top: 1px solid #333; color: #888; }
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.5rem; }
            .about-grid, .venue-info { grid-template-columns: 1fr; }
            nav { display: none; }
            .header-content { justify-content: center; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <a href="#" class="logo">
                <img src="logo.jpg" alt="VALLEVENTOS Logo">
                <span class="logo-text">VALLEVENTOS</span>
            </a>
            <nav>
                <a href="#evento">El Evento</a>
                <a href="#entradas">Entradas</a>
                <a href="#lugar">Lugar</a>
                <a href="#contacto">Contacto</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <h1><?php echo $evento['nombre']; ?></h1>
            <p class="subtitle"><?php echo $evento['subtitulo']; ?></p>
            <div class="event-meta">
                <i class="fas fa-calendar-alt"></i> <?php echo $evento['fecha']; ?> &nbsp;|&nbsp;
                <i class="fas fa-clock"></i> <?php echo $evento['hora']; ?> &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt"></i> <?php echo $evento['lugar']; ?>
            </div>
            <br>
            <a href="#entradas" class="btn">COMPRAR ENTRADAS AHORA</a>
        </div>
    </section>

    <section id="evento">
        <div class="container">
            <h2>El Gran Toque Vallenato</h2>
            <p class="section-subtitle">Organizado por <?php echo $evento['empresa']; ?> en el templo del vallenato en Bogotá</p>
            <div class="about-grid">
                <div>
                    <img src="concert.jpg" alt="Toque Vallenato en vivo">
                </div>
                <div>
                    <h3 style="font-size: 1.8rem; margin-bottom: 20px; color: var(--accent);">Una noche inolvidable de parranda</h3>
                    <p style="margin-bottom: 15px;">VALLEVENTOS te invita a vivir la auténtica esencia del vallenato en el corazón de Bogotá. El Gran Toque Vallenato reúne a los mejores exponentes del género para una noche de música en vivo, baile y alegría costeña.</p>
                    <p style="margin-bottom: 15px;">En la mítica Discoteca Matilde Lina, conocida como el templo del vallenato en la capital, disfrutarás de acordeones, cajas, guitarras y las voces que hacen vibrar el alma.</p>
                    <p style="margin-bottom: 15px;"><strong>Artistas confirmados:</strong> Acordeonistas de primera línea, grupos de vallenato tradicional y moderno, y juglares invitados especiales del panorama nacional.</p>
                    <p>¡Prepárate para cantar a grito herido y bailar hasta el amanecer!</p>
                </div>
            </div>
        </div>
    </section>

    <section id="entradas" style="background: #f8f9fa;">
        <div class="container">
            <h2>Compra tus Entradas</h2>
            <p class="section-subtitle">Venta oficial de entradas para el evento. Organizado y comercializado por VALLEVENTOS.</p>
            
            <?php if ($mensaje): ?>
                <div class="alert <?php echo $tipo_mensaje; ?>"><?php echo $mensaje; ?></div>
            <?php endif; ?>

            <div class="tickets-grid">
                <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-card">
                    <div class="ticket-header">
                        <h3><?php echo $ticket['tipo']; ?></h3>
                        <div class="ticket-price">$<?php echo number_format($ticket['precio'], 0, ',', '.'); ?></div>
                    </div>
                    <div class="ticket-body">
                        <p><?php echo $ticket['descripcion']; ?></p>
                        <a href="#formulario" class="btn" style="width: 100%; text-align: center;">Seleccionar</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="form-compra" id="formulario">
                <h3 style="text-align: center; margin-bottom: 25px; font-size: 1.8rem;">Formulario de Compra de Entradas</h3>
                <form method="POST" action="#formulario">
                    <div class="form-group">
                        <label for="nombre">Nombre completo *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico *</label>
                        <input type="email" id="email" name="email" required placeholder="tu@email.com">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono / WhatsApp</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="+57 300 000 0000">
                    </div>
                    <div class="form-group">
                        <label for="tipo_ticket">Tipo de entrada *</label>
                        <select id="tipo_ticket" name="tipo_ticket" required>
                            <option value="">Selecciona una opción</option>
                            <?php foreach ($tickets as $ticket): ?>
                            <option value="<?php echo $ticket['tipo']; ?>"><?php echo $ticket['tipo']; ?> - $<?php echo number_format($ticket['precio'], 0, ',', '.'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad *</label>
                        <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="1" required>
                    </div>
                    <button type="submit" name="comprar" class="btn" style="width: 100%; padding: 18px;">SOLICITAR COMPRA DE ENTRADAS</button>
                    <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #666;">
                        Al solicitar, aceptas los <a href="#terminos" style="color: var(--primary);">Términos y Condiciones</a> y la <a href="#privacidad" style="color: var(--primary);">Política de Privacidad</a> de VALLEVENTOS.
                    </p>
                </form>
            </div>
        </div>
    </section>

    <section id="lugar">
        <div class="container">
            <h2>El Lugar</h2>
            <p class="section-subtitle">Discoteca Matilde Lina - El Templo del Vallenato en Bogotá</p>
            <div class="venue-info">
                <div>
                    <img src="venue.jpg" alt="Discoteca Matilde Lina">
                    <h3 style="margin-top: 20px; font-size: 1.6rem;">Matilde Lina</h3>
                    <p style="margin: 15px 0;"><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> <?php echo $evento['direccion']; ?></p>
                    <p>La auténtica experiencia parrandera con música vallenata en vivo. Un espacio icónico donde se vive la costa caribeña en el corazón de la capital.</p>
                </div>
                <div>
                    <div class="map-container">
                        <iframe src="https://maps.google.com/maps?q=Calle%2081%20%2312-96%20Bogot%C3%A1&t=&z=16&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: #666;">Ubicación aproximada. Confirma la dirección exacta al llegar.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="empresa" style="background: #f8f9fa;">
        <div class="container" style="text-align: center; max-width: 800px;">
            <h2>Sobre VALLEVENTOS</h2>
            <p style="font-size: 1.1rem; margin-bottom: 20px;">VALLEVENTOS es una empresa promotora de eventos especializada en la organización y comercialización de espectáculos de música vallenata y folclórica colombiana.</p>
            <p>Como <strong>proveedor principal</strong> de este evento, nos encargamos de la producción, la venta inicial de las entradas y la experiencia completa para nuestros asistentes. Trabajamos directamente con los artistas y venues para ofrecerte los mejores toques y parrandas.</p>
            <p style="margin-top: 20px;"><strong>Contacto:</strong> <?php echo $evento['contacto']; ?> | <?php echo $evento['email']; ?> | <?php echo $evento['telefono']; ?></p>
        </div>
    </section>

    <section id="legal" style="background: #fff; padding: 40px 0;">
        <div class="container" style="max-width: 900px;">
            <h2 id="terminos">Términos y Condiciones de Venta</h2>
            <p>Las entradas para el Gran Toque Vallenato son vendidas exclusivamente por VALLEVENTOS, empresa promotora y organizadora del evento (Proveedor Principal). Al realizar la compra o solicitud, el comprador acepta:</p>
            <ul style="margin: 15px 0 15px 30px;">
                <li>Las entradas son personales, intransferibles y solo válidas para la fecha y hora del evento.</li>
                <li>No se permiten reembolsos salvo cancelación del evento por parte del organizador.</li>
                <li>El acceso está sujeto a la disponibilidad y políticas del venue Discoteca Matilde Lina.</li>
                <li>VALLEVENTOS se reserva el derecho de admisión y de modificar el line-up por causas de fuerza mayor.</li>
                <li>El comprador es responsable de presentar identificación válida el día del evento.</li>
            </ul>
            
            <h2 id="privacidad" style="margin-top: 40px;">Política de Privacidad</h2>
            <p>VALLEVENTOS recopila los datos personales (nombre, email, teléfono) únicamente para procesar la venta de entradas, confirmar la asistencia y comunicarse con los compradores sobre el evento. No compartimos tus datos con terceros con fines comerciales. Puedes solicitar la eliminación de tus datos escribiendo a <?php echo $evento['email']; ?>.</p>
            
            <h2 id="reembolsos" style="margin-top: 40px;">Política de Reembolsos</h2>
            <p>Las compras de entradas son finales. En caso de cancelación total del evento por VALLEVENTOS, se realizará el reembolso completo. No se aceptan cambios de fecha ni transferencias sin autorización previa.</p>
        </div>
    </section>

    <footer id="contacto">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h3>VALLEVENTOS</h3>
                    <p>Promotora de eventos vallenatos y espectáculos en vivo.</p>
                    <p style="margin-top: 15px;"><i class="fas fa-envelope"></i> <?php echo $evento['email']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $evento['telefono']; ?></p>
                </div>
                <div>
                    <h3>Evento</h3>
                    <p><?php echo $evento['nombre']; ?></p>
                    <p><?php echo $evento['fecha']; ?> - <?php echo $evento['hora']; ?></p>
                    <p><?php echo $evento['lugar']; ?></p>
                    <p><?php echo $evento['direccion']; ?></p>
                </div>
                <div>
                    <h3>Legal</h3>
                    <a href="#terminos">Términos y Condiciones de Venta</a>
                    <a href="#privacidad">Política de Privacidad</a>
                    <a href="#reembolsos">Política de Reembolsos</a>
                    <p style="margin-top: 15px; font-size: 0.9rem;">Las entradas son personales e intransferibles. VALLEVENTOS es el organizador oficial del evento.</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> VALLEVENTOS. Todos los derechos reservados. Venta oficial de entradas para <?php echo $evento['nombre']; ?>.</p>
                <p style="margin-top: 10px; font-size: 0.85rem;">Esta página es el sitio oficial de venta de entradas del evento organizado por VALLEVENTOS.</p>
            </div>
        </div>
    </footer>

    <!-- Secciones legales simples -->
    <div id="terminos" style="display:none;"></div>
    <div id="privacidad" style="display:none;"></div>
</body>
</html>
