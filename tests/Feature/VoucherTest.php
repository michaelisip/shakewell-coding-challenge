<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    use DatabaseTruncation;

    protected $user;

    protected $vouchers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        // $this->vouchers = Voucher::factory()
        //     ->state(['user_id' => $this->user->id])
        //     ->count(5)
        //     ->create();
    }

    public function test_guest_cannot_access_vouchers(): void
    {
        $response = $this->getJson('/api/vouchers');

        $response->assertStatus(401);
    }

    public function test_user_can_show_all_vouchers()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/vouchers');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }


    public function test_user_show_one_voucher()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/vouchers/1');

        $response->assertOk();
        // $response->assertExactJson([
        //     'data' => $this->user->vouchers()->first()
        // ]);
    }

    public function test_user_can_create_new_vouchers()
    {
        Sanctum::actingAs($this->user);

        $discountCode = Str::random(5);
        $response = $this->postJson('/api/vouchers', [
            'code' => $discountCode,
            'amount' => fake()->numberBetween(10, 1000),
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.code', $discountCode);

        $this->assertDatabaseHas('vouchers', ['code' => $discountCode]);
    }

    public function test_user_can_update_voucher()
    {
        Sanctum::actingAs($this->user);

        $voucher = Voucher::factory()
            ->state(['user_id' => $this->user->id])
            ->create();

        $updatedCode = Str::random(5);

        $response = $this->putJson("/api/vouchers/{$voucher->id}", [
            'code' => $updatedCode,
            'amount' => fake()->numberBetween(10, 1000),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.code', $updatedCode);

        $this->assertDatabaseHas('vouchers', ['code' => $updatedCode]);
    }

    public function test_user_can_delete_voucher()
    {
        Sanctum::actingAs($this->user);

        $voucher = Voucher::factory()
            ->state(['user_id' => $this->user->id])
            ->create();

        $response = $this->deleteJson("/api/vouchers/{$voucher->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('vouchers', ['id' => $voucher->id]);
    }
}
