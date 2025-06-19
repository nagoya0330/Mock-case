# Mock-case
フリマアプリ

環境構築 　Dockerビルド 
1.git clone git@github.com:coachtech-material/laravel-docker-template.git 
2.docker-compose up -d --build

Lavel環境構築 
1.docker-compose exec php bash 
2.composer install 
3..env.exampleファイルから.envファイルを作成し、環境変数を変更 
4.php artisan key:generate 
5.php artisan migrate
6.php artisan db:seed

使用技術 言語：PHP ^7.3 / ^8.0 フレームワーク：Laravel 8.75 以上 認証：Laravel Fortify 1.19 以上 mysql 8.0.26

URL

開発環境
商品一覧画面（トップ画面）：http //localhost
商品一覧画面（トップ画面）_マイリスト：http //localhost/?page=mylist 
会員登録画面：http //localhost/register
ログイン画面：http //localhost/login 
商品詳細画面：http //localhost/item/:item_id 
商品購入画面：http //localhost/purchase/:item_id
送付先住所変更画面：http //localhost/purchase/address/:item_id
商品出品画面：http //localhost/sell
プロフィール画面：http //localhost/mypage
プロフィール編集画面（設定画面）：http //localhost/mypage/profile
プロフィール画面_購入した商品一覧：http //localhost/mypage?page=buy
プロフィール画面_出品した商品一覧：http //localhost/mypage?page=sell

phpMyAdmin：http://localhost:8080/

![image](https://github.com/user-attachments/assets/256478f1-f292-4460-b710-88d064790a07)



