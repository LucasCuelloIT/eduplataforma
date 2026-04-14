<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduPlataforma — Apoyo escolar online</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; background: #f0f7ff; }

        /* NAV */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 16px 32px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        .nav-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .nav-logo span { font-weight: 800; font-size: 1.3rem; color: #1e293b; }
        .nav-btn {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white; padding: 10px 24px; border-radius: 10px;
            text-decoration: none; font-weight: 700; font-size: 0.95rem;
            transition: opacity 0.2s;
        }
        .nav-btn:hover { opacity: 0.9; }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 50%, #06b6d4 100%);
            display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 120px 24px 80px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
        }
        .hero-content { position: relative; z-index: 1; max-width: 800px; }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white; padding: 6px 16px; border-radius: 20px;
            font-size: 0.85rem; font-weight: 600; margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .hero h1 {
            color: white; font-size: 3.5rem; font-weight: 800;
            line-height: 1.1; margin-bottom: 20px;
        }
        .hero h1 span { color: #fde68a; }
        .hero p {
            color: rgba(255,255,255,0.9); font-size: 1.2rem;
            line-height: 1.7; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;
        }
        .hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn-white {
            background: white; color: #2563eb;
            padding: 14px 32px; border-radius: 12px;
            text-decoration: none; font-weight: 800; font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
        .btn-outline {
            background: transparent; color: white;
            padding: 14px 32px; border-radius: 12px;
            text-decoration: none; font-weight: 700; font-size: 1rem;
            border: 2px solid rgba(255,255,255,0.6);
            transition: background 0.2s;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }

        /* STATS */
        .stats {
            background: white;
            padding: 40px 32px;
            display: flex; justify-content: center; gap: 48px; flex-wrap: wrap;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .stat { text-align: center; }
        .stat-number { font-size: 2rem; font-weight: 800; color: #2563eb; }
        .stat-label { color: #6b7280; font-size: 0.9rem; font-weight: 600; }

        /* FEATURES */
        .features { padding: 80px 32px; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 48px; }
        .section-title h2 { font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 12px; }
        .section-title p { color: #6b7280; font-size: 1.05rem; }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        .feature-card {
            background: white; border-radius: 20px;
            padding: 32px; text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
        .feature-icon { font-size: 3rem; margin-bottom: 16px; }
        .feature-card h3 { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
        .feature-card p { color: #6b7280; font-size: 0.9rem; line-height: 1.6; }

        /* ROLES */
        .roles { background: white; padding: 80px 32px; }
        .roles-inner { max-width: 1200px; margin: 0 auto; }
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px; margin-top: 48px;
        }
        .role-card {
            border-radius: 20px; padding: 32px; text-align: center;
            transition: transform 0.2s;
        }
        .role-card:hover { transform: translateY(-4px); }
        .role-card.admin { background: linear-gradient(135deg, #dbeafe, #e0f2fe); }
        .role-card.docente { background: linear-gradient(135deg, #dcfce7, #d1fae5); }
        .role-card.alumno { background: linear-gradient(135deg, #fef9c3, #fde68a); }
        .role-icon { font-size: 3rem; margin-bottom: 16px; }
        .role-card h3 { font-size: 1.2rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
        .role-card p { color: #4b5563; font-size: 0.9rem; line-height: 1.6; }

        /* CTA */
        .cta {
            background: linear-gradient(135deg, #1e40af, #0ea5e9);
            padding: 80px 32px; text-align: center;
        }
        .cta h2 { color: white; font-size: 2rem; font-weight: 800; margin-bottom: 16px; }
        .cta p { color: rgba(255,255,255,0.9); font-size: 1.05rem; margin-bottom: 32px; }

        /* FOOTER */
        .footer {
            background: #1e293b; color: #94a3b8;
            padding: 24px 32px; text-align: center; font-size: 0.9rem;
        }
        .footer span { color: #60a5fa; font-weight: 700; }

        @media (max-width: 600px) {
            .hero h1 { font-size: 2.2rem; }
            .stats { gap: 24px; }
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav class="nav">
        <a href="/" class="nav-logo">
            <span style="font-size: 1.8rem;">🎓</span>
            <span>EduPlataforma</span>
        </a>
        <a href="{{ route('login') }}" class="nav-btn">Ingresar →</a>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">🇦🇷 Apoyo escolar para Argentina</div>
            <h1>Aprendé más,<br><span>entendé mejor</span></h1>
            <p>Videos explicativos, ejercicios interactivos y seguimiento personalizado para alumnos de primaria y secundaria.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-white">🚀 Registrarme gratis</a>
                <a href="{{ route('login') }}" class="btn-outline">Ya tengo cuenta</a>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div class="stats">
        <div class="stat">
            <div class="stat-number">📚</div>
            <div class="stat-label">Cursos por materia y grado</div>
        </div>
        <div class="stat">
            <div class="stat-number">▶️</div>
            <div class="stat-label">Videos explicativos</div>
        </div>
        <div class="stat">
            <div class="stat-number">✅</div>
            <div class="stat-label">Ejercicios con corrección automática</div>
        </div>
        <div class="stat">
            <div class="stat-number">🏆</div>
            <div class="stat-label">Seguimiento de progreso</div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features">
        <div class="section-title">
            <h2>¿Qué tiene EduPlataforma?</h2>
            <p>Todo lo que necesitás para aprender o enseñar, en un solo lugar.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎥</div>
                <h3>Videos explicativos</h3>
                <p>Cada lección tiene un video corto y claro que explica el tema de manera simple.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✏️</div>
                <h3>Ejercicios interactivos</h3>
                <p>Múltiple choice, verdadero/falso y completar espacios con corrección automática.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Seguimiento de progreso</h3>
                <p>El alumno ve su nota y el docente puede ver el avance de cada estudiante.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Desde cualquier dispositivo</h3>
                <p>PC, tablet o celular. La plataforma se adapta a cualquier pantalla.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🇦🇷</div>
                <h3>Currículo argentino</h3>
                <p>Contenido organizado por materia y grado, adaptado al sistema educativo argentino.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>100% gratuito</h3>
                <p>Sin costos para alumnos ni docentes. Educación accesible para todos.</p>
            </div>
        </div>
    </section>

    <!-- ROLES -->
    <section class="roles">
        <div class="roles-inner">
            <div class="section-title">
                <h2>Para todos los roles</h2>
                <p>Cada usuario tiene su propio espacio diseñado para sus necesidades.</p>
            </div>
            <div class="roles-grid">
                <div class="role-card admin">
                    <div class="role-icon">🛠️</div>
                    <h3>Administrador</h3>
                    <p>Aprobá usuarios, asigná cursos a alumnos y gestioná toda la plataforma.</p>
                </div>
                <div class="role-card docente">
                    <div class="role-icon">👨‍🏫</div>
                    <h3>Docente</h3>
                    <p>Creá cursos, subí lecciones con video y armá ejercicios con corrección automática.</p>
                </div>
                <div class="role-card alumno">
                    <div class="role-icon">🎓</div>
                    <h3>Alumno</h3>
                    <p>Accedé a tus cursos, mirá los videos, respondé ejercicios y seguí tu progreso.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>¿Listo para empezar?</h2>
        <p>Registrate gratis y empezá a aprender hoy mismo.</p>
        <a href="{{ route('register') }}" class="btn-white">🚀 Crear mi cuenta gratis</a>
    </section>

    <!-- FOOTER -->
<footer class="footer">
    <p>Hecho con ❤️ para los chicos de Argentina · <span>EduPlataforma</span> © {{ date('Y') }}</p>
    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
        Desarrollado con 💙 por <span style="color: #60a5fa; font-weight: 700;">Lucas</span> y <span style="color: #60a5fa; font-weight: 700;">Claude</span> · Un proyecto con propósito
    </p>
</footer>

</body>
</html>