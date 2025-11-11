# Pastelaria API (Laravel)

## Requisitos
- Docker & docker-compose
- PHP 8.3
- MYSQL 8.0
- NGINX 
- Composer (se rodar local)

## Instalação rápida com Docker
1. Copie `.env.example` para `.env` e ajuste (ex.: `APP_KEY`, DB, MAIL).
2. `docker-compose up -d --build`
3. `docker-compose exec app bash`
4. `composer install`
5. `php artisan key:generate`
6. `php artisan migrate --seed`
7. `php artisan storage:link`
8. Testes: `php artisan test`

## Rotas principais
Prefixo: `/api/v1/`

- Clients: `GET /clients`, `POST /clients`, `GET /clients/{id}`, `PUT/PATCH /clients/{id}`, `DELETE /clients/{id}`, `GET /clients/{id}/orders`
- Products: `GET /products`, `POST /products` (multipart `photo`), `GET /products/{id}`, `PUT/PATCH /products/{id}`, `DELETE /products/{id}`
- Orders: `GET /orders`, `POST /orders` (body: `client_id`, `products: [{product_id, quantity}]`), `GET /orders/{id}`, `DELETE /orders/{id}`

## Observações
- Ao criar um pedido, a API dispara um e-mail (`OrderCreatedMail`) para o cliente (em `.env` definir MAIL_*; por padrão usamos `log`).
- Soft deletes ativados.
- Padronização PSR e nomes em inglês nas rotas e classes.
