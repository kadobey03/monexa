# Docker Deployment & Container Rules

## Container Setup
- **Containers**: `app-monexa` (PHP-FPM), `mysql-monexa`, `nginx-monexa`, `redis-monexa`, `phpmyadmin-monexa`
- **Ports**: App `localhost:8080`, phpMyAdmin `localhost:8081`, MySQL `localhost:3306`
- **Network**: `proxy-network` for container communication

## Laravel Command Execution
- **MANDATORY**: `docker-compose exec app-monexa php artisan [command]`
- **Never**: Direct `php artisan` on host system
- **Testing**: `docker-compose exec app-monexa php artisan test`

## Development Workflow
- **Start**: `docker-compose up -d`
- **Stop**: `docker-compose down`
- **Logs**: `docker-compose logs app-monexa`
- **Shell**: `docker-compose exec app-monexa bash`

## File System
- **Mount**: Project root → `/var/www/html` in container
- **Live Editing**: Host changes reflect in container
- **Permissions**: Container/host permission differences may occur

## Database Access
- **Internal**: `mysql-monexa:3306` (from PHP container)
- **External**: `localhost:3306` (from host)
- **Web UI**: `localhost:8081` (phpMyAdmin)

## Best Practices
- Use container commands for all Laravel operations
- Test migrations in container environment first
- Use container-based composer for dependencies
- Monitor container health and resource usage
- Configure CRON inside container: `docker-compose exec app-monexa php artisan schedule:run`