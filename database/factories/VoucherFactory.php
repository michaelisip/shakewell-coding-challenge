<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VoucherStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->boolean() ? 'fixed' : 'percentage';

        return [
            'code' => Str::random(5),
            'user_id' => User::inRandomOrder()->first(),
            'voucher_status_id' => fake()->randomElement([1, 2]), // inactive or active
            'type' => $type,
            'value' => $this->getDiscountValue($type),
            'description' => fake()->sentence(),
            'minimum_purchase' => null,
            'maximum_discount' => null,
            'usage_limit' => null,
            'start_date' => null,
            'end_date' => null,
        ];
    }

    public function fixed(): Factory
    {
        return $this->state(function (array $attributes) {
            $value = fake()->randomFloat(2, 1000, 10000);

            return [
                'type' => 'fixed',
                'value' => $value,
            ];
        });
    }

    public function percentage(): Factory
    {
        return $this->state(function (array $attributes) {
            $value = fake()->randomFloat(2, .01, 1);

            return [
                'type' => 'percentage',
                'value' => $value,
            ];
        });
    }

    public function expiration(): Factory
    {
        return $this->state(function (array $attributes) {
            $hasExpiration = fake()->boolean();

            if (! $hasExpiration) {
                return $this->noExpiration();
            }

            return $this->hasExpiration();
        });
    }

    private function noExpiration(): array
    {
        $activeStatus = VoucherStatus::getStatus('active');
        $inactiveStatus = VoucherStatus::getStatus('inactive');

        return [
            'start_date' => null,
            'end_date' => null,
            'voucher_status_id' => fake()->randomElement([
                $activeStatus->id,
                $inactiveStatus->id
            ]),
        ];
    }

    private function hasExpiration(): array
    {
        $randomDate = fake()->dateTimeBetween('-1 years', '+1 years');

        $startDate = Carbon::instance($randomDate);
        $endDate = Carbon::instance($randomDate)->addMonths(fake()->numberBetween(1, 12));

        $expiredStatus = VoucherStatus::getStatus('expired');
        $activeStatus = VoucherStatus::getStatus('active');

        $voucherStatusId = $endDate->isPast() ? $expiredStatus->id : $activeStatus->id;

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'voucher_status_id' => $voucherStatusId,
        ];
    }

    private function getDiscountValue(string $type): float
    {
        if ($type === 'fixed') {
            return fake()->randomFloat(2, 100, 1000);
        }

        return fake()->randomFloat(2, 0.01, 1);
    }
}
