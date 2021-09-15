<?php

namespace Goyan\Bs2\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goyan\Bs2\Utils\Connection;
use App\Models\Usuario;

class RenewToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 20;

    public function uniqueId()
    {
        return 'bs2-refresh_token';
    }

    public function handle(Connection $conn)
    {
        if ($conn->refreshTokenAcess() === true) {
            return $this->release(300);
        }

        if ($this->attempts() >= 20) {
            Notification::send(Usuario::where('is_admin', 1)->get(), new Notificacao(['titulo' => "Cron Wallet", 'mensagem' => "Houve uma falha renovar o token da BS2, contate a equipe técnica"]));

        }

        return $this->release(120);
    }
}
