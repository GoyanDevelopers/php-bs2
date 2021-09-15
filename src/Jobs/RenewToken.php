<?php

namespace Goyan\Bs2\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goyan\Bs2\Utils\Connection;

class RenewToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uniqueFor = 3600;

    public function handle(Connection $conn)
    {
        $conn->token->update(['status' => 0]);

        try {

            if ($conn->refreshTokenAcess() === true) {
                return $this->release(300);
            }

            throw new \Exception('Falha ao gerar o token');
        } catch (\Throwable $e) {

            return $this->release(300);
        }
    }
}
