# attendance-system

## 概要説明

<img width="200" alt="スクリーンショット 2024-02-17 0 24 32" src="https://github.com/hase-taka/attendance-form/assets/148784913/0660615f-3fae-4ec5-ac5b-1a42f29bf76f">

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

<img width="200" alt="スクリーンショット 2024-02-17 21 01 04" src="https://github.com/hase-taka/attendance-form/assets/148784913/649e7dee-e4f1-4462-ae23-b3d399d08c86">

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
