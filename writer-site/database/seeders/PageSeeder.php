<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Inicio',
                'content' => null,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'Sobre mí',
                'content' => '<p>Me llamo <strong>Kevin Pérez Alarcón</strong>. Nací en Manresa el 27 de septiembre del 1991 y he crecido en el pueblo de Monistrol de Montserrat (Barcelona).</p><p>Cuando era pequeño comencé a tener interés por la escritura. Era un niño muy reservado y me costaba trasmitir lo que sentía con las personas de mi alrededor. Por ese motivo cuando estaba triste o algo me preocupaba me encerraba en mi habitación y escribía mis sentimientos y emociones en algunos cuadernos que guardaba en mi mesita de noche. Recuerdo que me gustaba inventarme historias para contárselas a mis amigos y cuando se las contaba ellos me expectantes por saber como iban a terminar.</p><p>En el año 2019 decidí escribir mi primera novela <em>Amor contra todo pronóstico</em> y pude cumplir el sueño de publicarla a través de una editorial de autoedición llamada Ediciones Ende. Un tiempo después decidí comenzar a estudiar unos cursos de escritura en una escuela llamada Atenèu Barcelonés situada en Barcelona.</p><p>Posteriormente de cursar el primer año me aventuré a escribir mi segunda novela <em>En la casa</em> que publiqué con la editorial también de autoedición Círculo Rojo con la que reedité mi anterior libro <em>Amor contra todo pronóstico</em>.</p><p>En aquel entonces yo trabajaba en un supermercado y un día fui de visita a un mercadillo que suelen hacer los domingos en una población que se llama Collbató y una señora me propuso que vendiera mis novelas en tal lugar. Pregunté al ayuntamiento y me dejaron promocionaras durante unas semanas. Me di cuenta de que había personas que se paraban y algunas me los compraban. Así que repetí más días allí y empecé a pedir sitio a otras localidades para también ponerme en los mercadillos.</p><p>Con el tiempo me percaté de que podría intentar vivir solo de mis libros y dejé mi trabajo en el supermercado para emprender un negocio vendiendo mis dos novelas en mercadillos, ferias, mercados municipales y en la vía pública. Consiguiendo sacar hasta 4 ediciones de <em>Amor contra todo pronóstico</em> y 5 de <em>En la casa</em>.</p><p>Con el tiempo me han llegado a comprar más de 5.000 libros en las calles. Cosa que estoy muy agradecido a cada una de las personas que me han ayudado a seguir soñando. Gracias a todos ellos puedo seguir viviendo de mis libros autoeditados.</p><p>Después de haber estudiado los 3 primeros cursos en la escuela de escritura publiqué mi tercera novela <em>Territorio Devastado</em> y poco más tarde mi cuarta <em>Vestido blanco de flores silvestres</em>. Ambas sacadas al mercado en 2025.</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contacto',
                'content' => '<p>Si quieres escribir, usa el formulario. Responderemos lo antes posible.</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'faq'],
            [
                'title' => 'Preguntas frecuentes',
                'content' => '<h3>¿Cómo puedo comprar tus libros?</h3><p>Puedes comprar mis libros directamente desde esta web mediante tarjeta de crédito, PayPal o Bizum. También puedes encontrarme en mercadillos, ferias y mercados municipales.</p><h3>¿Qué incluye el precio?</h3><p>El precio incluye: libro + dedicatoria (opcional) + marcapáginas + envío certificado (con seguro) + embalaje.</p><h3>¿Haces envíos internacionales?</h3><p>Sí, realizo envíos a toda España. Para envíos internacionales, contacta conmigo directamente.</p><h3>¿Puedo conseguir una dedicatoria personalizada?</h3><p>Sí, puedes indicar en el pedido si deseas una dedicatoria personalizada y el texto que quieres que incluya.</p><h3>¿Dónde puedo encontrarte en persona?</h3><p>Me puedes encontrar en mercadillos, ferias y mercados municipales de diferentes localidades. Sigue mis redes sociales para conocer mis próximas apariciones.</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'blog'],
            [
                'title' => 'Blog',
                'content' => '<p>Próximamente publicaré artículos sobre escritura, mis experiencias vendiendo libros en las calles, y reflexiones sobre el proceso creativo.</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'photos-readers'],
            [
                'title' => 'Fotos con mis lectores en los mercados',
                'content' => '<p>Aquí compartiré fotos con mis lectores en los diferentes mercadillos y ferias donde me encuentro. ¡Gracias a todos por vuestro apoyo!</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'photos-books'],
            [
                'title' => 'Fotos con mis novelas',
                'content' => '<p>Galería de imágenes de mis novelas en diferentes ubicaciones y eventos.</p>',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'offers'],
            [
                'title' => 'Ofertas y packs',
                'content' => '<p>Mantente atento a nuestras ofertas especiales durante Halloween, Black Friday, Navidad y Sant Jordi. Próximamente publicaremos packs especiales con descuentos.</p>',
            ]
        );
    }
}
