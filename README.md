# フリマアプリ

---

## 【環境構築】

### ◾️ Dockerビルド  
1. `git clone git@github.com:nagoya0330/Mock-case.git`    
2. `docker-compose up -d --build`  

### ◾️ Laravel環境構築  
1. `docker-compose exec php bash`  
2. `composer install`  
3. `.env.example` を `.env` にコピーして環境変数を設定  
4. `php artisan key:generate`  
5. `php artisan migrate`  
6. `php artisan db:seed`
7. `php artisan storage:link` 

---

## 【使用技術】

- 言語：PHP ^7.3 / ^8.0  
- フレームワーク：Laravel 8.75以上  
- 認証：Laravel Fortify 1.19以上  
- データベース：MySQL 8.0.26  
- インフラ：Docker
- phpMyAdmin：http://localhost:8080/
- 決済：Stripe

---

## 【メール認証（Mailtrap）について】

本アプリでは、**ユーザー登録時にメール認証が必須**です。  
MailtrapをSMTPとして使用しています。  
本アプリでは メール認証機能 を導入しており、Mailtrap を使用して検証を行います。
.env ファイルに Mailtrap のSMTP情報を記載してください  
メール認証画面にて「認証はこちらから」をクリック後、Mailtrap のダッシュボード上で、送信された確認メールのリンクをクリックし認証を完了してください  
ログインURL：https://mailtrap.io  
メールアドレス：furimaapuri24@gmail.com  
ログインパスワード：Test13579!!!  

### ◾️ Mailtrapの設定手順  

1. [Mailtrap](https://mailtrap.io/) に登録  
2. ダッシュボードの「Sandbox」→「SMTP Settings」から情報を確認  
3. `.env` ファイルに以下を設定：

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=（Mailtrapで発行されたユーザー名）
MAIL_PASSWORD=（Mailtrapで発行されたパスワード）
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Laravel App"  
```

※ 実際のユーザー名・パスワードは ダッシュボードをご確認ください

---  

## 【開発環境（URL）】        
商品一覧（トップ画面）	http://localhost  
会員登録	http://localhost/register  
ログイン	http://localhost/login

---

## 【単体テストについて】   

全体テストを実行    
docker-compose exec php php artisan test --env=testing 

特定ファイルのみに絞って実行（例：ExhibitionTest）    
docker-compose exec php php artisan test --env=testing --filter=ExhibitionTest
その他のテストも同様に tests/Feature/ ディレクトリ内に記述。  

## 【テスト実行前の準備】  

1.env.testingの確認  
.env.testing には、本番DBとは別の test DB (例: demo_test) を指定  

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root  
```
2.テストDBの作成  
docker-compose exec mysql mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS demo_test;"   

3.マイグレーション&シード  
docker-compose exec php php artisan migrate:fresh --seed --env=testing  

##【補足情報】  
Laravelは php artisan test 実行時に .env.testingを優先読みします

---  

## 【Stripeによる決済処理について】  
商品購入時、「購入する」ボタンを押すと Stripe の決済ページに遷移します。  
**すべての商品は一律「50円」**での決済となっています（テスト用）  
商品価格の値は現在決済に反映されません  

---

![スクリーンショット 2025-06-19 194927](https://github.com/user-attachments/assets/be80ae75-faab-4d7d-b4d6-bfada9007182)



