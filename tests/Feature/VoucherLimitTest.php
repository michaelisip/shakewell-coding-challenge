<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VoucherLimitTest extends TestCase
{
    protected $user;

    protected $vouchers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->vouchers = Voucher::factory()
            ->state(['user_id' => $this->user->id])
            ->count(10)
            ->create();
    }

    public function test_user_can_only_create_up_to_10_vouchers(): void
    {
        Sanctum::actingAs($this->user);

        $discountCode = Str::random(5);
        $response = $this->postJson('/api/vouchers', [
            'code' => $discountCode,
            'amount' => fake()->numberBetween(10, 1000),
        ]);

        $response->assertStatus(422);
    }
}
