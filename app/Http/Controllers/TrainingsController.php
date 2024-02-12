<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Training;
use App\Http\Requests\CreateTraining;
use App\Http\Requests\EditTraining;
use Illuminate\Support\Facades\DB;

class TrainingsController extends Controller
{
    /**
     * トレーニング一覧の表示.
     *
     * @return View
     */
    public function index()
    {
        // 全トレーニング種目を取得
        $trainings = Training::orderby('category_id', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.trainings.index', compact('trainings'));
    }

    /**
     * トレーニング情報新規作成画面の表示.
     *
     * @return View
     */
    public function create()
    {
        // カテゴリー情報を全取得.
        $categories = Category::all();
        // トレーニング情報新規作成画面を表示.
        return view('admin.trainings.create', compact('categories'));
    }

    /**
     * トレーニング情報の新規作成.
     *
     * @param CreateTraining $request
     * @return View
     */
    public function store(CreateTraining $request)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();

            // トレーニング情報を新規追加.
            $training = new Training();
            $training->fill($request->all())->save();
            DB::commit();

            // トレーニング情報一覧にリダイレクト.
            return redirect()->route('trainings.index')->with('message', 'トレーニング情報が正常に登録されました。');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * トレーニング情報編集画面の表示.
     *
     * @param Training $training
     * @return View
     */
    public function edit(Training $training)
    {
        // 部位情報を全取得.
        $categories = Category::all();
        // トレーニング情報編集画面を表示.
        return view('admin.trainings.edit', compact('training', 'categories'));
    }

    /**
     * トレーニング情報の更新.
     *
     * @param Training $training
     * @param EditTraining $request
     * @return View
     */
    public function update(Training $training, EditTraining $request)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();

            // トレーニング情報の更新.
            $training->fill($request->all())->save();
            DB::commit();

            // トレーニング情報一覧画面へ遷移.
            return redirect()->route('trainings.index')->with('message', 'トレーニング情報が正常に更新されました。');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * トレーニング情報の削除.
     *
     * @param Training $training
     * @return VIew
     */
    public function destroy(Training $training)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();

            // トレーニング情報の削除.
            $training->delete();
            DB::commit();

            // トレーニング一覧を表示.
            return redirect()->route('trainings.index')->with('message', 'トレーニング情報が正常に削除されました。');
        } catch (\Throwable $th) {
            // ロールバック.
            DB::rollBack();
        }
    }
}
