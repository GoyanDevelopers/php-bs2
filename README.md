# Laravel Bs2

Laravel Bs2 é um pacote Laravel para integração com as APIs de serviços financeiros do banco Bs2.
<br>
Para utilizar esses serviços é necessário ser um parceiro do bs2. Para mais detalhes acesse: <https://empresas.bancobs2.com.br/>.

Esse pacote lhe permite:
- Realizar pagamentos via PIX.
- Consultar pagamentos realizados via PIX.
- Criar cobranças dinâmicas.
- Consultar cobranças.
- Consultar recebimentos.

Para utilizar os métodos acima você precisará de um token de acesso, que já é gerado e gerenciado automaticamente pelo pacote.
<br>
Você pode acessar <https://devs.bs2.com/> para mais detalhes técnicos.

## Instalando
```bash
composer require Goyan/laravel-bs2
```

## Configuração
Uma vez que você possua todas as credenciais de acesso, é necessário criar as variáveis no .env do seu projeto.
<br>
Acesse **src/config/bs2.php** para mais detalhes.

## Utilização
Cada serviço financeiro possui sua própria classe com seus métodos.
<br>
Segue um exemplo de utilização do serviço de PIX:

```php
<?php

namespace App\Http\Controllers;

use Goyan\Bs2\Pix;

class Controller
{
    protected $pix;

    public function __construct(Pix $pix)
    {
        $this->pix = $pix;
    }

    public function chargeDetails()
    {
        $params = [
            'Inicio' => '2021-07-01',
            'Fim' => '2021-07-30'
        ];

        $response = $this->pix->chargeDetails($params);

        return $response;
    }

    public function chargeDetailsByTxId()
    {
        $txId = '41CCA23BA08AAE93BB45BFBE29C85C7';

        $response = $this->pix->chargeDetailsByTxId($txId);

        return $response;
    }
}
```

## Licença
GNU GENERAL PUBLIC LICENSE
