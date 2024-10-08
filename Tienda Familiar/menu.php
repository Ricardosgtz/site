<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        /* Resetear márgenes y padding */
        * { 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Estilos del cuerpo */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            overflow: hidden;
        }
        /* Estilos del encabezado */
        header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 1.2s ease-in-out;
        }
        header h1 {
            font-size: 52px;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
        }
        header h2 {
            font-size: 28px;
            font-weight: 300;
            color: #f0f0f0;
            margin-top: 10px;
        }

        /* Animaciones */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleUp {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Contenedor del menú */
        .menu-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        /* Estilos del menú de botones */
        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1000px;
            padding: 30px;
            width: 100%;
            animation: fadeInUp 1.5s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu a {
            text-decoration: none;
            color: white;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            padding: 20px 40px;
            border-radius: 50px;
            text-align: center;
            font-size: 22px;
            font-weight: 500;
            transition: all 0.4s ease;
            box-shadow: 0px 15px 30px rgba(0, 123, 255, 0.3);
            animation: scaleUp 0.7s ease forwards;
            position: relative;
            overflow: hidden;
        }

        .menu a::before {
            content: '';
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transition: top 0.4s ease;
        }

        .menu a:hover::before {
            top: 0;
        }

        .menu a:hover {
            transform: translateY(-10px);
            box-shadow: 0px 20px 40px rgba(0, 123, 255, 0.5);
        }

        /* Botón de "Salir" estilizado */
        .menu a.logout {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            grid-column: 1 / -1;
            font-size: 20px;
            font-weight: 600;
        }
        .menu a.logout:hover {
            box-shadow: 0px 20px 40px rgba(255, 75, 43, 0.5);
        }

        /* Pie de página */
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #fff;
            animation: fadeInUp 2s ease-in-out;
        }
        .footer a {
            color: #fff;
            text-decoration: underline;
        }
        .footer a:hover {
            text-decoration: none;
        }
    </style>
    <!-- Fuentes de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <h1>Abarrotes Atziry</h1>
    <h2>Panel de Gestión</h2>
</header>

<div class="menu-container">
    <div class="menu">
        <a href="productos.php">Productos</a>
        <a href="ventas.php">Ventas</a>
        <a href="clientes.php">Clientes</a>
        <a href="Usuarios.php">Usuarios</a>
        <a href="proveedores.php">Proveedores</a>
        <a href="historial.php">Historial</a>
        <!-- Botón "Salir" -->
        <a href="InicioSecion.php" class="logout">Salir</a>
    </div>
    <div class="footer">
        <p>© 2024 Abarrotes Atziry | <a href="#">Política de Privacidad</a></p>
    </div>
</div>

</body>
</html>
