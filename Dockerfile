# ベースイメージとして公式のPHP-FPMイメージを使用
FROM php:8.1-fpm

# 必要な依存関係をインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Node.jsとnpmをインストール
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /var/www

# アプリケーションファイルをコピー
COPY . .

# Laravel依存関係をインストール
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-plugins --no-scripts --no-progress \
    && npm install \
    && npm run build

# 必要なディレクトリの権限を設定
RUN chown -R www-data:www-data storage bootstrap/cache

# PHP-FPMのデフォルトポートを公開
EXPOSE 9000

# Laravelのartisanサーバーを起動
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8080"]
