# ApiOrder (Laravel)

## Requisitos
- Docker & docker-compose
- PHP 8.3
- Mysql 8.0
- Nginx
- Laravel 12
- Composer (se rodar local)

## Instalação rápida com Docker
1. Copie `.env.example` para `.env` e ajuste (ex.: `APP_KEY`, DB, MAIL).
2. `docker-compose up -d --build`
3. `docker-compose exec app bash`
4. `cd laravel`
5. `composer install`
6. `php artisan key:generate`
7. `php artisan migrate --seed`
8. `php artisan storage:link`
9. Testes: `php artisan test`

## Rotas principais
Prefixo: `/api/v1/`

- Clients: `GET /clients`, `POST /clients`, `GET /clients/{id}`, `PUT/PATCH /clients/{id}`, `DELETE /clients/{id}`, `GET /clients/{id}/orders`
- Products: `GET /products`, `POST /products` (multipart `photo`), `GET /products/{id}`, `PUT/PATCH /products/{id}`, `DELETE /products/{id}`
- Orders: `GET /orders`, `POST /orders` (body: `client_id`, `products: [{product_id, quantity}]`), `GET /orders/{id}`, `DELETE /orders/{id}`

## Observações
- Ao criar um pedido, a API dispara um e-mail (`OrderCreatedMail`) para o cliente (em `.env` definir MAIL_*; por padrão usamos `log`).
- Soft deletes ativados.
- Padronização PSR e nomes em inglês nas rotas e classes.

## Documentação da API (Swagger / OpenAPI)
Este projeto inclui uma especificação OpenAPI e instruções para publicar a documentação interativa da API.

Passos rápidos (usando l5-swagger)

1. Instale o pacote l5-swagger:
    - composer require "darkaonline/l5-swagger"
php artisan vendor:publish --provider "L5Swagger\\L5SwaggerServiceProvider"
2. Copie o arquivo OpenAPI:
    - mkdir -p storage/api-docs
cp docs/swagger.yaml storage/api-docs/swagger.yaml
3. Edite o arquivo config/l5-swagger.php se desejar alterar a rota padrão para /api/docs.
    4. Acesse em seu navegador:
👉 http://localhost:8000/api/docs

## Conteúdo da especificação OpenAPI

    • Inclui todas as rotas /api/v1/clients, /api/v1/products e /api/v1/orders (CRUDL completo).
    • Esquemas documentados:
        ◦ Client — informações do cliente;

        ◦ Product — produto (inclui campo photo_path obrigatório);

        ◦ Order — pedido (contendo N produtos);

        ◦ OrderItem — item do pedido (com unit_price, subtotal e total).
    • Validações documentadas: formato de e-mail, CEP (zip), faixas de preço (> 0), quantidade mínima (≥ 1) e obrigatoriedade de foto no cadastro de produto.
    • Exemplos de respostas de erro padronizadas:
        ◦ 422 — erro de validação;
        ◦ 404 — recurso não encontrado;
        ◦ 409 — conflito (e-mail duplicado).

## Coleção do Postman
    • Arquivo: docs/Apiorder.postman_collection.json (importe no Postman).
    • Estrutura de pastas:
        ◦ Clients
        ◦ Products
        ◦ Orders
    • Inclui exemplos válidos e inválidos (erros 422 e 409), além de exemplo multipart/form-data para upload de foto de produto.
    • Variáveis de ambiente:
        ◦ baseUrl — exemplo: http://localhost:8000/api/v1
        ◦ authToken — (opcional, caso habilite autenticação)
    • Testes automáticos inclusos (validação básica):
        ◦ Verificação de códigos de status (201, 200, 204);
        ◦ Verificação da presença de chaves (id, data, etc.) no corpo JSON;
        ◦ Para listagens, garante que a resposta contém paginação.

## Comandos Uteis

- up
docker-compose up -d --build

- down:
docker-compose down

- restart:
docker-compose down && docker-compose up -d

- bash:
docker-compose exec app bash

- migrate:
docker-compose exec app php artisan migrate

- seed:
docker-compose exec app php artisan db:seed

- test:
docker-compose exec app php artisan test

- logs:
docker-compose logs -f --tail=100

- composer-install:
docker-compose exec app composer install

- cache-clear:
docker-compose exec app php artisan optimize:clear
