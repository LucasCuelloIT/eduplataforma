<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EduPlataforma') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Nunito', sans-serif; }
        </style>
    </head>
    <body style="margin: 0; min-height: 100vh; background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%); display: flex; align-items: center; justify-content: center;">

        <div style="width: 100%; max-width: 440px; padding: 24px;">

            <!-- Logo -->
            <div style="text-align: center; margin-bottom: 32px;">
                <a href="/" style="text-decoration: none;">
                    <div style="display: inline-flex; align-items: center; gap: 10px;">
                        <span style="font-size: 2.5rem;">🎓</span>
                        <span style="color: white; font-weight: 800; font-size: 1.8rem; letter-spacing: -0.5px;">EduPlataforma</span>
                    </div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem; margin-top: 6px;">Apoyo escolar para primaria y secundaria</p>
                </a>
            </div>

            <!-- Card -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); padding: 36px;">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>