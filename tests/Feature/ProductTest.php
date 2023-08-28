<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
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
            route('product.create'),
            Product::factory()->raw());

        $response->assertStatus(200);

        $this->assertEquals(1, Product::count());
        
    }    
    /**
     * @test 
     * Test the All route
     */
    public function testAll(){

        $token = $this->authenticate();

        $products = Product::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('GET',
            route('product.all'));


        $response->assertStatus(200);
        $this->assertEquals(5, Product::count());
        
    }

    /**
     * @test 
     * Test the Update route
     */
    public function testUpdate(){

        $token = $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('POST',
            route('product.update', ['product' => $product->id]),
            ['name' => 'updated']);

        $response->assertStatus(200);
        $this->assertEquals('updated', $response->getData()->product->name);
        
    } 

  
    /**
     * @test 
     * Test the Show route
     */
    public function testShow(){

        $token = $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('GET',
            route('product.show', ['product' => $product->id]));

        $response->assertStatus(200);
        $this->assertEquals($product->name, $response->getData()->product->name);
        
    }   
    /**
     * @test 
     * Test the Delete route
     */
    public function testDelete(){

        $token = $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
            ])->json('POST',
            route('product.delete', ['product' => $product->id]));

        $response->assertStatus(200);
        $this->assertEquals(0, Product::where('id',$product->id)->count());
        
    } 
}
