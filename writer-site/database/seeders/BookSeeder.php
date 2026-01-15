<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::updateOrCreate(
            ['title' => 'Amor contra todo pronóstico'],
            [
                'description' => 'Un chico escribe un diario personal donde cuenta sus vivencias más importantes. Con el tiempo le ocurre algo que hace cambiar el rumbo de su vida y el de las personas que más quiere.',
                'long_description' => '<p>Un chico escribe un diario personal donde cuenta sus vivencias más importantes. Con el tiempo le ocurre algo que hace cambiar el rumbo de su vida y el de las personas que más quiere. Digamos que es algo totalmente imprevisible, muy difícil de digerir tanto para él como para la gente de su entorno más cercano.</p><p>Es probable que no hay más de diez personas en el mundo que les haya ocurrido lo mismo que a este chico y que estén identificadas mediáticamente. No es habitual contarlo, sino quedárselo para uno mismo por miedo al rechazo o lo que puedan pensar porque rompe con los estereotipos de la sociedad y es muy común sentirse juzgado por tanto es un asusto un tanto delicado ya que crea mucha controversia. Es un tema muy tabú y a las personas que les pasa se pueden sentir juzgadas e incomprendidas.</p><p><strong>Publicación:</strong> 2020<br><strong>Géneros:</strong> Romántico, drama, suspense, erótica, aventuras<br><strong>Páginas:</strong> 200<br><strong>Ediciones:</strong> 5<br><strong>Narrador:</strong> protagonista</p>',
                'price' => 18.95,
                'cover_image' => null,
                'stripe_price_id' => null,
                'active' => true,
            ]
        );

        Book::updateOrCreate(
            ['title' => 'En la casa'],
            [
                'description' => 'La historia va de una chica que encuentra un trabajo de interna veinticuatro horas en una casa en el bosque. Debe cuidar de un señor mayor que tiene demencia.',
                'long_description' => '<p>La historia va de una chica que encuentra un trabajo de interna veinticuatro horas en una casa en el bosque. Debe cuidar de un señor mayor que tiene demencia. Sus labores son estar al tanto de él y también ocuparse de las tareas del hogar: limpiarle, cocinare…</p><p>A medida que pasan las horas y los días ella va viendo cosas un tanto extrañas en la casa rural y comienza a estar inquieta e insegura ya que es la primera vez que percibe algo así, aunque deberá hacerse fuerte e investigar si la morada guarda algún secreto y si hay personas del pasado que están involucradas con este misterio.</p><p><strong>Publicación:</strong> 2022<br><strong>Géneros:</strong> Novela negra, terror, misterio, suspense<br><strong>Páginas:</strong> 304<br><strong>Ediciones:</strong> 6<br><strong>Narrador:</strong> protagonista y omnisciente</p>',
                'price' => 22.95,
                'cover_image' => null,
                'stripe_price_id' => null,
                'active' => true,
            ]
        );

        Book::updateOrCreate(
            ['title' => 'Territorio Devastado'],
            [
                'description' => 'La novela cuenta como una familia de hace 400 años en el siglo XVI viven del campo. Un día por la noche alguien llama a la puerta del hogar de esta gente y ellos se despiertan, se asustan.',
                'long_description' => '<p>La novela cuenta como una familia de hace 400 años en el siglo XVI viven del campo, tienen un pequeño huertecito donde siembran verduras y viven del burro, la vaca y las gallinas que tiene en la planta baja de su humilde casita de barro.</p><p>Un día por la noche alguien llama a la puerta del hogar de esta gente y ellos se despiertan, se asustan. Bajan a ver de quién se trata temblorosos. Resulta ser un señor mayor que pide auxilio. Es el tabernero del pueblo, un señor mayor que es muy popular en el pueblo. Este está muy grave, tiene heridas por todo el cuerpo. La familia le preguntan qué le ha ocurrido preocupándose por él. Pero el señor no puede hablar y se desmaya.</p><p>Van a buscar al médico y cuando viene le da a la familia unas hierbas medicinales de aquella época. Al señor lo tienen en una cama durante unas horas intentando que se restablezca, sin embargo, de repente se escapa en esas condiciones tan desfavorables. ¿Cómo puede ser que alguien que se está muriendo en una cama se haya escapado así sin previo aviso?</p><p><strong>Publicación:</strong> 2025<br><strong>Géneros:</strong> Novela histórica, terror, ciencia ficción, misterio<br><strong>Páginas:</strong> 235<br><strong>Ediciones:</strong> 2<br><strong>Narrador:</strong> cámara</p>',
                'price' => 20.95,
                'cover_image' => null,
                'stripe_price_id' => null,
                'active' => true,
            ]
        );

        Book::updateOrCreate(
            ['title' => 'Vestido blanco de flores silvestres'],
            [
                'description' => 'A un joven que trabaja de tanatopractor se le avería el coche y debe ir en tren a la funeraria. Una vez estando ya en el interior ve como una preciosa chica de cabello largo y ojos almendrados sube en la siguiente parada.',
                'long_description' => '<p>A un joven que trabaja de tanatopractor se le avería el coche y debe ir en tren a la funeraria. Una vez estando ya en el interior ve como una preciosa chica de cabello largo y ojos almendrados sube en la siguiente parada y se sienta justo delante suyo, en el asiento libre que hay.</p><p>El chico se pone muy nervioso porque le ha encantado la mujer y se le ocurre escribirle unas notas en una libreta que guarda en la mochila. Le muestra las primeras dejándola algo desconcertada, pero cuando está apunto de entregarle la última donde había escrito su número de teléfono, la llaman por el móvil y se baja rápidamente a la siguiente estación quedándose él con las ganas de conocerla.</p><p>¿Volverá a coincidir con la misteriosa chica del tren? ¿Le convendrá hacerlo si se da la oportunidad o hay algo en ella que le pueda perjudicar?</p><p><strong>Publicación:</strong> 2025<br><strong>Géneros:</strong> novela negra, erótica, acción, misterio, drama, romántica y terror<br><strong>Páginas:</strong> 284<br><strong>Ediciones:</strong> 1<br><strong>Narrador:</strong> protagonista</p>',
                'price' => 22.95,
                'cover_image' => null,
                'stripe_price_id' => null,
                'active' => true,
            ]
        );
    }
}
