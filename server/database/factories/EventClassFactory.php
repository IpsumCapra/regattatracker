<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => $this->faker->randomElement(Event::all()->pluck('id')->toArray()),
            'name' => $this->faker->name
        ];
    }
}
