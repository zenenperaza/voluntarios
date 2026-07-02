<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voluntarios', function (Blueprint $table) {
            $table->string('qr_token', 64)->nullable()->unique()->after('cedula');
        });

        DB::table('voluntarios')
            ->whereNull('qr_token')
            ->orderBy('id')
            ->each(function ($voluntario): void {
                DB::table('voluntarios')
                    ->where('id', $voluntario->id)
                    ->update(['qr_token' => (string) Str::uuid()]);
            });
    }

    public function down(): void
    {
        Schema::table('voluntarios', function (Blueprint $table) {
            $table->dropUnique(['qr_token']);
            $table->dropColumn('qr_token');
        });
    }
};
