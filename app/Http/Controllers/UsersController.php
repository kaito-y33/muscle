<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = 10;
        $users = User::orderBy('id')->paginate($per_page);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showEditForm(User $user)
    {
        // ユーザー情報編集画面を表示.
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, EditUser $request)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();

            // ユーザー情報更新.
            $user->fill($request->all())->save();
            DB::commit();

            // ユーザ情報一覧にリダイレクト.
            return redirect()->route('users.index')->with('message', 'ユーザー情報が正常に更新されました。');
        } catch (\Throwable $th) {
            // ロールバック.
            DB::rollBack();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            // トランザクション開始.
            DB::beginTransaction();

            // ユーザー情報の削除.
            $user->delete();
            DB::commit();

            // ユーザー情報一覧にリダイレクト.
            return redirect()->route('users.index')->with('message', 'ユーザー情報が正常に削除されました。');
        } catch (\Throwable $th) {
            // ロールバック.
            DB::rollBack();
        }
    }
}
