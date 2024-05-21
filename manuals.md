# プロジェクトのセットアップ

```bash
composer create-project --prefer-dist laravel/laravel your-project-name
cd your-project-name
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

# 環境変数の設定

```
SUPABASE_URL=your-supabase-url
SUPABASE_KEY=your-supabase-key
```

# Guzzle のインストール

HTTP クライアントとして Guzzle をインストールします。

```bash
composer require guzzlehttp/guzzle
```

# PostgreSQL ドライバのインストール

```bash
sudo apt-get update
sudo apt-get install php-pgsql
```

# PostgreSQL 用の PDO ドライバの再インストール

```bash
sudo phpenmod pgsql
sudo phpenmod pdo_pgsql
```

# PostgreSQL の環境変数の設定

```
# SupabaseのDatabaseの設定から記載すること
DB_CONNECTION=pgsql
DB_HOST=db.<unique-id>.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=<your-supabase-password>
```

# 依存関係の再インストール

```bash
composer install
```

# マイグレーション

```bash
php artisan migrate
```

# Laravel アプリケーション起動

```bash
php artisan serve
```

# Vercel のインストール

Vercel へデプロイ前にインストールする

```bash
composer require revolution/laravel-vercel-installer --dev
php artisan vercel:install
```

# URL

-   Supabase

https://supabase.com/dashboard

-   Vercel Deploy Error

https://github.com/vercel-community/php/issues/504

https://github.com/yumelab-imai/qiita_laravel10_on_vercel/tree/master
