@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col col-md-offset-3 col-md-6">
            <nav class="panel panel-default">
                <div class="panel-heading">会員登録</div>
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('ユーザー名') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('メールアドレス') }}</label>
                            <input type="text" class="form-control" name="email" id="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('パスワード') }}</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __('パスワード（確認）') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ __('送信') }}</button>
                        </div>
                    </form>
                </div>
            </nav>
        </div>
    </div>
@endsection
