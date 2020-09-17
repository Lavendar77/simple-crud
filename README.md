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
1. Generate the SSH keys:
```
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
*However, I used **PuttyGen** to generate a key and saved the private key as `private.pem`. Then, ran the second command:
`$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`*.

# API Documentation
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/c9981d7b9d2b6c6bc06c#?env%5BSimple%20CRUD%5D=W3sia2V5IjoiYmFzZVVybCIsInZhbHVlIjoiMTI3LjAuMC4xOjgwMDAvYXBpIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJ0b2tlbiIsInZhbHVlIjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKU1V6STFOaUo5LmV5SnBZWFFpT2pFMk1EQXpOelUxTlRrc0ltVjRjQ0k2TVRZd01ETTNPVEUxT1N3aWNtOXNaWE1pT2xzaVVrOU1SVjlWVTBWU0lsMHNJblZ6WlhKdVlXMWxJam9pUW1WemMybGxMa3hsYld0bFFHZHRZV2xzTG1OdmJTSjkuRm1RQTlPZ3lyZThQWGg4TldnTUVjc2hqVi1Jei1wYjkwR0RyU3A3aENtU2d0UmQ4ZFU2RTUySThMckVrdHFnS2VNcGZWbWx4OHpFa3hzMHdaVFpfRWJIRXROVUt2TXIzXzhtdExjQjFpMG5CQW5xeUp6ZWNwWExramdRQmRYRVIzTzdiNlAtTjhQNndRZEgyTTZrdWkwRnR2N3FXaEtRNG1KWEtDZkZrQm5pV0ZtOE1wUkhnbjhpcDRMUURfa1haNE9UZTA1dlN5ekhhZFdCTFpiRERXRzVuWk9ma1puLUpEVU9waEVWbjZpVXBfdm95ZTVpVFh6eVZLQnhhQkFncDEtYmI0ZWNjdzRrbUc2MzVMeTVQSmI3Wk5CbExKcFpwZy03ZkJ0b2lXR2RqeWM2UnlaOHhCNlg1VkktZThzdUlfd3VpMlFUMWZ2Q0E5QUpnVmRKMTZNSjRvUjdSa3BHdEl5VGFiazFjMjdtb18wQ0cySnNMeXlmMjhOZGZmeEJrN2hmZ2VIN2tQV25raldNbW45SG5TWTZ4bE9JNnh3QzNCMl9yTTd1VkVja3VaYVNQa2s4dlFydTdBb2pYal9COEg0RER5SXBWV1ZXVHN0cmxJQ3A0WXFoSEE2Uy11bGpXTzJkVTFJQUpjdFMyYS11bkFYZ083b3p3b2lDWkVlYlhyS2NQUGUxcjByLTFnY3A4TjJwMTg4NVNfNU5mcWk0QU1mN0pzbGZjcTJSdEZLNUg1UjZqVUJONlZSZW1XRHNrWFZ4dm5sTVJRRmRTejZqWVNwNHZuRko3dUhxWnQ0RGNtbVppSGtNUWRER3o5Szc4aE4yQVNhc25tS0Iya3o3aC1LRkVaS1lfQ19MaEJhdW56cHFTbXVDWmlKSXplZjNNQllhdnJfZ2pmZzgiLCJlbmFibGVkIjp0cnVlfV0=)

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

# WIP
- Logout.
- Timestamps in entities.
- Have a standard API response.
