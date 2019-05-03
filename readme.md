# crphp/siebel-server-manager

<a href="https://packagist.org/packages/crphp/webservice"><img src="https://poser.pugx.org/crphp/siebel-server-manager/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/crphp/webservice"><img src="https://poser.pugx.org/crphp/siebel-server-manager/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/crphp/webservice"><img src="https://poser.pugx.org/crphp/siebel-server-manager/license.svg" alt="License"></a>

Essa biblioteca faz uso do *Siebel Server Manager* para manipular componentes e demais itens de aplicações Sibeis.

Está biblioteca segue os padrões descritos na [PSR-2](http://www.php-fig.org/psr/psr-2/), logo, 
isso implica que a mesma está em conformidade com a [PSR-1](http://www.php-fig.org/psr/psr-1/).

As palavras-chave "DEVE", "NÃO DEVE", "REQUER", "DEVERIA", "NÃO DEVERIA", "PODERIA", "NÃO PODERIA", 
"RECOMENDÁVEL", "PODE", e "OPCIONAL" neste documento devem ser interpretadas como descritas no 
[RFC 2119](http://tools.ietf.org/html/rfc2119). Tradução livre [RFC 2119 pt-br](http://rfc.pt.webiwg.org/rfc2119).

## Referências

 - [PSR-1](http://www.php-fig.org/psr/psr-1/)
 - [PSR-2](http://www.php-fig.org/psr/psr-2/)
 - [RFC 2119](http://tools.ietf.org/html/rfc2119) (tradução livre [RFC 2119 pt-br](http://rfc.pt.webiwg.org/rfc2119))

## Funcionalidades

As seguintes ações são passíveis de serem aplicadas a qualquer componente:

- [x] Stop
- [x] Kill
- [x] List
- [x] Start
- [ ] List tasks
- [ ] Loglevel (view/list/edit)
- [ ] Kill task

## Requisitos

Os módulos abaixos já estão definidos no arquivo composer.json, isso significa que serão validados automaticamente.

 - REQUER os binários do Siebel Server manager
 - REQUER o PHP >= 7.1.3

## Baixando a biblioteca crphp/siebel-server-manager

Para a etapa abaixo estou pressupondo que você tenha o composer instalado e saiba utilizá-lo:
```
composer require crphp/siebel-server-manager
```

Ou se preferir criar um projeto:
```
composer create-project --prefer-dist crphp/siebel-server-manager nome_projeto
```

Caso ainda não tenha o composer instalado, obtenha este em: https://getcomposer.org/download/

## Exemplos de uso

```php
<?php

require_once './vendor/autoload.php';

use Crphp\SiebelServerManager\Client;
use Crphp\SiebelServerManager\Component;

$client = (new Client)
                ->connectionString('path_to_bin', 'gateway', 'enterprise', 'username', 'password', 'server');

$output = (new Component)
                ->details($client)
                ->toArray();

print_r($output);
```

## Licença (MIT)

Todo o conteúdo presente neste diretório segue o que determina a licença [MIT](https://opensource.org/licenses/MIT).