<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    // 打刻ページの表示
    public function punch()
    {
        // 現在の日付とユーザーIDの取得
        $now_date = Carbon::now();
        $user_id = Auth::user()->id;
        // 当日の勤務記録を確認
        $confirm_date = Work::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();
        // 勤怠ステータスの確認と設定
        if (!$confirm_date) {
            $status = 0;
        } else {
            $status = Auth::user()->status;
        }
        // ビューにデータを渡して表示
        return view('stamp', compact('status'));
    }

    // 打刻処理
    public function work(Request $request)
    {
        // 現在の日時とユーザーIDの取得
        $now_date = Carbon::now();
        $now_time = Carbon::now()->format('H:i:s');
        $user_id = Auth::user()->id;
        // 勤務IDの取得（休憩処理のため）
        if ($request->has('start_rest') || $request->has('end_rest')) {
            $work_id = Work::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first()
                ->id;
        }

        // 勤務開始
        if ($request->has('start_work')) {
            $attendance = new Work();
            $attendance->date = $now_date;
            $attendance->start = $now_time;
            $attendance->user_id = $user_id;
            $status = 1;
        }

        // 休憩開始
        if ($request->has('start_rest')) {
            $attendance = new Rest();
            $attendance->start = $now_time;
            $attendance->work_id = $work_id;
            $status = 2;
        }

        // 休憩終了
        if ($request->has('end_rest')) {
            $attendance = Rest::where('work_id', $work_id)
                ->whereNotNull('start')
                ->whereNull('end')
                ->first();
            $attendance->end = $now_time;
            $status = 1;
        }

        // 勤務終了
        if ($request->has('end_work')) {
            $attendance = Work::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first();
            $attendance->end = $now_time;
            $status = 3;
        }

        // ユーザーステータスの更新と保存
        $user = User::find($user_id);
        $user->status = $status;
        $user->save();

        // 勤怠情報の保存とリダイレクト
        $attendance->save();
        return redirect('/')->with(compact('status'));
    }

    // 日別一覧表示
    public function indexDate(Request $request)
    {
        // リクエストから 'displayDate' を取得し、文字列として扱う
        $displayDate = $request->input('displayDate', Carbon::now()->format('Y-m-d'));

        // attendance_view_table から現在の日付のレコードを取得し、5件ずつページネート
        $users = DB::table('attendance_view_table')
            ->whereDate('date', $displayDate)
            ->paginate(5)
            ->appends(['displayDate' => $displayDate]);

        // 取得したデータを 'attendance' ビューに渡して表示
        return view('attendance', compact('users', 'displayDate'));
    }

    // 日別一覧 / 抽出処理
    public function perDate(Request $request)
    {
        // リクエストから 'displayDate' を取得し、文字列として扱う
        $displayDate = $request->input('displayDate', Carbon::now()->format('Y-m-d'));

        // 'prevDate' ボタンが押された場合、日付を1日減少
        if ($request->has('prevDate')) {
            $displayDate = Carbon::parse($displayDate)->subDay()->format('Y-m-d');
        }

        // 'nextDate' ボタンが押された場合、日付を1日増加
        if ($request->has('nextDate')) {
            $displayDate = Carbon::parse($displayDate)->addDay()->format('Y-m-d');
        }

        // attendance_view_table から特定の日付のレコードを取得し、5件ずつページネート
        $users = DB::table('attendance_view_table')
            ->whereDate('date', $displayDate)
            ->paginate(5)
            ->appends(['displayDate' => $displayDate]);

        // 取得したデータを 'attendance' ビューに渡して表示
        return view('attendance', compact('users', 'displayDate'));
    }
}