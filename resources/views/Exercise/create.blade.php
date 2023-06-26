@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('トレーニング記録追加') }}</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    @if ($errors->any())
                        <div class="alert text-danger">
                            @foreach ($errors->all() as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('exercise.create') }}" method="post">
                        @csrf
                        <div class="row">
                            <p class="font-weight-bold">{{ __('<実施日>') }}</p>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="col-md-2 text-center">
                                        <label for="date" class="control-label">{{ __('実施日') }}</label>
                                    </th>
                                    <td class="col-md-8">
                                        <input type="date" name="date" id="date" class="form-control col-md-4"
                                            value="{{ old('date') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <p class="font-weight-bold">{{ __('<詳細>') }}</p>
                        </div>
                        <table class="table table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th class="col-md-4 text-center">
                                        <label for="training_id">{{ __('トレーニング種目') }}</label>
                                    </th>
                                    <th class="col-md-2 text-center">
                                        <label for="count">{{ __('回数') }}</label>
                                    </th>
                                    <th class="col-md-2 text-center">
                                        <label for="weight">{{ __('重量') }}</label>
                                    </th>
                                    <th class="col-md-2 text-center">
                                        <label for="distance">{{ __('距離') }}</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                    <input type="text" name="trainingName[]" id="trainingName[]" class="form-control"
                                        disabled value="{{ old('trainingName') }}">
                                    <a class="btn btn-secondary pull-right" id="btnForSearch"><i
                                            class="bi bi-search"></i></a>
                                    <input type="hidden" name="trainingId[]" id="trainingId[]"
                                        value="{{ old('trainingId') }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="rep[]" id="rep[]">
                                    <span class="pull-right"><strong>回</strong></span>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="weight[]" id="weight[]">
                                    <span class="pull-right"><strong>kg</strong></span>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="distance[]" id="distance[]">
                                    <span class="pull-right"><strong>km</strong></span>
                                </td>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger pull-right" name="btnForRemoveDetail"
                                id="btnForRemoveDetail">{{ __('詳細行削除') }}</button>
                            <button type="button" class="btn btn-secondary pull-right" name="btnForAddDetail"
                                id="btnForAddDetail">{{ __('詳細行追加') }}</button>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="登録">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- モーダルウィンドウ --}}
    @include('components.modal_window')
@endsection

@section('script')
    <script>
        AddExerciseDetail("#btnForAddDetail", "#detailTable");
        RemoveExerciseDetail("#btnForRemoveDetail", "#detailTable");
        GetTrainingName("#btnForSearch", "trainingId", "trainingName");
    </script>
@endsection
