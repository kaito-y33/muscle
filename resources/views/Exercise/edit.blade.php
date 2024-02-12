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
                    <form action="{{ route('exercise.update', ['date' => $date]) }}" method="post">
                        @csrf
                        <div class="row">
                            <p class="font-weight-bold">{{ __('<実施日>') }}</p>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <th class="col-md-2 text-center">
                                    <label for="date" class="control-label">{{ __('実施日') }}</label>
                                </th>
                                <td class="col-md-8">
                                    <input type="date" name="date" id="date" class="form-control col-md-4"
                                        value="{{ old('date') ?? $date }}">
                                </td>
                            </tbody>
                        </table>
                        <div class="row">
                            <p class="font-weight-bold">{{ __('<詳細>') }}</p>
                        </div>
                        <table class="table table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th class="col-md-4 text-center">
                                        <label for="trainingId">{{ __('トレーニング種目') }}</label>
                                    </th>
                                    <th class="col-md-2 text-center">
                                        <label for="rep">{{ __('回数') }}</label>
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
                                @foreach ($records as $record)
                                    <tr>
                                        <td>
                                            <input type="text" name="trainingName[]" id="trainingName[]"
                                                class="form-control"
                                                value="{{ old('trainingName') ?? $record['trainingName'] }}" disabled>
                                            <a class="btn btn-secondary pull-right" id="btnForSearch">
                                                <i class="bi bi-search"></i>
                                            </a>
                                            <input type="hidden" name="trainingId[]" id="trainingId[]"
                                                value="{{ old('trainingId') ?? $record['trainingId'] }}">
                                        </td>
                                        <td>
                                            <input type="text" name="rep[]" id="rep[]" class="form-control"
                                                value="{{ old('rep') ?? $record['rep'] }}">
                                            <span class="pull-right"><strong>{{ __('回') }}</strong></span>
                                            <input type="hidden" name="repId[]" id="repId[]"
                                                value="{{ $record['repId'] }}">
                                        </td>
                                        <td>
                                            <input type="text" name="weight[]" id="weight[]" class="form-control"
                                                value="{{ old('weight') ?? $record['weight'] }}">
                                            <span class="pull-right"><strong>{{ __('Kg') }}</strong></span>
                                            <input type="hidden" name="weightId[]" id="weightId[]"
                                                value="{{ $record['weightId'] }}">
                                        </td>
                                        <td>
                                            <input type="text" name="distance[]" id="distance[]" class="form-control"
                                                value="{{ old('distance') ?? $record['distance'] }}">
                                            <span class="pull-right"><strong>{{ __('Km') }}</strong></span>
                                            <input type="hidden" name="distanceId[]" id="distanceId[]"
                                                value="{{ $record['distanceId'] }}">
                                        </td>
                                        <input type="hidden" name="exerciseId[]" id="exerciseId[]"
                                            value="{{ $record['exerciseId'] }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="button" class="btn btn-xs btn-danger ml-2 pull-right" id="btnForRemoveDetail"
                                name="btnForRemoveDetail">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-info ml-2 pull-right" id="btnForAddDetail"
                                name="btnForAddDetail">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group">
                            <a class="btn btn-info" href="{{ route('exercise.index') }}">戻る</a>
                            <input type="submit" class="btn btn-primary" value="登録">
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
        $(document).ready(function() {
            AddExerciseDetail("#btnForAddDetail", "#detailTable");
            RemoveExerciseDetail("#btnForRemoveDetail", "#detailTable");
            GetTrainingName("#btnForSearch", "trainingId", "trainingName");
        })
    </script>
@endsection
