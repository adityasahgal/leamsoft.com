<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('company')->nullable();
            $table->string('topic')->nullable();
            $table->string('mode', 30)->default('google_meet');
            $table->date('meeting_date');
            $table->string('meeting_time', 5);   // HH:MM, see config('meetings.timezone')
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('admin_note')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index(['meeting_date', 'meeting_time']);
            $table->index('status');
        });

        // Permission for the admin listing, granted to every role that can
        // already read enquiries (Super Admin passes all checks anyway).
        if (Schema::hasTable('permissions')) {
            $now = now();
            $exists = DB::table('permissions')->where('name', 'meeting-read')->where('guard_name', 'web')->exists();
            if (! $exists) {
                $permId = DB::table('permissions')->insertGetId([
                    'name' => 'meeting-read', 'guard_name' => 'web',
                    'created_at' => $now, 'updated_at' => $now,
                ]);

                $enquiryPerm = DB::table('permissions')->where('name', 'enquiry-read')->value('id');
                if ($enquiryPerm && Schema::hasTable('role_has_permissions')) {
                    $roles = DB::table('role_has_permissions')->where('permission_id', $enquiryPerm)->pluck('role_id');
                    foreach ($roles as $roleId) {
                        DB::table('role_has_permissions')->insertOrIgnore(['permission_id' => $permId, 'role_id' => $roleId]);
                    }
                }
            }
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');

        if (Schema::hasTable('permissions')) {
            $id = DB::table('permissions')->where('name', 'meeting-read')->value('id');
            if ($id) {
                DB::table('role_has_permissions')->where('permission_id', $id)->delete();
                DB::table('permissions')->where('id', $id)->delete();
            }
        }
    }
};
