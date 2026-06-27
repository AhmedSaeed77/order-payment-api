# Extendable Order & Payment Management API

## Requirements

- PHP 8.2+
- Laravel 12
- MySQL
- Composer

## Installation

Clone repository:

git clone <repository_url>

Install dependencies:

composer install

Copy environment file:

cp .env.example .env

Generate app key:

php artisan key:generate

Generate JWT secret:

php artisan jwt:secret

Configure database in .env

Run migrations:

php artisan migrate --seed

Run server:

php artisan serve


## Authentication

JWT Authentication implemented.

Endpoints:

POST /api/auth/register

POST /api/auth/login

POST /api/auth/logout


## Orders

POST /api/orders

GET /api/orders

PUT /api/orders/{id}

DELETE /api/orders/{id}


## Payments

POST /api/payments/process

GET /api/payments/index


## Payment Gateway Extensibility

The payment system uses Strategy Pattern.

To add a new payment gateway:

1. Create a class implementing:

App\Services\Payment\Contracts\PaymentGatewayInterface

2. Implement process()

3. Register gateway in:

PaymentGatewayFactory

4. Insert gateway record into payment_gateways table


## Testing

Run:

php artisan test
