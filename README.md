# Installation Guide

Follow the steps below to install and set up the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/HishamAtef55/content-scheduler

cd content-scheduler

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

