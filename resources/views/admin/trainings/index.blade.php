@extends('layouts.admin')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h3 class="text-left">トレーニング管理</h3>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>トレーニング名</th>
                    <th>トレーニング内容</th>
                    <th>部位</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        <td>{{ $training->name }}</td>
                        <td>{{ $training->description }}</td>
                        <td>{{ $training->category->name }}</td>
                        <td>
                            <a href="{{ route('trainings.edit', ['training' => $training->id]) }}"
                                class="btn btn-sm btn-info">編集</a>
                            <form action="{{ route('trainings.destroy', ['training' => $training->id]) }}" method="post"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" onclick="return confirm('本当に削除してもよろしいですか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('trainings.create') }}" class="btn btn-sm btn-primary">メニュー追加</a>
    <div class="mt-1 mb-1 row justify-content-center">
        {{ $trainings->links() }}
    </div>
@endsection
