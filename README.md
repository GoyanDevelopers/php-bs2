# Bs2 API PHP

Este é um pacote para facilitar a integração com o [Banco Bs2](https://www.bancobs2.com.br/).
Projeto ainda em desenvolvimento (todas e quaisquer contribuições são bem-vindas)
Acesse <https://devs.bs2.com/> para obter mais detalhes técnicos.

## Instalação

Você pode instalar o pacote via composer

``` bash
composer require goyan/php-bs2
```

### Exemplo de requisição PIX

``` php
use Goyan\Bs2\Setup;
use Goyan\Bs2\Pix;

$endpoint = 'https://api.bs2.com'; // PRODUÇÃO
$endpoint = 'https://apihmz.bancobonsucesso.com.br'; // SANDBOX
$api_key = 'API KEY';
$api_secret = 'API SECRET';
$refresh_token = 'REFRESH TOKEN';
$scope = 'cobv.write cobv.read cob.write cob.read pix.write pix.read dict.write 
dict.read pix.write pix.read pix.write pix.read pix.write pix.read pix.write 
pix.read webhook.read webhook.write';

$setup = new Setup($endpoint, $api_key, $api_secret);
$setup->GenerateAccessToken($refresh_token, $scope);

$pix = new Pix($setup);
print_r($pix->paymentByKey('CHAVE PIX'));

```


### Exemplo de requisição Banking

``` php
use Goyan\Bs2\Setup;
use Goyan\Bs2\Banking;

$endpoint = 'https://api.bs2.com'; // PRODUÇÃO
$endpoint = 'https://apihmz.bancobonsucesso.com.br'; // SANDBOX

$api_key = 'API KEY';
$api_secret = 'API SECRET';
$refresh_token = 'REFRESH TOKEN';
$scope = 'saldo extrato pagamento transferencia boleto';

$setup = new Setup($endpoint, $api_key, $api_secret);

$setup->GenerateAccessToken($refresh_token, $scope);

$banking = new Banking($setup);
print_r($banking->getSaldo());

```
## Licença
GNU GENERAL PUBLIC LICENSE
