# Laravel Docker Setup

This Docker setup provides a complete development and production environment for your Laravel application with Nginx, MySQL, Redis, and PhpMyAdmin.

## Services

- **app**: PHP 8.1-FPM with Laravel application
- **nginx**: Nginx web server (port 80)
- **mysql**: MySQL 8.0 database (port 3306)
- **redis**: Redis cache server (port 6379)
- **phpmyadmin**: Database management interface (port 8080)

## Quick Start

1. **Build and start the containers:**
   ```bash
   docker-compose up -d --build
   ```

2. **Check if all services are running:**
   ```bash
   docker-compose ps
   ```

3. **Access your application:**
   - Laravel App: http://localhost
   - PhpMyAdmin: http://localhost:8080

## Database Configuration

The setup creates:
- Database: `laravel`
- User: `laravel_user`
- Password: `laravel_password`
- Root Password: `root_password`

## Common Commands

### View logs
```bash
# All services
docker-compose logs

# Specific service
docker-compose logs app
docker-compose logs nginx
docker-compose logs mysql
```

### Execute commands in containers
```bash
# Laravel artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:cache

# Composer commands
docker-compose exec app composer install
docker-compose exec app composer update

# Access container shell
docker-compose exec app bash
docker-compose exec mysql bash
```

### Database operations
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Run seeders
docker-compose exec app php artisan db:seed

# Access MySQL CLI
docker-compose exec mysql mysql -u laravel_user -p laravel
```

### Stop and cleanup
```bash
# Stop containers
docker-compose down

# Stop and remove volumes (WARNING: This will delete your database)
docker-compose down -v

# Remove images
docker-compose down --rmi all
```

## File Permissions

The setup automatically handles file permissions, but if you encounter issues:

```bash
# Fix storage and cache permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

## Environment Variables

Key environment variables in `.env`:
- `DB_HOST=mysql` (container name)
- `REDIS_HOST=redis` (container name)
- `CACHE_DRIVER=redis`
- `SESSION_DRIVER=redis`
- `QUEUE_CONNECTION=redis`

## Production Considerations

For production deployment:

1. Change database passwords in `docker-compose.yml`
2. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
3. Use a reverse proxy (like Traefik or another Nginx) for SSL termination
4. Consider using Docker Swarm or Kubernetes for orchestration
5. Set up proper backup strategies for MySQL data
6. Use Docker secrets for sensitive information

## Troubleshooting

### Container won't start
```bash
# Check logs
docker-compose logs [service_name]

# Rebuild containers
docker-compose up -d --build --force-recreate
```

### Database connection issues
```bash
# Check if MySQL is ready
docker-compose exec mysql mysqladmin ping -h localhost

# Verify database exists
docker-compose exec mysql mysql -u root -p -e "SHOW DATABASES;"
```

### Permission issues
```bash
# Reset permissions
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 755 /var/www/html
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Clear all caches
```bash
docker-compose exec app php artisan optimize:clear
```

## Development Workflow

1. Make code changes on your host machine
2. Changes are automatically reflected in the container (volume mount)
3. For configuration changes, restart the containers:
   ```bash
   docker-compose restart app nginx
   ```
4. For dependency changes, rebuild:
   ```bash
   docker-compose up -d --build app
   ```

## Backup and Restore

### Backup MySQL database
```bash
docker-compose exec mysql mysqldump -u laravel_user -p laravel > backup.sql
```

### Restore MySQL database
```bash
docker-compose exec -i mysql mysql -u laravel_user -p laravel < backup.sql