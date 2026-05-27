<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert columns that may hold emoji (icon, name, short_description, description)
     * to utf8mb4 so emoji can be stored. The pre-existing tables were created with
     * 3-byte utf8, which rejects 4-byte characters.
     */
    public function up(): void
    {
        $targets = [
            'categories' => ['icon', 'color', 'name', 'short_description', 'description'],
            'subcategories' => ['icon', 'name', 'short_description', 'description'],
            'services' => ['icon', 'name', 'short_description', 'description'],
        ];

        foreach ($targets as $table => $columns) {
            if (!Schema::hasTable($table)) continue;

            foreach ($columns as $col) {
                if (!Schema::hasColumn($table, $col)) continue;

                $type = $this->columnType($table, $col);
                if ($type === null) continue;

                try {
                    DB::statement("ALTER TABLE `{$table}` MODIFY `{$col}` {$type} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
                } catch (\Throwable $e) {
                    // skip silently — non-fatal
                }
            }
        }
    }

    public function down(): void
    {
        // No-op — keeping utf8mb4 is strictly better than the prior charset.
    }

    private function columnType(string $table, string $column): ?string
    {
        // MariaDB/MySQL doesn't allow placeholders in SHOW COLUMNS LIKE.
        // Column name comes from our own hardcoded list, so direct interpolation is safe here.
        $safeCol = str_replace("'", '', $column);
        $row = DB::selectOne("SHOW COLUMNS FROM `{$table}` LIKE '{$safeCol}'");
        if (!$row) return null;
        return $row->Type ?? null;
    }
};
