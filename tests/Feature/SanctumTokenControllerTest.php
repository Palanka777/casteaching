<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @covers SanctumTokenController
 */

class SanctumTokenControllerTest extends TestCase
{
    use RefreshDatabase;

 /** @test*/
    public function email_is_valid_for_issuing_tokens(){

        $response = $this->postJson('/api/sanctum/token',[
            'email'=>"no_valid",
            'password'=> '12345678',
            'device_name' =>"David's device"
        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The email must be a valid email address.",$json_response->message);
        $this->assertEquals("The email must be a valid email address.",$json_response->errors->email[0]);

    }

    /** @test*/
    public function password_is_required_for_issuing_tokens(){

        $response = $this->postJson('/api/sanctum/token',[
            'email'=>'davidpalanca@iesebre.com',
            'device_name' =>"Pepe's device"
        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The password field is required.",$json_response->message);
        $this->assertEquals("The password field is required.",$json_response->errors->password[0]);

        }

    /** @test*/
    public function device_name_is_required_for_issuing_tokens(){

        $user = User::create([
            'name'=>'David Pont Lopez',
            'email'=>'davidpalanca@iesebre.com',
            'password'=>'12345678'
        ]);

        $response = $this->postJson('/api/sanctum/token',[
            'email'=> $user->email,
            'password'=> $user->password,

        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The device name field is required.",$json_response->message);
        $this->assertEquals("The device name field is required.",$json_response->errors->device_name[0]);

    }


    /** @test*/
    public function invalid_email_gives_incorrect_credentials_error(){

        $user = User::create([
            'name'=>'David Pont Lopez',
            'email'=>'no_mail',
            'password'=>'12345678'
        ]);

        $response = $this->postJson('/api/sanctum/token',[
            'email'=>'mail_erroni',
            'password'=> $user->password,
            'device_name' => $user->name . "'s device"
        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The email must be a valid email address.",$json_response->message);
        $this->assertEquals("The email must be a valid email address.",$json_response->errors->email[0]);

    }

    /** @test*/
    public function invalid_password_gives_incorrect_credentials_error(){

        $user = User::create([
            'name'=>'David Pont Lopez',
            'email'=>'davidpalanca@iesebre.com',
            'password'=>'12345678'
        ]);

        $response = $this->postJson('/api/sanctum/token',[
            'email'=>$user->email,
            'password'=> 'password_erroni',
            'device_name' => $user->name . "'s device"
        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The provided credentials are incorrect.",$json_response->message);
        $this->assertEquals("The provided credentials are incorrect.",$json_response->errors->email[0]);

    }

    /** @test*/
    public function email_is_required_for_issuing_tokens(){


        $response = $this->postJson('/api/sanctum/token',[
            'password'=> '123445678',
            'device_name' =>"Pepe's device"
        ]);

        $response->assertStatus(422);
        $json_response = json_decode($response->getContent());
        $this->assertEquals("The email field is required.",$json_response->message);
        $this->assertEquals("The email field is required.",$json_response->errors->email[0]);

    }


    /** @test*/
    public function user_with_valid_credentials_can_issue_a_token()
    {
        $user = User::create([
            'name'=>'David Pont Lopez',
            'email'=>'davidpalanca@iesebre.com',
            'password'=>Hash::make('12345678')
        ]);

        $this->assertCount(0,$user->tokens);


        $response = $this->postJson('/api/sanctum/token',[
            'email'=>$user->email,
            'password'=> '12345678',
            'device_name' => $user->name . "'s device"
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($response->getContent());
        $this->assertCount(1,$user->fresh()->tokens);

    }
}
