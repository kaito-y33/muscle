@extends('layouts.layout')

@section('content')
    <h3 class="text-left">トレーニング記録一覧</h3>
    <div id="scrollable-table" style="height:300px; overflow:scroll">
        <table id="exercise-table" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">日付</th>
                    <th class="text-center">トレーニング種目</th>
                    <th class="text-center">回数</th>
                    <th class="text-center">重量</th>
                    <th class="text-center">距離</th>
                    <th class="text-center">編集/削除</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <a href="{{ route('exercise.create') }}" class="btn btn-sm btn-primary">記録追加</a>
@endsection

@section('script')
    <script type="text/javascript">
        // 現在のページ
        var page = 1;

        function fetchExercises(page) {
            $.ajax({
                // データ取得するURLを指定
                url: '{{ route('exercise.ajax') }}',
                type: 'GET',
                data: {
                    page: page //ページ数をリクエストに含める
                }
            }).done(function(response) {
                var exercises = response.data;
                var table = $('#exercise-table').find('tbody');
                exercises.forEach(function(exercise) {
                    var lastDate = table.find('tr').eq(-1).find('td').eq(0).text();
                    date = (lastDate == exercise.date) ? "" : exercise.date;
                    lastDate = exercise.date;
                    // 新しい行をテーブルに追加
                    var row = '<tr>' +
                        '<td style="display: none;">' + lastDate + '</td>' +
                        '<td>' + date + '</td>' +
                        '<td>' + exercise.training + '</td>' +
                        '<td class="text-right">' + exercise.rep + '</td>' +
                        '<td class="text-right">' + exercise.weight + '</td>' +
                        '<td class="text-right">' + exercise.distance + '</td>' +
                        '<td class="text-center">' +
                        '<a href="' + exercise.editUrl +
                        '" class="btn p-0 bg-transparent border-0 text-info"><i class="bi bi-pencil"></i></a>' +
                        '<form action="' + exercise.deleteUrl +
                        '" method="post" class="d-inline px-2">' +
                        '@csrf' +
                        '<button class="btn p-0 bg-transparent border-0 text-danger" onclick="return confirm(\'本当に削除してもよろしいですか？\')"><i class="bi bi-trash"></i></button>' +
                        '</form>' +
                        '</td>' +
                        '</tr>';
                    table.append(row);
                })
            }).fail(function() {
                alert("失敗");
            });
        }

        $(document).ready(function() {
            //最初のページ読み込み
            fetchExercises(page);
            //スクロールイベントの監視
            $('#scrollable-table').scroll(function() {
                var scrollHeight = $('#scrollable-table')[0].scrollHeight;
                var scrollTop = $('#scrollable-table').scrollTop();
                var clientHeight = $('#scrollable-table').height();
                //ページの下までスクロールしたら次のページのデータ取得
                if (scrollTop + clientHeight >= scrollHeight) {
                    page++;
                    fetchExercises(page);
                }
            })
        })
    </script>
@endsection
