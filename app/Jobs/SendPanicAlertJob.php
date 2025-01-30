<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPanicAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $panicData;

    public function __construct($panicData)
    {
        $this->panicData = $panicData;
    }

    public function handle()
    {
        try {
            $response = Http::post('https://wayne-enterprises.com/api/panic', $this->panicData);

            if ($response->failed()) {
                throw new \Exception("Échec de l'envoi de l'alerte à Wayne Enterprises.");
            }

            Log::info('Alerte envoyée avec succès à Wayne Enterprises.', ['data' => $this->panicData]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'alerte à Wayne Enterprises : ' . $e->getMessage());
        }
    }
}
