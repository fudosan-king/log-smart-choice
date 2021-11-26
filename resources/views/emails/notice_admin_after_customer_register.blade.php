Order Renoveで新規会員登録がありました。<br>
管理画面にアクセスして、内容を確認しましょう。<br>
登録日時：{{ $data['created_at'] }} <br>
@if($data['customer']['email'])
メールアドレス：{{ $data['customer']['email'] }} <br>
@else
メールアドレス： <br>
@endif