# Laravel - test-PHPJunior

## Instalação

Por favor, verifique o manual de instalação do Laravel antes de prosseguir. [Documentação oficial](https://laravel.com/docs/6.x#installing-laravel)


Clone o repositório

    git clone https://github.com/arthuras96/test-PHPJunior.git

Entre na pasta do projeto

    cd test-PHPJunior

Instale todas as dependências usando o composer

    composer install

Copie o example.env e faça a configuração requerida no .env

    cp .env.example .env

Gere uma nova chave de aplicação

    php artisan key:generate

Rode a aplicação

    php artisan serve


Você pode acessar a aplicação em http://localhost:8000

## Rotas pré-definidas

O json com as rotas pré-definidas pode ser consultado e alterado em database\DefaultRoutes.json


# REST API

Os exemplos para a REST API são descritas abaixo.

## Pegue a melhor rota entre os caminhos

### Request

`POST /api/route`

Request headers

| **Requisitado** 	| **Key**           | **Value**            	            |
|------------------	|------------------	|----------------------------------	|
| Sim      	        | Content-Type     	| application/x-www-form-urlencoded |

Request body - Exemplo

| **Requisitado** 	| **Key**           | **Value** |
|------------------	|------------------	|----------	|
| Sim      	        | origin            | A         |
| Sim      	        | destiny           | D         |
| Sim      	        | autonomy          | 10        |
| Sim      	        | literValue        | 2.5       |


### Response

    [
        {
        "data": {
            "best_route": [
                "A",
                "B",
                "D"
            ],
            "cost": 6.25
        }
        }
    ]
