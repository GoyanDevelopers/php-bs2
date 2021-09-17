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

    public function handle()
    {
        try {
            $connection = Connection::refleshConnection($this->refresh_token);

            GenerateToken::dispatch($connection['refresh_token'], true)->onQueue('high')->delay(300);
        } catch (\Throwable $e) {

            if ($this->relaunch) {
                return $this->release(50);
            }

            throw new \Exception($e->getMessage());
        }
    }
}
