# attendance-system

## 概要説明

/Users/hasegawatakanori/coachtech/laravel/attendance-form/src/スクリーンショット 2024-02-17 0.24.32.png

ユーザーの勤務時間・休憩時間を記録するシステムを作成しました。

## 作成目的

企業から勤怠管理のデジタル化依頼を受けたため。

## アプリケーション URL

## 他のリポジトリ

## 機能一覧

-   登録・ログイン機能
-   打刻機能
-   ユーザーの勤務状況一覧

## 使用技術

-   PHP 7.49
-   Laravel 8.83.8
-   Mysql 8.0.26

## テーブル設計

src/スクリーンショット 2024-02-17 0.34.06.png

## ER 図

/Users/hasegawatakanori/coachtech/laravel/attendance-form/src/スクリーンショット 2024-02-17 21.01.04.png

## 環境構築

Docker ビルド

1. git clone
2. docker-compose up -d --build

Laravel 環境構築

1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから.env ファイルを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate

## URL

-   開発環境:<http://localhost/>
-   phpMyAdmin:<http://localhost:8080/>
