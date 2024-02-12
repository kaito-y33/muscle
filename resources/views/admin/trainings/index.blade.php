@extends('layouts.admin')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h3 class="text-left">トレーニング管理</h3>
    <div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="text-center" width="100px">部位</th>
                    <th class="text-center" width="225px">トレーニング名</th>
                    <th class="text-center" width="700px">トレーニング内容</th>
                    <th class="text-center" width="100px">編集/削除</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        <td class="text-center">{{ $training->category->name }}</td>
                        <td>{{ $training->name }}</td>
                        <td>{{ $training->description }}</td>
                        <td class="text-center">
                            <a href="{{ route('trainings.edit', ['training' => $training->id]) }}"
                                class="btn p-0 bg-transparent border-0 text-info"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('trainings.destroy', ['training' => $training->id]) }}" method="post"
                                class="d-inline">
                                @csrf
                                <button class="btn p-0 bg-transparent border-0 text-danger"
                                    onclick="return confirm('本当に削除してもよろしいですか？')"><i class="bi bi-trash"></i></button>
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
