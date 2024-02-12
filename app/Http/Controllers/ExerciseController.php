<?php

namespace App\Http\Controllers;

use App\Models\Distance;
use App\Models\Exercise;
use App\Models\Rep;
use App\Models\Set;
use App\Models\Training;
use App\Models\Weight;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use function Psy\debug;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ResponseSequence;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('Exercise.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // トレーニング種目全取得.
        $trainings = Training::all()->sortBy('category_id');

        // トレーニング記録作成.
        return View('Exercise.create', compact(
            'trainings',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ログインユーザID取得.
        $user = Auth()->user()->id;

        // リクエストから値取得.
        $trainings = $request->trainingId;
        $reps = $request->rep;
        $weights = $request->weight;
        $distances = $request->distance;
        $date = $request->date;

        // トランザクション開始.
        DB::beginTransaction();

        // トレーニング記録数分DB保存.
        Log::emergency($trainings);
        for ($i = 0; $i < count($trainings); $i++) {
            // Exercisesテーブルへ.
            $exercise = new Exercise();
            $exercise->fill([
                'date' => $date,
                'training_id' => $trainings[$i],
                'user_id' => $user,
            ])->save();
            // トレーニング記録IDを取得.
            $relatedId = $exercise->id;
            // Setテーブルへ.
            $set = new Rep();
            $set->fill([
                'exercise_id' => $relatedId,
                'rep' => $reps[$i] ?? 0,
            ])->save();
            // Weightテーブルへ.
            $weight = new Weight();
            $weight->fill([
                'exercise_id' => $relatedId,
                'weight' => $weights[$i] ?? 0,
            ])->save();
            // Distanceテーブルへ.
            $distance = new Distance();
            $distance->fill([
                'exercise_id' => $relatedId,
                'distance' => $distances[$i] ?? 0,
            ])->save();
        }
        // コミット.
        DB::commit();
        // リクエスト処理.
        return redirect(route('exercise.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit($date)
    {
        // ログインユーザー取得.
        $userId = Auth()->user()->id;
        // 選択した日付のExercise情報を取得.
        $exercises = Exercise::where('user_id', $userId)->where('date', $date)->orderBy('id')->get();

        // 画面表示用に格納.
        $records = [];
        foreach ($exercises as $exercise) {
            $record = [
                'exerciseId' => $exercise->id,
                'trainingId' => $exercise->training->id,
                'trainingName' => $exercise->training->name,
                'repId' => $exercise->rep->id,
                'rep' => $exercise->rep->rep,
                'weightId' => $exercise->weight->id,
                'weight' => $exercise->weight->weight,
                'distanceId' => $exercise->distance->id,
                'distance' => $exercise->distance->distance,
            ];
            $records[] = $record;
        }

        // 子画面用のトレーニング情報一覧取得.
        $trainings = Training::all();

        return View('Exercise.edit', compact(
            'date',
            'records',
            'trainings',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(string $date, Request $request)
    {
        // ログインユーザー取得.
        $userId = Auth()->user()->id;
        // 更新レコード取得.
        $records = [];
        for ($i = 0; $i < count($request->exerciseId); $i++) {
            $record = [
                'exerciseId' => $request->exerciseId[$i],
                'trainingId' => $request->trainingId[$i],
                'repId' => $request->repId[$i],
                'rep' => $request->rep[$i],
                'weightId' => $request->weightId[$i],
                'weight' => $request->weight[$i],
                'distanceId' => $request->distanceId[$i],
                'distance' => $request->distance[$i],
            ];
            $records[] = $record;
        }
        // DB更新.
        try {
            // トランザクション開始.
            DB::beginTransaction();
            // レコード数分DB保尊.
            foreach ($records as $record) {
                // Exerciseテーブル更新.
                $exercise = Exercise::where('id', $record['exerciseId'])->where('date', $date);
                $exercise->update([
                    'training_id' => $record['trainingId'],
                ]);
                // Repテーブル更新.
                $rep = Rep::where('id', $record['repId']);
                $rep->update([
                    'rep' => $record['rep'],
                ]);
                // Weightテーブル更新.
                $weight = Weight::where('id', $record['weightId']);
                $weight->update([
                    'weight' => $record['weight'],
                ]);
                // Distanceテーブル更新.
                $distance = Distance::where('id', $record['distanceId']);
                $distance->update([
                    'distance' => $record['distance'],
                ]);
            }
            // コミット.
            DB::commit();

            return redirect(route('exercise.index'));
        } catch (Throwable $ex) {
            Log::emergency($ex->getMessage());
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercise $exercise)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();
            // Exercise情報の削除.
            $exercise->rep()->delete();
            $exercise->weight()->delete();
            $exercise->distance()->delete();
            $exercise->delete();
            DB::commit();
            // Exercise情報一覧にリダイレクト.
            return redirect()->route('exercise.index')->with('message', 'Exercise情報が正常に削除されました。');
        } catch (QueryException $e) {
            // ロールバック.
            dd($e);
            DB::rollBack();
        }
    }

    /**
     * Exercise情報の追加表示行取得
     *
     * @param Request $request
     * @return void
     */
    public function getAddDisplayExercises(Request $request)
    {
        // ログイン中のユーザーを特定.
        $user = Auth()->user()->id;

        // 1ページ当たりの表示件数
        $perPage = 10;
        // リクエストから現在のページ数取得
        $page = $request->query('page', 1);

        // Exercise情報取得
        $exercises = Exercise::where('user_id', $user)
            ->with('training', 'rep', 'weight', 'distance')
            ->orderBy('date', 'desc')
            ->orderBy('id')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // 返却用に値設定
        $data = [];
        foreach ($exercises as $exercise) {
            $record = [
                'date' => $exercise->date,
                'training' => $exercise->training->name,
                'rep' => $exercise->rep->rep,
                'weight' => $exercise->weight->weight,
                'distance' => $exercise->distance->distance,
                'editUrl' => route('exercise.edit', ['date' => $exercise->date]),
                'deleteUrl' => route('exercise.destroy', ['exercise' => $exercise->id]),
            ];
            $data[] = $record;
        }

        // Json形式で返却
        return response()->json([
            'data' => $data,
        ]);
    }
}
