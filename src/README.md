# attendance-system

## 概要説明

<img width="600" alt="スクリーンショット 2024-02-25 21 46 00" src="https://github.com/hase-taka/attendance-form/assets/148784913/fbd9a89b-70ec-4f0b-8d10-944717835786">

ユーザーの勤務時間・休憩時間を記録するシステムを作成しました。

## 作成目的

企業から勤怠管理のデジタル化依頼を受けたため。

## アプリケーション URL

## 機能一覧

-   登録・ログイン機能
-   打刻機能
-   ユーザーの日付での勤務状況一覧
-   ユーザー一覧
-   ユーザー毎の勤怠一覧

## 使用技術

-   PHP 7.49
-   Laravel 8.83.8
-   Mysql 8.0.26

## テーブル設計

<img width="600" alt="スクリーンショット 2024-02-25 21 48 20" src="https://github.com/hase-taka/attendance-form/assets/148784913/4792489b-668b-4513-8be8-71a6755593f3">

## ER 図

<img width="600" alt="スクリーンショット 2024-02-25 21 22 50" src="https://github.com/hase-taka/attendance-form/assets/148784913/49dd0319-3c33-47fb-ac01-b2068f4491bb">

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
