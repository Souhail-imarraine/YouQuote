<?php

namespace Database\Factories;
use app\Models\Category;
use app\Models\Quote;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategorieQuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $categorie = Category::all();
        $Quotes = Quote::all();
        return [
            'category_id' => $categorie::inRandomOrder()->first()?->id,
            'quote_id' => $Quotes::inRandomOrder()->first()?->id,
        ];
    }
}
