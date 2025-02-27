setup: #Run Setup from the sratch #@make composer-update
	@make build
	@make up 
	
ps:  #Check docker containers
	docker-compose ps
build: #Run build force and no cache
	docker-compose build --no-cache --force-rm
fresh: #Refresh containers
	@make stop
	@make up
stop: #Stop containers
	docker-compose stop
up: #Run all containers
	docker-compose up -d

# In laravel, the edit the container_name to run the script below.
cache: #Laravel Clear Cache
    docker exec container_name bash -c "php artisan config:cache" 
    docker exec container_name bash -c "php artisan config:clear"
    docker exec container_name bash -c "php artisan cache:clear"
    
composer-update: #Laravel Composer update
	docker exec laravel-app bash -c "composer update"
data: #Laravel Migration
	docker exec container_name bash -c "php artisan migrate"
	docker exec container_name bash -c "php artisan db:seed"

