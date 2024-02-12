<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Exercise;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;

use function PHPUnit\Framework\returnSelf;

class HomeController extends Controller
{
    const ONE_MONTH_PERIOD = 1;
    const THREE_MONTH_PERIOD = 2;
    const SIX_MONTH_PERIOD = 3;

    /**
     * ホーム画面の表示.
     */
    public function index()
    {
        // カテゴリー情報を全取得.
        $categories = Category::all();

        // 表示期間
        $periods = [
            [
                'id' => self::ONE_MONTH_PERIOD,
                'name' => '1ヶ月',
            ],
            [
                'id' => self::THREE_MONTH_PERIOD,
                'name' => '3ヶ月',
            ],
            [
                'id' => self::SIX_MONTH_PERIOD,
                'name' => '6ヶ月',
            ],
        ];

        // グラフ用データの取得
        $chartData = $this->fetchChartData(self::ONE_MONTH_PERIOD, $categories->first()->id);

        return view('home', compact('categories', 'periods', 'chartData'));
    }

    public function GetChartDataAjax(Request $request)
    {
        //カテゴリと表示期間を設定する
        $category = $request->input('category');
        $period = $request->input('period');

        //グラフデータを取得する
        $chartData = $this->fetchChartData($period, $category);

        //データをJSON形式で返却
        return response()->json($chartData);
    }

    /**
     * グラフデータを取得する
     *
     * @param [type] $period
     * @param [type] $categoryId
     * @return array
     */
    private function fetchChartData($period, $categoryId)
    {
        // ログインユーザID取得
        $userId = Auth()->user()->id;

        // 現在から指定期間前日時を取得
        $dueDate = self::GetPeriodTime($period, Carbon::now());

        // 対象期間のトレーニング記録を取得
        $days = DB::table('exercises')
            ->select('date')
            ->where('user_id', $userId)
            ->where('date', '>=', $dueDate)
            ->distinct()
            ->get();

        //グラフデータ作成
        $data = [];
        foreach ($days as $day) {
            $exercises = Exercise::where('user_id', $userId)
                ->where('date', $day->date)
                ->whereHas('training', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->with('training')
                ->with('rep')
                ->with('weight')
                ->get();

            $data[] = [
                'date' => $day->date,
                'rm' => $exercises->sum(function ($exercise) {
                    return $exercise->weight->weight * $exercise->rep->rep;
                }),
            ];
        }

        return $data;
    }

    /**
     * 現在から指定期間前の日時を取得する
     *
     * @param [type] $period
     * @param [type] $date
     * @return DateTime
     */
    private function GetPeriodTime($period, $date)
    {
        switch ($period) {
            case self::ONE_MONTH_PERIOD:
                $date->modify('-1 month');
                break;
            case self::THREE_MONTH_PERIOD:
                $date->modify('-3 month');
                break;
            case self::SIX_MONTH_PERIOD:
                $date->modify('-6 month');
                break;
            default:
                break;
        }

        return $date;
    }
}
