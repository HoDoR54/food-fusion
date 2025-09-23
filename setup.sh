#!/bin/bash

# Laravel Docker Setup Script
echo "🚀 Setting up Laravel Food Fusion..."

# Wait for database to be ready
echo "⏳ Waiting for database..."
sleep 10

# Run migrations
echo "📝 Running migrations..."
docker-compose exec app php artisan migrate

# Run seeders
echo "🌱 Running seeders..."
docker-compose exec app php artisan db:seed

# Clear caches
echo "🧹 Clearing caches..."
docker-compose exec app php artisan optimize:clear

# Build frontend assets (if needed)
echo "🎨 Building frontend assets..."
docker-compose exec app npm run build

echo "✅ Setup complete! Your application is ready at http://localhost"