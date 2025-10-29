<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - DBUN</title>
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --sidebar-bg: #1e3a5f;
            --background-color: #f8fafc;
            --light-text-color: #cbd5e1;
            --card-bg: #ffffff;
            --text-dark: #334155;
            --border-color: #e2e8f0;
            --error-bg: #fee2e2;
            --error-text: #dc2626;
            --error-border: #fecaca;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-page {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* Panel Izquierdo - Bienvenida */
        .welcome-panel {
            flex: 1;
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Decoración de fondo */
        .welcome-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -150px;
            left: -150px;
        }

        .welcome-panel::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            right: -100px;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .logo-container h1 {
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .welcome-panel h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .welcome-panel p {
            font-size: 18px;
            color: var(--light-text-color);
            max-width: 450px;
            line-height: 1.6;
        }

        /* Panel Derecho - Formulario */
        .form-panel {
            flex: 1;
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .card {
            background: var(--card-bg);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            text-align: center;
            margin-bottom: 12px;
            font-size: 32px;
            color: var(--text-dark);
            font-weight: 700;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 40px;
            font-size: 15px;
        }

        /* Alertas */
        .alert {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-border);
        }

        .alert-danger::before {
            content: '⚠';
            font-size: 18px;
        }

        /* Formulario */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--card-bg);
            color: var(--text-dark);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        button[type="submit"] {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 12px;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-page {
                flex-direction: column;
            }

            .welcome-panel {
                padding: 40px 20px;
                min-height: 250px;
            }

            .welcome-panel h2 {
                font-size: 32px;
            }

            .welcome-panel p {
                font-size: 16px;
            }

            .form-panel {
                padding: 30px 20px;
            }

            .card {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
            }

            .card h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <!-- Panel Izquierdo: Bienvenida y Branding -->
        <div class="welcome-panel">
            <div class="welcome-content">
                <div class="logo-container">
                    <h1>DBUN</h1>
                </div>
                <h2>¡Bienvenido de vuelta!</h2>
                <p>Sistema de Gestión de Bienestar Universitario. Accede a tu cuenta para continuar gestionando los servicios de bienestar.</p>
            </div>
        </div>

        <!-- Panel Derecho: Formulario de Login -->
        <div class="form-panel">
            <div class="login-container">
                <div class="card">
                    <h2>Iniciar Sesión</h2>
                    <p class="subtitle">Ingresa tus credenciales institucionales</p>

                    <!-- Ejemplo de alerta de error (quita los comentarios para mostrar) -->
                    <!--
                    <div class="alert alert-danger">
                        Correo o contraseña incorrectos.
                    </div>
                    -->

                    <form action="index.php?controller=Login&action=authenticate" method="POST">
                        <div class="form-group">
                            <label for="email">Correo Institucional</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                placeholder="tu.correo@institucion.com"
                                autocomplete="email"
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="••••••••••"
                                autocomplete="current-password"
                            >
                        </div>
                        <button type="submit">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>