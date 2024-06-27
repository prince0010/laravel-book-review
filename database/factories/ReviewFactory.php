<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null,
            'review' => fake()->paragraph,
            // Number Between 1 to 5
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },

        ];
    }

    // THIS CUSTOM STATE METHOD COULD MAKE THE RATINGS TO HAVE A 3 STAR OR ABOVE SINCE THE FAKE RATING ABOVE MAKE SURE THAT IT WILL HAVE A RATING BELOW 3 NOT GETTING TO MORE THAT 3 ABOVE RATINGS
    // SO WE HAVE THIS CUSTOM STATE METHOD
    // CUSTOM STATE METHOD -> GENERATE A GOOD REVIEW TO HAVE SOME GOOD DIVERSITY RESULTS
    public function good(){
                // Attributes is the values of the columns
        return $this->state(function(array $attributes){
            return [
              'rating' => fake()->numberBetween(4,5)  
            ];
        });
    }

    
    public function average(){
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(2,5)  
              ];
        });
    }

    public function bad(){
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(1,3)  
              ];
        });
    }
}
