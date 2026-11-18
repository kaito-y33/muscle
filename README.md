# muscle — 筋トレ記録Webアプリ

日々の筋力トレーニングを記録し、グラフで振り返るためのWebアプリです（2023年・個人開発）。

## 主な機能
- ログイン認証
- トレーニング記録の登録・編集・削除（日付単位）
- ホーム画面で記録をグラフ表示（Chart.js）
- 管理者画面
  - ユーザー管理（一覧・編集・削除）
  - トレーニング種目マスタの管理（登録・編集・削除）

## 技術スタック
- PHP 8 / Laravel 9
- MySQL
- Blade / Bootstrap / Chart.js
- Vite

## ローカルでの起動手順
```bash
git clone https://github.com/kaito-y33/muscle.git
cd muscle
composer install
cp .env.example .env
php artisan key:generate
# .env の DB_DATABASE / DB_USERNAME / DB_PASSWORD を環境に合わせて設定
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```

## テスト用アカウント
- メール：Test11@email.com 〜 Test30@email.com
- パスワード：password

管理者画面を使う場合は、対象ユーザーの role を 1 に変更してください。
```sql
UPDATE users SET role = 1 WHERE email = 'Test11@email.com';
```
