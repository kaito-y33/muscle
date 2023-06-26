@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('トレーニング情報追加') }}</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('trainings.create') }}" method="post">
                        @csrf
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-7">
                                <label for="category_id" class="control-label form-row">{{ __('部位カテゴリ') }}</label>
                                <select name="category_id" id="category_id" class="form-select input-sm">
                                    <option value="">-- 選択してください --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-7">
                                <label for="name" class="control-label">{{ __('トレーニング名') }}</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-7">
                                <label for="description" class="control-label">{{ __('トレーニング内容') }}</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-7 text-right">
                                <button type="submit" class="btn btn-primary">{{ __('追加する') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
