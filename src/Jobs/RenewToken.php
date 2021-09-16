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

    public $tries = 30;
    public $refresh_token;

    public function __construct($refresh_token)
    {
        $this->refresh_token = $refresh_token;
    }

    public function uniqueId()
    {
        return $this->refresh_token;
    }

    public function handle(Connection $conn)
    {
        try {
            if ($conn->token->refresh_token == $this->refresh_token) {

                $conn->refreshTokenAcess();

                if (!$conn->new_token) {
                    RenewToken::dispatch($conn->new_token)->onQueue('high')->delay(300);
                }
            }
        } catch (\Throwable $e) {

            if ($this->attempts() >= 30) {
                Notification::send(Usuario::where('is_admin', 1)->get(), new Notificacao(['titulo' => "Cron Wallet", 'mensagem' => "Houve uma falha renovar o token da BS2, contate a equipe técnica"]));
            }

            return $this->release(50);
        }
    }
}
