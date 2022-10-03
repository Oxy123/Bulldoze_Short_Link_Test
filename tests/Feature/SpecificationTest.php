<?php

namespace Tests\Feature;

use App\Models\Short;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_shortify_url()
    {

        $user = User::factory()->create();

        $url = "https://www.google.com/". Str::random(6);
        $this->actingAs($user);
        $response = $this->post('/shortify/create',["url" => $url]);
        $this->assertDatabaseHas("shorts",["original_link" => $url]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cannot_shortify_link()
    {
        $url = "https://www.google.com/25";
        $response = $this->post('/shortify/create',["url" => $url]);
        $response->assertRedirect('/user/login');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_can_register()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas("users",[
            "name" => $user->name,
            "email" => $user->email
        ]);

    }

    public function  test_user_can_login(){

        $user = User::factory()->create();

        $response = $this->post("/user/signin",[
            "email" => $user->email,
            "password" => $user->password
        ]);

        $response->assertRedirect("/");
    }


    public function test_shorts_link_cannont_pass_twenty_in_app(){

        $this->assertDatabaseCount("shorts",20);
    }

    /**
     * A basic feature test example.
     *
     * @return redirect
     */
    public function  test_user_cannot_shortify_more_than_five_link(){
        // Create a fake user

        $user = User::factory()->create();
        // seeds 5 short link in database to the user created
//        $shorts = Short::factory()->count(5)->for($user)->create(); // when use this record pass 20 in database // don't pass to controller
        // Acting As the User used before
        $this->actingAs(User::where('email' , $user->email)->first());
        for ($i=0; $i<5;$i++){
            $addFive = $this->post('/shortify/create',[
                "url" => "https://yassine.com/" . Str::random(6)
            ]);
        }



        // trying to add the sixth link by sending POST Request to create the short link // 302 status must returned
        $response = $this->post('/shortify/create',[
            "url" => "https://yassine.com/" . Str::random(6)
        ]);
        // assert that the Status is 302 ( Unexepted Redirect ) ( The user is Already redirect back when he doesn't have the permisson to add short Link if he already has 5 shorts
        $response->assertStatus(302);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Short_Link_must_be_visited_by_everyone(){
            $short = Short::first();
            $response = $this->followingRedirects()
                ->get('/' .$short->short_link)
                ->assertStatus(200);;
    }
}
