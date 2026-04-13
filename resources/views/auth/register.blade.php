<x-guest-layout>
    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 4px;">¡Crear cuenta!</h2>
    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 24px;">Completá tus datos para registrarte</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Nombre completo</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
            @error('name') <p style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
            @error('email') <p style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Contraseña</label>
            <input type="password" name="password" required
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
            @error('password') <p style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" required
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
        </div>

        <div style="background: #fef9c3; border: 1px solid #fde047; border-radius: 10px; padding: 12px 14px; margin-bottom: 24px;">
            <p style="color: #a16207; font-size: 0.85rem; font-weight: 600;">⚠️ Tu cuenta quedará pendiente hasta que un administrador la apruebe.</p>
        </div>

        <button type="submit" style="width: 100%; background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 14px; border-radius: 10px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; font-family: 'Nunito', sans-serif;">
            Registrarme →
        </button>

        <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 0.9rem;">
            ¿Ya tenés cuenta? 
            <a href="{{ route('login') }}" style="color: #2563eb; font-weight: 700; text-decoration: none;">Ingresá</a>
        </p>
    </form>
</x-guest-layout>