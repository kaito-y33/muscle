@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th class="col-md-2">
                        <label for="category" class="form-label">部位カテゴリ</label>
                    </th>
                    <td>
                        <div class="form-group">
                            <select name="category" id="category" class="form-select input-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="col-md-2">
                        <label for="period" class="form-label">表示期間</label>
                    </th>
                    <td>
                        <select name="period" id="period" class="form-select input-sm">
                            @foreach ($periods as $period)
                                <option value="{{ $period['id'] }}" {{ old('period') == $period['id'] ? 'selected' : '' }}>
                                    {{ $period['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            <div>
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>

    <script type="text/javascript">
        $(document).ready(function() {
            var myChart; // チャートを格納する変数

            ChartGraph(@json($chartData));

            $('#category').change(function() {
                updateGraphData();
            })

            $('#period').change(function() {
                updateGraphData();
            })

            function ChartGraph(chartData) {
                if (myChart) {
                    myChart.destroy();
                }

                // Chart.jsとデータの設定
                var canvas = document.getElementById('myChart');
                var ctx = canvas.getContext('2d');

                // ChartDataをぶん回して、日付の配列とRM値の配列の２つを作成する
                var labels = [];
                var values = [];
                $.each(chartData, function(i, element) {
                    labels.push(element.date);
                    values.push(element.rm);
                })

                // グラフの描画
                myChart = new Chart(ctx, {
                    type: 'line', // グラフタイプ
                    data: {
                        labels: labels, //グラフのラベル(x軸の値)
                        datasets: [{
                            label: "最大挙上重量推移",
                            data: values, //グラフのデータ(y軸の値)
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', //バーの背景色
                            borderColor: 'rgba(75, 192, 192, 1)', //バーの枠線色
                            borderWidth: 2, //バーの枠線幅
                        }]
                    },
                    options: {
                        responsive: true, //グラフサイズを自動的に調整するかどうか
                        title: {
                            display: true,
                            text: 'トレーニング推移'
                        },
                        legend: { //凡例設定
                            display: false //表示設定
                        },
                        scales: {
                            xAxes: {
                                scaleLabel: {
                                    display: true,
                                    labelString: 'RM値',
                                    fontColor: 'red',
                                    fontSize: 16
                                }
                            },
                            yAxes: {
                                scaleLabel: {
                                    display: true,
                                    labelString: '日付',
                                    fontColor: 'red',
                                    fontSize: 16
                                }
                            }
                        }
                    }
                });
            }

            function updateGraphData() {
                var category = $('#category').val();
                var period = $('#period').val();

                //Ajaxリクエストを送信
                $.ajax({
                    method: 'GET',
                    url: '{{ route('home.ajax') }}',
                    data: {
                        category: category,
                        period: period
                    },
                    success: function(response) {
                        ChartGraph(response);
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }
        })
    </script>
@endsection
