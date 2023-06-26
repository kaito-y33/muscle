@extends('layouts.admin')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h3 class="text-left">ユーザー管理</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ユーザーID</th>
                <th>名前</th>
                <th>メールアドレス</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm">編集</a>
                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-danger" onclick="return confirm('本当に削除してもよろしいですか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-1 mb-1 row justify-content-center">
        {{ $users->links() }}
    </div>
@endsection
