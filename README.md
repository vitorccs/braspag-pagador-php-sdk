# Braspag Pagador - SDK PHP
SDK em PHP para API Braspag Pagador e API Cartão Protegido

## Requisitos
* PHP >= 7.4

## Descrição
SDK em PHP para a [API Braspag Pagador](https://braspag.github.io/manual/braspag-pagador).

## Instalação
Via Composer
```bash
composer require vitorccs/braspag-pagador-php-sdk
```

## Parâmetros
| Parâmetro             | Obrigatório | Padrão | Comentário                                             |
|-----------------------|-------------|--------|--------------------------------------------------------|
| BRASPAG_MERCHANT_ID   | Sim         | null   | Merchant ID para autenticação                          |
| BRASPAG_MERCHANT_KEY  | Sim         | null   | Merchant Key para autenticação                         |
| BRASPAG_CLIENT_ID     | *Sim        | null   | Client ID para API Cartão Protegido                    |
| BRASPAG_CLIENT_SECRET | *Sim        | null   | Client Secret para API Cartão Protegido                |
| BRASPAG_SANDBOX       | Não         | false  | Habilita o modo Sandbox                                |
| BRASPAG_TIMEOUT       | Não         | 30     | Timeout em segundos para estabelecer conexão com a API |

_* Obrigatório apenas se for utilizar a API Cartão Protegido_
 
Podem ser definidos por variáveis de ambiente:

```bash
# Em um arquivo .env do seu projeto:
BRASPAG_MERCHANT_ID=myMerchantId
BRASPAG_MERCHANT_KEY=myMerchantKey
BRASPAG_CLIENT_ID=myClientId
BRASPAG_CLIENT_SECRET=myClientSecret
BRASPAG_SANDBOX=true

# Os serviços captarão automaticamente
$saleService = new \Braspag\SaleService();
$cardService = new \Braspag\CardService();
```

Ou passados como argumentos do serviço:

```php
# Para serviços da API Pagador
$parameters = new \Braspag\Entities\Pagador\Parameters(
    'myMerchantId',
    'myMerchantKey', 
    true // modo sandbox
);
$saleService = new \Braspag\SaleService($parameters);

# Para serviços da API Cartão Protegido
$parameters = new \Braspag\Entities\CartaoProtegido\Parameters(
    'myMerchantId',
    'myClientId'
    'myClientSecret', 
    true // modo sandbox
);
$cardService = new \Braspag\CardService($parameters);
```

## Serviços implementados

### API Pagador - Transação
```php
$saleService = new \Braspag\SaleService();
```
Criar Transação (para qualquer Meio de Pagamento)
```php
// Nota: utilize preferencialmente os Sales Builder (descrito mais
// abaixo na documentação) para gerar o parâmetro $sale
$response = $saleService->create($sale);
```
Estornar Transação (para qualquer Meio de Pagamento)
```php
// importante: amount deve ser em centavos e tipo inteiro
$response = $saleService->refund($paymentId, $amount);
```

### API Pagador - Consultas

```php
$queryService = new \Braspag\QueryService();
```
Obter Transação por Payment ID (ID de Pagamento)
```php
$response = $queryService->getByPaymentId($paymentId);
```
Obter Transação por Merchant Order Id (Identificador da Loja)
```php
$response = $queryService->getByMerchantOrderId($merchantOrderId);
```
Obter Transação por Recurrent Payment ID (ID de Pagamento Recorrente)
```php
$response = $queryService->getByRecurrentPaymentId($recurrentPaymentId);
```

### API Cartão Protegido
```php
$cardService = new \Braspag\CardService($parameters);
```
Gerar um Token para um Cartão de Crédito
```php 
// Nota: utilize preferencialmente o CardBuilder (descrito mais
// abaixo na documentação) para gerar o parâmetro $card
$response = $cardService->createToken($card);
```
Obter o Token que está associado ao Alias 
```php
$response = $cardService->getTokenByAlias($alias);
```
Obter os dados do Cartão pelo seu Token 
```php
$response = $cardService->getCardByToken($token);
```
Suspender o Token
```php
$response = $cardService->suspendToken($token);
```
Reativar o Token
```php
$response = $cardService->unsuspendToken($token);
```
Remover o Token
```php
$response = $cardService->removeToken($token);
```

## Construtores (Builders)
Para auxiliar a criar uma Transação, foram disponibilizados alguns construtores:

### API Pagador - Criando Endereço
```php
use Braspag\Builders\Pagador\AddressBuilder;

$address = AddressBuilder::create()
    ->setZipCode('06455-030')
    ->setStreet('Alameda Xingu')
    ->setNumber(512)
    ->setComplement('21o andar')
    ->setDistrict('Barueri')
    ->setState('SP')
    ->setCity('São Paulo')
    ->get();
```

### API Pagador - Criando Cliente
```php
use Braspag\Builders\Pagador\CustomerBuilder;

// Somente Nome é obrigatório para todos os Meios de Pagamento
$customer = CustomerBuilder::create('Nome Cliente')
    ->setIdentity('01.027.058/0001-91')
    ->setEmail('email@email.com')
    ->setBirthdate('2000-01-01')
    ->setAddress($address)
    ->setIpAddress('64.111.123.211')
    ->get();
```

### API Pagador - Criando Pagamento PIX

```php
use Braspag\Builders\Pagador\Sales\PixSaleBuilder;

$amount = 1000; // 10.00
$pixSale = PixSaleBuilder::create(Providers::CIELO, $amount)
    ->withCustomer($customer)
    ->withMerchantOrderId('000000006')
    ->setQrCodeExpiration(8200)
    ->get();
```

### API Pagador - Criando Pagamento Boleto Bancário

```php
use Braspag\Builders\Pagador\Sales\BoletoSaleBuilder;

$amount = 1000; // 10.00
$boletoSale = BoletoSaleBuilder::create(Providers::CIELO, $amount)
    ->withCustomer($customer)
    ->withMerchantOrderId('000000006')
    ->setAssignor('Nome do Cedente')
    ->setExpirationDate('2022-11-20')
    ->get();
```

### API Pagador - Criando Pagamento Cartão de Crédito

```php
use Braspag\Builders\Pagador\Cards\CreditCardBuilder;
use Braspag\Builders\Pagador\Sales\CreditCardSaleBuilder;

// primeiro, criamos o cartão
$creditCard = CreditCardBuilder::create()
    ->setCardNumber('4324017527053834')
    ->setBrand('Visa')
    ->setHolder($customer->Name)
    ->setExpirationDate('09/2030')
    ->setSecurityCode(333)
    ->setSaveCard(true)
    ->get();

// depois criamos a venda
$amount = 1000; // 10.00
$creditCardSale = CreditCardSaleBuilder::create(Providers::SIMULADO, $amount)
    ->withCustomer($customer)
    ->withMerchantOrderId('000000007')
    ->withCreditCard($creditCard)
    ->withCustomerAddress($address)
    ->withCustomerDeliveryAddress($address)
    ->get();
```

### API Pagador - Criando Pagamento Cartão de Débito

```php
use Braspag\Builders\Pagador\Cards\DebitCardBuilder;
use Braspag\Builders\Pagador\Sales\DebitCardSaleBuilder;

$debitCard = DebitCardBuilder::create()
    ->setCardNumber('4324017527053834')
    ->setBrand('Visa')
    ->setHolder($customer->Name)
    ->setExpirationDate('09/2030')
    ->setSecurityCode(333)
    ->setSaveCard(true)
    ->get();

$amount = 1000; // 10.00
$debitCardSale = DebitCardSaleBuilder::create(Providers::SIMULADO, $amount)
    ->withCustomer($customer)
    ->withMerchantOrderId($merchantOrderId)
    ->withDebitCard($debitCard)
    ->setReturnUrl('https://www.myreturnurl.com/path')
    ->get();
```

### API Cartão Protegido - Criando Cartão de Crédito
```php
use Braspag\Builders\CartaoProtegido\CardBuilder;

$card = CardBuilder::create()
    ->setCardNumber('4551870000000183')
    ->setHolder('Joao da Silva')
    ->setAlias('meu_alias')
    ->setExpirationDate('12/2025')
    ->setSecurityCode('123')
    ->get();
```

## Tratamento de erros
Esta biblioteca lança as seguintes exceções:

* `BraspagProviderException` para requisições que embora tenham retornado como sucesso (HTTP 2xx), o corpo da resposta indica um erro retornado pelo Provider [Status = 0](https://braspag.github.io/manual/braspag-pagador#lista-de-status-da-transa%C3%A7%C3%A3o). Tratamento implementado apenas no endpoint de criar Transação.
* `BraspagValidationException` para requisições que falharam (HTTP 4xx ou 5xx) e possuem mensagem de erro retornado pela API Braspag.
* `BraspagRequestException` para requisições que falharam (HTTP 4xx ou 5xx) sem tratamento de erro ou problemas de conexão diversos (sem resposta HTTP).

Exemplo de corpo da resposta onde será lançado uma exceção `BraspagProviderException`
```
{
  ...
  "Payment": {
    ...
    "Status": 0,
    "ProviderReturnMessage": "ERRO AO REALIZAR OPERACAO",
    ...
  }
}
```

Exemplo de corpo da resposta onde será lançado uma exceção `BraspagValidationException`
```
[
    {
        "Code": 133,
        "Message": "Provider is not supported for this Payment Type"
    }
]
```

## Exemplo de implementação

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';

putenv('BRASPAG_MERCHANT_ID=myMerchantId');
putenv('BRASPAG_MERCHANT_KEY=myMerchantKey');
putenv('BRASPAG_SANDBOX=true');

use Braspag\Builders\Pagador\CustomerBuilder;
use Braspag\Builders\Pagador\Sales\PixSaleBuilder;
use Braspag\Enum\Providers;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Exceptions\BraspagValidationException;

try {
    // CRIANDO UMA TRANSAÇÃO
    $saleService = new \Braspag\SaleService();
    
    // Opção 1 - Usando Builders
    $customer = CustomerBuilder::create('Nome Cliente')
        ->setIdentity('01.027.058/0001-91')
        ->get();
        
    $pixSale = PixSaleBuilder::create(Providers::CIELO, 20)
        ->withCustomer($customer)
        ->withMerchantOrderId('000000006')
        ->get();
    
    // Opção 2 - Usando array puro
    /*
    $pixSale = [
        'MerchantOrderId' => '000000006',
        'Customer' => [
            'Name' => 'Nome Cliente',
            'Identity' => '01027058000191',
            'IdentityType' => 'CNPJ'
        ],
        'Payment' => [
            'Type' => 'Pix',
            'Provider' => 'Simulado',
            'Amount' => 20
        ]
    ];
    */
    
    $checkSuccess = true;  // Habilitar BraspagProviderException
    $response = $saleService->create($pixSale, $checkSuccess);

    print_r($response);

} catch (BraspagProviderException $e) { // erros de Provider
    echo sprintf('Provider: %s (Payment Status: %s)', $e->getMessage(), $e->getCode());
    // NOTA: em erros de Provider, a Braspag irá criar a Transação normalmente
    // Caso queira capturar o corpo da reposta, utilize o método abaixo:
    $response = $e->getResponseData();
    
} catch (BraspagValidationException $e) { // erros de Validação da API
    echo sprintf('Validation: %s (Code: %s)', $e->getMessage(), $e->getCode());

} catch (BraspagRequestException $e) { // demais erros não tratados (HTTP 4xx e 5xx)
    echo sprintf('Request: %s (HTTP Status: %s)', $e->getMessage(), $e->getCode());

} catch (\Exception $e) { // demais erros
    echo $e->getMessage();
}
```

## Testes

Caso queira contribuir, por favor, implementar testes de unidade em PHPUnit.

Para executar:

```bash
composer test
```

 
