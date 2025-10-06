FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to match Render's path
WORKDIR /opt/render/project/src

# Copy existing application directory contents
COPY . /opt/render/project/src

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Create SQLite database directory and set permissions
RUN mkdir -p /opt/render/project/src/database && \
    touch /opt/render/project/src/database/database.sqlite && \
    chmod -R 777 /opt/render/project/src/storage && \
    chmod -R 777 /opt/render/project/src/bootstrap/cache && \
    chmod -R 777 /opt/render/project/src/database && \
    chmod 666 /opt/render/project/src/database/database.sqlite

# Expose port
EXPOSE $PORT

# Start server
CMD mkdir -p /opt/render/project/src/database && \
    touch /opt/render/project/src/database/database.sqlite && \
    chmod -R 777 /opt/render/project/src/database && \
    php artisan migrate:fresh --force && \
    php artisan db:seed --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

