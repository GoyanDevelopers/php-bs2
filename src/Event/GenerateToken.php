<?php

namespace Goyan\Bs2\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;
use Throwable;
use Exception;

class GenerateToken implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 80;
    public $maxExceptions = 80;
    public $backoff = 10;
    public $uniqueFor = 240;

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
        return now()->addMinutes(15);
    }

    /**
     * Executar evento.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = Token::firstOrCreate();

        try {

            $token->update(['status' => 0]);

            $params = [
                'grant_type' => 'refresh_token',
                'scope' => config('bs2.scope'),
                'refresh_token' => $this->refresh_token
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->asForm()
                ->withBasicAuth(config('bs2.api_key'), config('bs2.api_secret'))
                ->post(config('bs2.server') . '/auth/oauth/v2/token', $params);

            $response->throw();

            if ($response->successful()) {

                $responseJson = $response->json();

                $token->update(array_merge(['status' => 1], $responseJson));

                GenerateToken::dispatch($responseJson['refresh_token'])->delay((int) $responseJson['expires_in'] - 60);

                return;
            }

            throw new Exception('O Token "' . $this->refresh_token . '" não foi aceito pela BS2, confira o arquivo config/bs2.php e em seguida realize um novo disparo');
        } catch (ConnectionException) {
            if ($this->relaunch == true) {
                $this->release(300);
            }
        } catch (Throwable $th) {
            if ($this->relaunch == true) {
                $this->fail($th);
            }
        }
    }
}
