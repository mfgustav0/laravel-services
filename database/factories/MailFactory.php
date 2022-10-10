<?php

namespace Database\Factories;

use App\Enums\Mail\MailStatus;
use App\Enums\Mail\MailType;
use App\Models\Database;
use App\Models\Mail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mail>
 */
class MailFactory extends Factory
{
    protected $model = Mail::class;

    public function definition(): array
    {
        return [
            'database_id' => Database::factory(),
            'sale' => $this->generateSale(),
            'client' => $this->generateClient(),
            'type' => fake()->randomElement(MailType::cases()),
            'status' => fake()->randomElement(MailStatus::cases())
        ];
    }

    private function generateSale(): array
    {
        return [
            'id' => fake()->numberBetween(1, 9999),
            'saled_at' => fake()->date() . ' ' . fake()->time(),
            'value_total' => fake()->randomFloat(2),
            'city' => fake()->city(),
            'method_payment' => fake()->randomElement(['cred_cart', 'payment_slip', 'pix']),
            'products' => $this->generateProducts(rand(2, 5))
        ];
    }

    private function generateProducts(int $quantity=1): array
    {
        $produts = [];
        for ($i = 0; $i < $quantity; $i++) { 
            $produts[] = [
                'description' => fake()->word(),
                'quantity' => fake()->numberBetween(0, 100),
                'value' => fake()->randomFloat(2),
            ];
        }
        return $produts;
    }

    private function generateClient(): array
    {
        return [
            'name' => fake()->name(),
            'telephone' => fake()->phoneNumber(),
            'number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
