# Thought For The Developer
The purpose of this project is to allow users to create an account, then, drop a comment or more for the developer.
I like to call them **thoughts**.

# Table of Content
1. [Development](#development)
	- [Setup](#setup)
2. [API Documentation](#api-documentation)
3. [How It Works](#how-it-works)

# Development
This project is developed using Symfony (4). And just for practice.

## Setup
1. Install dependencies
```bash
composer install
```
2. Generate the SSH keys:
```bash
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
*However, I used **PuttyGen** to generate a key and saved the private key as `private.pem`. Then, ran the second command:
`openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`*.

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
