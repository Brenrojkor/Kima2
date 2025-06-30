FROM php:8.2-apache

# Install base dependencies
RUN apt-get update && apt-get install -y \
    gnupg2 \
    ca-certificates \
    curl \
    apt-transport-https \
    lsb-release \
    unixodbc-dev \
    && rm -rf /var/lib/apt/lists/*

# Add Microsoft GPG key properly and repo for Debian 12 (Bookworm)
RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft.gpg \
 && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
    > /etc/apt/sources.list.d/mssql-release.list

# Install MS ODBC driver
RUN apt-get update \
 && ACCEPT_EULA=Y apt-get install -y msodbcsql18

# Install PHP extensions for SQL Server
RUN pecl install pdo_sqlsrv sqlsrv \
 && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy your PHP project files
COPY . /var/www/html

# Optional: Set permissions
RUN chown -R www-data:www-data /var/www/html

