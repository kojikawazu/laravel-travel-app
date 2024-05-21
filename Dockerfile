# ベースイメージとして公式のPHP-FPMイメージを使用
FROM php:8.1-fpm

# Node.jsとnpmをインストール
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションディレクトリに移動
WORKDIR /var/www

# アプリケーションファイルをコピー
COPY . .

# Laravel依存関係をインストール
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run prod

# 必要なディレクトリの権限を設定
RUN chown -R www-data:www-data storage bootstrap/cache

# PHP-FPMのデフォルトポートを公開
EXPOSE 9000

# Laravelのartisanサーバーを起動
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8080"]