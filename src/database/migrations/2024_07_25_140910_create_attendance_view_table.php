<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAttendanceViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE OR REPLACE VIEW attendance_view_table AS
            SELECT
                u.id,
                u.name,
                w.date,
                w.start,
                w.end,
                SEC_TO_TIME(COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(r.end,r.start))),0)) AS total_rest,
                TIMEDIFF(w.end,w.start) AS total_work,
                u.status
            FROM
                users u
            JOIN
                works w
            ON
                u.id = w.user_id
            LEFT JOIN
                rests r
            ON
                w.id = r.work_id
            GROUP BY
                u.id,
                u.name,
                w.date,
                w.start,
                w.end,
                u.status
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS attendance_view_table');
    }
}