<x-guest-layout>
    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 4px;">¡Bienvenido!</h2>
    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 24px;">Ingresá tu cuenta para continuar</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
            @error('email') <p style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px; font-size: 0.9rem;">Contraseña</label>
            <input type="password" name="password" required
                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: 'Nunito', sans-serif;">
            @error('password') <p style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                <input type="checkbox" name="remember" style="width: 16px; height: 16px;">
                <span style="color: #6b7280; font-size: 0.85rem;">Recordarme</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: #2563eb; font-size: 0.85rem; font-weight: 600; text-decoration: none;">¿Olvidaste tu clave?</a>
            @endif
        </div>

        <button type="submit" style="width: 100%; background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 14px; border-radius: 10px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; font-family: 'Nunito', sans-serif;">
            Ingresar →
        </button>

        <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 0.9rem;">
            ¿No tenés cuenta? 
            <a href="{{ route('register') }}" style="color: #2563eb; font-weight: 700; text-decoration: none;">Registrate</a>
        </p>
    </form>
</x-guest-layout>