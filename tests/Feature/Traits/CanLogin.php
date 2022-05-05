<?php

namespace Tests\Feature\Traits;

use Illuminate\Support\Facades\Auth;

trait CanLogin
{
    private function loginAsSeriesManager()
    {
        Auth::login($user = create_series_manager_user());
        return $user;
    }

    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
    }

    private function loginAsVideoManager()
    {
        Auth::login(create_videomanager_user());
    }

    private function loginAsSuperAdmin()
    {
        Auth::login(create_superadmin_user());
    }

    private function loginAsRegularUser()
    {
        Auth::login(create_regular_user());

    }
}
