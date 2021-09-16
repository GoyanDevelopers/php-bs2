<?php

namespace Goyan\Bs2;

use Illuminate\Console\Command;
use Goyan\Bs2\Jobs\GenerateToken;

class Bs2Command extends Command
{
    /**
     * @var string
     */
    protected $signature = 'goyan:bs2 {--token=}';

    /**
     * @var string
     */
    protected $description = 'Executar evento de token BS2';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $refresh_token = $this->option('token');

        if ($refresh_token) {
            GenerateToken::dispatch($refresh_token, false)->onQueue('high');

            $this->info('Goyan Developers: Evento disparado com sucesso');
        }
    }
}
