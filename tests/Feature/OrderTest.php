<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    // Create & Authenticate User
    protected function authenticate(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $this->user = $user;
        $token = JWTAuth::fromUser($user);

        return $token;
    }
    
    /**
     * @test 
     * Test the Create route
     */
    public function testCreate(){

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('POST',
            route('order.create'),
            Order::factory()->raw());

        $response->assertStatus(200);

        $this->assertEquals(1, Order::count());
        
    }    
    /**
     * @test
     * 
     * Test the All route
     */
    public function testAll(){

        $token = $this->authenticate();

        $orders = Order::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('GET',
            route('order.all'));


        $response->assertStatus(200);
        $this->assertEquals(5, Order::count());
        
    }

    /**
     *  @test
     * 
     * Test the Update route
     */
    public function testUpdate(){

        $token = $this->authenticate();

        $order = Order::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('POST',
            route('order.update', ['order' => $order->id]),
            ['count' => 70]);

        $response->assertStatus(200);
        $this->assertEquals(70, $response->getData()->order->count);
        
    } 

  
    /**
     *  @test
     * 
     * Test the Show route
     */
    public function testShow(){

        $token = $this->authenticate();

        $order = Order::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('GET',
            route('order.show', ['order' => $order->id]));

        $response->assertStatus(200);
        $this->assertEquals($order->count, $response->getData()->order->count);
        $this->assertEquals($order->total_price, $response->getData()->order->total_price);
        
    }   
    /**
     *  @test 
     * 
     * Test the Delete route
     */
    public function testDelete(){

        $token = $this->authenticate();

        $order = Order::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('POST',
            route('order.delete', ['order' => $order->id]));

        $response->assertStatus(200);
        $this->assertEquals(0, Order::where('id',$order->id)->count());
        
    } 
}
