<?php

namespace Goyan\Bs2\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Notificacao;
use Goyan\Bs2\Utils\Connection;
use App\Models\Usuario;

class GenerateToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $refresh_token;
    protected $relaunch;

    public function __construct($refresh_token, $relaunch)
    {
        $this->refresh_token = $refresh_token;
        $this->relaunch = $relaunch;
    }

    public function uniqueId()
    {
        return $this->refresh_token;
    }

    public function handle(Connection $conn)
    {
        try {

            $refresh_token = $conn->oAuth($this->refresh_token);

            if ($refresh_token) {
                GenerateToken::dispatch($refresh_token, true)->onQueue('high')->delay(300);
                return;
            }
        } catch (\Throwable $e) {

            if ($this->relaunch) {
                if ($this->attempts() >= 3) {
                    Notification::send(Usuario::where('is_admin', 1)->get(), new Notificacao("Cron Wallet", "Houve uma falha renovar o token da BS2, contate a equipe técnica"));
                }

                return $this->release(50);
            }

            throw new \Exception($e->getMessage());
        }
    }
}
