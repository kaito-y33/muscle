function AddExerciseDetail(buttonId, tableId) {
    $(document).ready(function () {
        $(buttonId).click(function () {
            // トレーニング詳細行追加ボタン押下時
            const tableElement = $(tableId);
            // テーブル末尾行取得.
            var row = tableElement.children("tbody").children().last().clone();
            // 入力欄を空欄にして、行追加.
            row.find("input:text").val("");
            tableElement.children("tbody").append(row);
        });
    });
}

function RemoveExerciseDetail(buttonId, tableId) {
    $(document).ready(function () {
        // トレーニング詳細行削除ボタン押下時
        $(buttonId).click(function () {
            const tableElement = $(tableId);
            // 1行しか無い場合は削除しない(ヘッダ除く).
            var rowCount = tableElement.children("tbody").children().length;
            if (rowCount == 1) {
                return alert("これ以上行削除出来ません。");
            }
            // テーブル末尾行削除.
            tableElement.children("tbody").children().eq(-1).remove();
        });
    });
}

function GetTrainingName(triggerButtonId, targetCodeId, targetNameId) {
    var nameTarget;
    var codeTarget;
    $(document).ready(function () {
        $(document).on("click", triggerButtonId, function () {
            // 虫眼鏡ボタン押下行のトレーニング種目列取得.
            nameTarget = $(this)
                .closest("td")
                .find("[id^=" + targetNameId + "]");
            codeTarget = $(this)
                .closest("td")
                .find("[id^=" + targetCodeId + "]");

            // ボタンからフォーカスを外す.
            $(this).blur();

            // オーバーレイを出現させる.
            $("#modal-overlay").show();

            // コンテンツをセンタリングする.
            CenteringModalSyncr();

            // コンテンツをフェードインする.
            $("#modal-content").show();
        });

        // OKボタンにイベント追加.
        $("#modal-ok").click(function () {
            var id = $('input[type="hidden"][id="training_id"]').val();
            var name = $('input[type="hidden"][id="training_name"]').val();
            codeTarget.val(id);
            nameTarget.val(name);
            $("#modal-overlay").hide();
            return false;
        });

        // 「キャンセル」「✕」ボタン押下でモーダルを閉じる.
        $("#modal-close, #modal-cancel")
            .unbind()
            .click(function () {
                $("#modal-overlay").hide();
            });

        // リサイズされたら、センタリング関数を実行する.
        $(window).resize();
    });
}

// センタリングを実行する関数.
function CenteringModalSyncr() {
    // 画面幅を取得.
    var width = $(window).width();
    var height = $(window).height();

    // モーダルの幅を取得.
    var contentWidth = $("#modal-content").outerWidth();
    var contentHeight = $("#modal-content").outerHeight();

    // センタリング実行.
    $("#modal-content").css({
        left: (width - contentWidth) / 2 + "px",
        top: (height - contentHeight) / 2 + "px",
    });
}
