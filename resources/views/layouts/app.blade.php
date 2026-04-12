<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduPlataforma') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Nunito', sans-serif; }

            .nav-edu {
                background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            }

            .card-edu {
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .card-edu:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            }

            .btn-primary {
                background: linear-gradient(135deg, #2563eb, #0ea5e9);
                color: white;
                padding: 10px 24px;
                border-radius: 10px;
                font-weight: 600;
                transition: opacity 0.2s;
                display: inline-block;
            }

            .btn-primary:hover { opacity: 0.9; }

            .btn-success {
                background: linear-gradient(135deg, #16a34a, #22c55e);
                color: white;
                padding: 10px 24px;
                border-radius: 10px;
                font-weight: 600;
                transition: opacity 0.2s;
                display: inline-block;
            }

            .btn-success:hover { opacity: 0.9; }

            .btn-warning {
                background: linear-gradient(135deg, #d97706, #f59e0b);
                color: white;
                padding: 6px 16px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.85rem;
                transition: opacity 0.2s;
                display: inline-block;
            }

            .btn-danger {
                background: linear-gradient(135deg, #dc2626, #ef4444);
                color: white;
                padding: 6px 16px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.85rem;
                transition: opacity 0.2s;
                display: inline-block;
            }

            .btn-gray {
                background: #e5e7eb;
                color: #374151;
                padding: 10px 24px;
                border-radius: 10px;
                font-weight: 600;
                transition: opacity 0.2s;
                display: inline-block;
            }

            .page-header {
                background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
                color: white;
                padding: 24px 32px;
                border-radius: 16px;
                margin-bottom: 24px;
            }

            .badge-materia {
                background: #dbeafe;
                color: #1d4ed8;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .badge-grado {
                background: #dcfce7;
                color: #15803d;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .badge-pendiente {
                background: #fef9c3;
                color: #a16207;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .badge-aprobado {
                background: #dcfce7;
                color: #15803d;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .nota-box {
                background: linear-gradient(135deg, #2563eb, #0ea5e9);
                color: white;
                border-radius: 16px;
                padding: 20px;
                text-align: center;
            }

            main { background: #f0f7ff; min-height: calc(100vh - 64px); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background: #f8faff;">
            @include('layouts.navigation')

            @isset($header)
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                    <div class="page-header">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>