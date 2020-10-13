# Thought For The Developer
The purpose of this project is to allow users to create an account, then, drop a comment or more for the developer.
I like to call them **thoughts**.

# Table of Content
1. [Development](#development)
	- [Setup](#setup)
2. [API Documentation](#api-documentation)
3. [How It Works](#how-it-works)

# Development
This project is developed using Symfony (4).

## Setup
1. Install dependencies
```bash
composer install
```

2. Database configuration
	- Configure your **.env**: `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`
	- Create the database: `php bin/console doctrine:database:create`
	- Create the database schema: `php bin/console doctrine:schema:create`

3. Generate the SSH keys (for JWT Token Configuration):
```bash
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
*In my case, I used **PuttyGen** to generate a key and saved the private key as `private.pem`. Then, ran the second command:
`openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`*.

4. Start your server
```bash
symfony serve:start --no-tls`
```

# API Documentation
[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/7154640/TVKBXHZa)

# How It Works
## Authentication
- Create an account (`first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`)
- Login (`email`, `password`)

## Main Operation
**Thought::entity** - `id`, `user_id`, `comment`, `created_at`, `updated_at`

- List all your thoughts (GET `/thoughts`)
- Store a thought (POST `/thoughts`)
- Show a thought (GET `/thoughts/{thought}`)
- Edit a thought (PUT `/thoughts/{thought}`)
- Delete a thought (DELETE `/thoughts/{thought}`)

# Testing
Okay, so testing has been stressful and quite annoying to be frank 🙄<br>
But we'll pull through 🚀

## Functional Tests
For now, only functional tests are available. Codebase is still a bit buggy, but one step at a time.
- Registration
Testing for both successful and failed requests.
- Login
Testing for both successful and failed requests.
