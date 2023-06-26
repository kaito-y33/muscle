@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>ユーザー編集</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('users.edit', ['user' => $user->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-7">
                                    <label for="name" class="text-center">名前</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') ?? $user->name }}">
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-7">
                                    <label for="email" class="text-center">メールアドレス</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') ?? $user->email }}">
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-7 text-right">
                                    <button type="submit" class="btn btn-primary">更新する</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">戻る</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
