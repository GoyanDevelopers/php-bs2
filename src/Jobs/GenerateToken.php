<?php

namespace Goyan\Bs2\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goyan\Bs2\Utils\Connection;

class GenerateToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 86400; // 1 DIA | $tries * $backoff = 2 DIAS TESTANDO ANTES DE ENCERRAR O EVENTO
    public $backoff = 30; // 30 SEGUNDOS DE DELAY ENTRE AS FALHAS

    /**
     * @var string
     */
    protected $refresh_token;

    /**
     * @var boolean
     */
    protected $relaunch;

    public function __construct($refresh_token, $relaunch = true)
    {
        $this->refresh_token = $refresh_token;
        $this->relaunch = $relaunch;
    }

    /**
     * @return array
     */
    public function uniqueId()
    {
        return $this->refresh_token;
    }

    /**
     * Executar evento.
     *
     * @return mixed
     */
    public function handle()
    {

        try {
            $connection = Connection::refleshConnection($this->refresh_token);

            GenerateToken::dispatch($connection['refresh_token'], true)->onQueue('high')->delay($connection['expires_in'] - 120);
        } catch (\Throwable $exception) {

            if ($this->relaunch == false) {
                $this->fail($exception);
            }
        }
    }
}
