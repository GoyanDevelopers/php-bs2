<?php

namespace Goyan\Bs2\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goyan\Bs2\Utils\Connection;
use Throwable;
class GenerateToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 80;
    public $maxExceptions = 80;
    public $backoff = 10;
    public $uniqueFor = 300;

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
     * retryUntil
     *
     * @return void
     */
    public function retryUntil()
    {
        return now()->addMinutes(20);
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

            GenerateToken::dispatch($connection['refresh_token'])->delay((int) $connection['expires_in'] - 30);
        } catch (Throwable $exception) {

            if ($this->relaunch == true) {
                $this->fail($exception);
            }
        }
    }
}
