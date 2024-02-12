<div id="modal-overlay">
    <div id="modal-content">
        <div id="modal_open">
            <div id="modal_header" class="text-right">
                <a id="modal-close" class="button-link">{{ __('✕') }}</a>
            </div>
            <h5 class="text-left">{{ __('トレーニング種目選択') }}</h5>
            <div style="height:250px; overflow:scroll">
                <table class="table table-bordered">
                    <thead>
                        <th class="col-1">
                        </th>
                        <th>
                            <label for="category_name">{{ __('部位') }}</label>
                        </th>
                        <th>
                            <label for="name">{{ __('トレーニング種目') }}</label>
                        </th>
                        <th>
                            <label for="description">{{ __('種目説明') }}</label>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($trainings as $training)
                            <tr>
                                <td>
                                    <input type="radio" id="radioTrainingId" name="radioTrainingId"
                                        value="{{ $training->id }}">
                                </td>
                                <td>{{ $training->category->name }}</td>
                                <td>{{ $training->name }}</td>
                                <td>{{ $training->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="training_name" id="training_name">
            <input type="hidden" name="training_id" id="training_id">
            <a id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">{{ __('キャンセル') }}</a>
            <a id="modal-ok" class="btn btn-primary">{{ __('OK') }}</a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // ラジオボタンにイベント追加.
        $(document).on("click", "#radioTrainingId", function() {
            // 押下行のトレーニングID,名称を取得.
            var id = $(this).val();
            var name = $(this).closest("tr").children("td").eq(2).text();
            // 親画面返却用に保持.
            $('input[type="hidden"][id="training_id"]').val(id);
            $('input[type="hidden"][id="training_name"]').val(name);
        });
    })
</script>
<style>
    #modal-content {
        width: 50%;
        height: 50%;
        margin: 0;
        padding: 10px 20px;
        border: 2px solid #aaa;
        background: #fff;
        position: fixed;
        display: none;
        z-index: 2;
    }

    #modal-overlay {
        width: 100%;
        height: 120%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.75);
        position: fixed;
        display: none;
        z-index: 1;
    }

    .button-link {
        color: #00f;
        text-decoration: underline;
    }

    .button-link:hover {
        cursor: pointer;
        color: #f00;
    }

    #modal-footer {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
</style>
