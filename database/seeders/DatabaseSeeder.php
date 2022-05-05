<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        create_default_user();
        create_default_profe_user();
        create_superadmin_user();
        create_regular_user();
        create_videomanager_user();
        create_user_manager_user();
        create_sample_series();
        create_default_video();
        createSampleVideos();
        create_permissions();
        create_placeholder_series_image();

    }
}
