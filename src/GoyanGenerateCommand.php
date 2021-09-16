<?php

namespace Goyan\Bs2;

use Illuminate\Console\Command;
use Goyan\Bs2\Jobs\RenewToken;

class GoyanGenerateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'goyan:run';

    /**
     * @var string
     */
    protected $description = 'Executa evento de token BS2';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = $this->option('token');

        if ($token) {
            RenewToken::dispatch($this->argument('token'))->onQueue('high');

            $this->info('Evento disparado com sucesso');
        } else {
            $this->line('<comment>Informe um token</comment>');
        }
    }
}
