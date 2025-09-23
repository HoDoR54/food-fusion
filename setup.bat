@echo off
REM Laravel Docker Setup Script for Windows

echo 🚀 Setting up Laravel Food Fusion...

REM Wait for database to be ready
echo ⏳ Waiting for database...
timeout /t 10 /nobreak > nul

REM Run migrations
echo 📝 Running migrations...
docker-compose exec app php artisan migrate

REM Run seeders
echo 🌱 Running seeders...
docker-compose exec app php artisan db:seed

REM Clear caches
echo 🧹 Clearing caches...
docker-compose exec app php artisan optimize:clear

REM Build frontend assets
echo 🎨 Building frontend assets...
docker-compose exec app npm run build

echo ✅ Setup complete! Your application is ready at http://localhost
pause