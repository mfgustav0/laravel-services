<?php

namespace Database\Factories;

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
            'type' => $this->faker->randomElement(['confirmed', 'pendent', 'sended']),
            'status' => $this->faker->randomElement(['0', '2'])
        ];
    }

    private function generateSale(): string
    {
        return json_encode([
            'id' => $this->faker->numberBetween(1, 9999),
            'saled_at' => $this->faker->date() . ' ' . $this->faker->time(),
            'value_total' => $this->faker->randomFloat(2),
            'city' => $this->faker->city(),
            'method_payment' => $this->faker->randomElement(['cred_cart', 'payment_slip', 'pix']),
            'products' => $this->generateProducts(rand(2, 5))
        ]);
    }

    private function generateProducts(int $quantity=1): array
    {
        $produts = [];
        for ($i = 0; $i < $quantity; $i++) { 
            $produts[] = [
                'description' => $this->faker->word(),
                'quantity' => $this->faker->numberBetween(0, 100),
                'value' => $this->faker->randomFloat(2),
            ];
        }
        return $produts;
    }

    private function generateClient(): string
    {
        return json_encode([
            'name' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
            'number' => $this->faker->phoneNumber(),
            // 'email' => $this->faker->unique()->safeEmail(),
            'email' => 'gustavo.monteiro@flexsystems.com.br',
        ]);
    }
}
