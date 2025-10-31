# Docker Deployment & Container Rules

## Docker Compose Setup
- **Main Application Container**: `app-monexa`
- **Database Container**: `mysql-monexa` 
- **Web Server Container**: `nginx-monexa`
- **Cache Container**: `redis-monexa`
- **Database Management**: `phpmyadmin-monexa`

## Laravel Artisan Commands in Docker
- **MANDATORY PATTERN**: All php artisan commands MUST be executed inside the container
- **Command Format**: `docker-compose exec app-monexa php artisan [command]`
- **Never run**: Direct `php artisan` commands on host system
- **Always use**: Container-based execution for consistency

## Development Workflow
- **Container Start**: `docker-compose up -d`
- **Container Stop**: `docker-compose down`
- **Container Logs**: `docker-compose logs app-monexa`
- **Container Shell**: `docker-compose exec app-monexa bash`

## File System & Volumes
- **Project Root**: Mounted to `/var/www/html` in container
- **Live Editing**: Changes on host reflected in container immediately
- **Permissions**: Container user permissions may differ from host

## Database Access
- **Internal Access**: `mysql-monexa:3306` (from PHP container)
- **External Access**: `localhost:3306` (from host)
- **PhpMyAdmin**: `localhost:8111` (web interface)

## Port Configuration
- **Application**: `localhost:8211` (nginx proxy)
- **Database Admin**: `localhost:8111` (phpMyAdmin)
- **Direct MySQL**: `localhost:3306` (database connection)

## Security & Environment
- **Environment Files**: `.env` automatically loaded in container
- **Database Credentials**: Configured in docker-compose.yml
- **Network**: Uses `proxy-network` for container communication

## Debugging & Troubleshooting
- **View Logs**: `docker-compose logs [service-name]`
- **Container Status**: `docker-compose ps`
- **Resource Usage**: `docker stats`
- **Container Inspection**: `docker-compose exec app-monexa php -v`

## Deployment Best Practices
- **Always use container commands for Laravel operations**
- **Test migrations in container environment first**
- **Use container-based composer for dependency management**
- **Ensure proper file permissions between host and container**
- **Monitor container health and resource usage**

## CRON Jobs in Container
- **Setup**: Configure cron inside app-monexa container
- **Pattern**: `docker-compose exec app-monexa php artisan schedule:run`
- **Automation**: Use host cron to execute container commands

## Common Pitfalls to Avoid
- ❌ Running `php artisan` directly on host
- ❌ Using host PHP for Laravel commands
- ❌ Ignoring container-host permission differences
- ❌ Not using proper container networking for database connections