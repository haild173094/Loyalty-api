# Install
1. Run `cp .env.example .env` to create new .env file  
2. Run `docker compose up -d`  
3. Run `docker exec -it scaffolding-api sh` to access shell in scaffolding-api container  
4. Run `composer update`  
5. Run `php artisan migrate`  
6. Run `chmod -R 777 storage`  
7. Open app, get and set `SHOPIFY_API_KEY` and `SHOPIFY_API_SECRET`  
