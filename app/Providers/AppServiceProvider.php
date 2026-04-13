use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

public function boot(): void
{
    if (env('APP_ENV') === 'local') {
        URL::forceRootUrl(config('app.url'));
    }

if (app()->environment('production')) {
    URL::forceScheme('https');
}

    // Forzar migraciones en producción
    if (app()->environment('production')) {
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            // no romper si falla
        }
    }
}