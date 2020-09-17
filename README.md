# Thought For The Developer
The purpose of this project is to allow users to create an account, then, drop a comment or more for the developer.
I like to call them **thoughts**.

# Table of Content
1. [Development](#development)
2. [API Documentation](#api-documentation)
3. [How It Works](#how-it-works)

# Development
This project is developed using Symfony (4). And just for practice.

# API Documentation
[Via Postman](#)

# How It Works
## Authentication
- Create an account (`first_name`, `last_name`, `username`, `password`, `created_at`, `updated_at`)
- Login (`username`, `password`)

## Main Operation
Thought::entity - `id`, `user_id`, `comment`, `created_at`, `updated_at`

- List all your thoughts (GET `/thoughts`)
- Store a thought (POST `/thoughts`)
- Show a thought (GET `/thoughts/{thought}`)
- Edit a thought (PUT `/thoughts/{thought}`)
- Delete a thought (DELETE `/thoughts/{thought}`)
