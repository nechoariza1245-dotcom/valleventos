<?php
// Configuración del evento
$evento = [
    'nombre' => 'Gran Toque Vallenato',
    'subtitulo' => 'Venta Oficial de Entradas – Evento en Vivo',
    'fecha' => 'Sábado 21 de Noviembre de 2026',
    'hora' => '9:00 PM',
    'lugar' => 'Discoteca Matilde Lina',
    'direccion' => 'Calle 81 #12-96, Bogotá, Colombia',
    'empresa' => 'VALLEVENTOS',
    'contacto' => 'Cesar Haydar',
    'email' => 'asesoravalemonda@gmail.com',
    'telefono' => '+57 310 555 1234'
];

$tickets = [
    [
        'tipo' => 'General',
        'precio' => 65000,
        'descripcion' => 'Acceso general al evento en vivo. Vive la parranda desde el corazón de la discoteca.',
        'disponibles' => true
    ],
    [
        'tipo' => 'Preferencial',
        'precio' => 95000,
        'descripcion' => 'Zona preferencial más cerca de la tarima. Mejor visión del show en vivo.',
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
        
        $mensaje = "¡Compra registrada, $nombre! Tipo: $tipo_ticket × $cantidad. Total: $" . number_format($total, 0, ',', '.') . " COP. Te contactaremos a $email para confirmar el pago y enviarte tus entradas digitales.";
        $tipo_mensaje = 'success';
    } else {
        $mensaje = "Por favor completa todos los campos requeridos para comprar tus entradas.";
        $tipo_mensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Entradas | Gran Toque Vallenato – VALLEVENTOS</title>
    <meta name="description" content="Compra tus entradas oficiales para el Gran Toque Vallenato en vivo en Discoteca Matilde Lina, Bogotá. Venta oficial por VALLEVENTOS, proveedor principal del evento.">
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
        .logo img { height: 55px; }
        .logo-text { font-size: 1.4rem; font-weight: 800; letter-spacing: 1px; }
        .badge-venta {
            background: var(--primary);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: 600;
            transition: color 0.3s;
        }
        nav a:hover { color: var(--secondary); }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)), url('concert.jpg') center/cover no-repeat;
            min-height: 85vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            padding: 60px 0;
        }
        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
        }
        .hero-content .subtitle {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--secondary);
            font-weight: 700;
        }
        .venta-oficial {
            background: rgba(200,16,46,0.9);
            display: inline-block;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .event-meta {
            font-size: 1.15rem;
            margin-bottom: 2rem;
            background: rgba(0,0,0,0.55);
            display: inline-block;
            padding: 12px 28px;
            border-radius: 50px;
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 16px 42px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.15rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(200,16,46,0.45);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn:hover { background: #a00d24; transform: translateY(-2px); }
        .btn-large { padding: 18px 50px; font-size: 1.25rem; }
        section { padding: 70px 0; }
        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            text-align: center;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        .section-subtitle { text-align: center; font-size: 1.1rem; color: #555; margin-bottom: 2.5rem; }
        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 1.5rem;
        }
        .ticket-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            transition: transform 0.3s;
            border: 3px solid #eee;
        }
        .ticket-card:hover { transform: translateY(-8px); border-color: var(--primary); }
        .ticket-header {
            background: linear-gradient(135deg, var(--primary), #8b0a1e);
            color: white;
            padding: 28px 20px;
            text-align: center;
        }
        .ticket-header h3 { font-size: 1.5rem; margin-bottom: 8px; }
        .ticket-price { font-size: 2.4rem; font-weight: 800; }
        .ticket-body { padding: 22px; text-align: center; }
        .ticket-body p { margin-bottom: 18px; color: #444; }
        .form-compra {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            margin-top: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            border: 2px solid #eee;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 700; }
        .form-group input, .form-group select {
            width: 100%;
            padding: 13px 15px;
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
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .proveedor-box {
            background: #f0f7ff;
            border-left: 5px solid var(--accent);
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .venue-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }
        .venue-info img { width: 100%; border-radius: 15px; }
        .map-container { border-radius: 15px; overflow: hidden; height: 380px; }
        .map-container iframe { width: 100%; height: 100%; border: 0; }
        footer {
            background: var(--dark);
            color: white;
            padding: 50px 0 25px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        .footer-grid h3 { margin-bottom: 15px; color: var(--secondary); }
        .copyright { text-align: center; padding-top: 25px; border-top: 1px solid #333; color: #999; font-size: 0.9rem; }
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.4rem; }
            .venue-info { grid-template-columns: 1fr; }
            nav { display: none; }
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
            <div class="badge-venta">VENTA OFICIAL DE ENTRADAS</div>
            <nav>
                <a href="#entradas">Comprar Entradas</a>
                <a href="#evento">El Evento</a>
                <a href="#lugar">Lugar</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <div class="venta-oficial">VENTA OFICIAL DE ENTRADAS</div>
            <h1><?php echo $evento['nombre']; ?></h1>
            <p class="subtitle"><?php echo $evento['subtitulo']; ?></p>
            <div class="event-meta">
                <i class="fas fa-calendar-alt"></i> <?php echo $evento['fecha']; ?> &nbsp;|&nbsp;
                <i class="fas fa-clock"></i> <?php echo $evento['hora']; ?> &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt"></i> <?php echo $evento['lugar']; ?>
            </div>
            <br>
            <a href="#entradas" class="btn btn-large">COMPRAR ENTRADAS AHORA</a>
            <p style="margin-top: 18px; font-size: 0.95rem; opacity: 0.9;">Evento en vivo · Organizado por VALLEVENTOS (Proveedor Principal)</p>
        </div>
    </section>

    <section id="entradas" style="background: #f8f9fa;">
        <div class="container">
            <h2>Compra tus Entradas</h2>
            <p class="section-subtitle">Venta oficial de entradas para el evento en vivo. VALLEVENTOS es el Proveedor Principal.</p>

            <div class="proveedor-box">
                <strong>VALLEVENTOS – Proveedor Principal</strong><br>
                Somos el organizador y vendedor oficial de las entradas de este evento en vivo. Las entradas se venden de forma directa a través de esta página.
            </div>
            
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
                        <a href="#formulario" class="btn" style="width: 100%; text-align: center;">COMPRAR AHORA</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="form-compra" id="formulario">
                <h3 style="text-align: center; margin-bottom: 8px; font-size: 1.9rem;">Comprar Entradas</h3>
                <p style="text-align: center; color: #666; margin-bottom: 25px;">Completa tus datos para comprar tus entradas al evento en vivo</p>
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
                        <label for="telefono">Teléfono / WhatsApp *</label>
                        <input type="tel" id="telefono" name="telefono" required placeholder="+57 300 000 0000">
                    </div>
                    <div class="form-group">
                        <label for="tipo_ticket">Tipo de entrada *</label>
                        <select id="tipo_ticket" name="tipo_ticket" required>
                            <option value="">Selecciona una opción</option>
                            <?php foreach ($tickets as $ticket): ?>
                            <option value="<?php echo $ticket['tipo']; ?>"><?php echo $ticket['tipo']; ?> – $<?php echo number_format($ticket['precio'], 0, ',', '.'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad *</label>
                        <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="1" required>
                    </div>
                    <button type="submit" name="comprar" class="btn btn-large" style="width: 100%;">CONFIRMAR COMPRA DE ENTRADAS</button>
                    <p style="text-align: center; margin-top: 15px; font-size: 0.85rem; color: #777;">
                        Al comprar, aceptas los <a href="#terminos" style="color: var(--primary);">Términos y Condiciones</a> de VALLEVENTOS.
                    </p>
                </form>
            </div>
        </div>
    </section>

    <section id="evento">
        <div class="container" style="text-align: center; max-width: 800px;">
            <h2>El Evento en Vivo</h2>
            <p style="font-size: 1.1rem; margin: 20px 0;">
                El <strong>Gran Toque Vallenato</strong> es un evento musical en vivo organizado por VALLEVENTOS. 
                Disfrutarás de acordeones, cajas, guitarras y las mejores voces del vallenato en la Discoteca Matilde Lina, 
                el templo del vallenato en Bogotá.
            </p>
            <p>Artistas confirmados: Acordeonistas de primera línea y juglares invitados especiales.</p>
        </div>
    </section>

    <section id="lugar" style="background: #f8f9fa;">
        <div class="container">
            <h2>El Lugar</h2>
            <p class="section-subtitle">Discoteca Matilde Lina – Calle 81 #12-96, Bogotá</p>
            <div class="venue-info">
                <div>
                    <img src="venue.jpg" alt="Discoteca Matilde Lina">
                    <h3 style="margin-top: 18px;">Matilde Lina</h3>
                    <p style="margin: 12px 0;"><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> <?php echo $evento['direccion']; ?></p>
                </div>
                <div>
                    <div class="map-container">
                        <iframe src="https://maps.google.com/maps?q=Calle%2081%20%2312-96%20Bogot%C3%A1&t=&z=16&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h3>VALLEVENTOS</h3>
                    <p>Proveedor principal y organizador del evento. Venta oficial de entradas.</p>
                    <p style="margin-top: 12px;"><i class="fas fa-envelope"></i> <?php echo $evento['email']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $evento['telefono']; ?></p>
                </div>
                <div>
                    <h3>Evento</h3>
                    <p><?php echo $evento['nombre']; ?></p>
                    <p><?php echo $evento['fecha']; ?> · <?php echo $evento['hora']; ?></p>
                    <p><?php echo $evento['lugar']; ?></p>
                </div>
                <div>
                    <h3>Legal</h3>
                    <a href="#terminos" style="color:#ccc;">Términos y Condiciones</a>
                    <a href="#privacidad" style="color:#ccc;">Política de Privacidad</a>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> VALLEVENTOS. Venta oficial de entradas para el Gran Toque Vallenato.</p>
            </div>
        </div>
    </footer>

    <section id="legal" style="background:#fff; padding:40px 0;">
        <div class="container" style="max-width:850px;">
            <h2 id="terminos">Términos y Condiciones de Venta</h2>
            <p>Las entradas son vendidas exclusivamente por VALLEVENTOS como Proveedor Principal del evento. Las entradas son personales, intransferibles y válidas únicamente para la fecha y hora del evento. No se realizan reembolsos salvo cancelación total del evento por parte del organizador.</p>
            
            <h2 id="privacidad" style="margin-top:30px;">Política de Privacidad</h2>
            <p>Los datos se utilizan únicamente para procesar la compra de entradas y la comunicación relacionada con el evento. Puedes solicitar la eliminación de tus datos escribiendo a <?php echo $evento['email']; ?>.</p>
        </div>
    </section>
</body>
</html>
