<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::updateOrCreate(
            ['name' => 'Sofia Ramírez'],
            [
                'review' => 'Leí "El eco de las horas muertas" en una sola noche. La prosa de Kevin Perez tiene algo hipnótico que te mantiene pegado a las páginas. Es raro encontrar un escritor que pueda crear tanta emoción con tan pocas palabras. Cada frase está perfectamente calibrada, cada silencio tiene significado. Definitivamente volveré a leer sus obras.',
                'rating' => 5,
                'photo' => 'https://i.pravatar.cc/150?img=47',
                'active' => true,
                'order' => 1,
            ]
        );

        Testimonial::updateOrCreate(
            ['name' => 'Diego Morales'],
            [
                'review' => 'Los "Fragmentos de un invierno sin nombre" son pequeños milagros narrativos. Kevin tiene la capacidad de capturar momentos fugaces y convertirlos en historias universales. Su escritura es elegante sin ser pretenciosa, profunda sin ser oscura. Un autor que merece ser descubierto por más lectores.',
                'rating' => 5,
                'photo' => 'https://i.pravatar.cc/150?img=33',
                'active' => true,
                'order' => 2,
            ]
        );
    }
}
