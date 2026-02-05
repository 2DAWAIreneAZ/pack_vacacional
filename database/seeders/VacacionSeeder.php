<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacacionSeeder extends Seeder
{
    public function run(): void
    {
        $vacaciones = [
            // Playa (id_tipo: 1)
            [
                'titulo' => 'Paraíso Caribeño en Cancún',
                'descripcion' => 'Disfruta de 7 días en un resort todo incluido frente al mar turquesa del Caribe mexicano. Incluye actividades acuáticas, entretenimiento nocturno y excursiones opcionales.',
                'precio' => 1299.99,
                'id_tipo' => 1,
                'pais' => 'México',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Costa del Sol - Málaga',
                'descripcion' => 'Una semana de sol y playa en la hermosa Costa del Sol. Alojamiento en hotel 4 estrellas, desayuno incluido y acceso a playas privadas.',
                'precio' => 899.00,
                'id_tipo' => 1,
                'pais' => 'España',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Maldivas de Ensueño',
                'descripcion' => 'Experiencia única en bungalows sobre el agua en las Maldivas. 5 días de lujo absoluto con spa, buceo y gastronomía de primer nivel.',
                'precio' => 3499.00,
                'id_tipo' => 1,
                'pais' => 'Maldivas',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Montaña (id_tipo: 2)
            [
                'titulo' => 'Aventura en los Alpes Suizos',
                'descripcion' => 'Paquete de 6 días de senderismo y esquí en los majestuosos Alpes. Incluye alojamiento en cabaña alpina, guía profesional y equipo completo.',
                'precio' => 1599.00,
                'id_tipo' => 2,
                'pais' => 'Suiza',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Escapada a los Pirineos',
                'descripcion' => '4 días de naturaleza pura en el corazón de los Pirineos. Rutas de senderismo, visitas a pueblos medievales y gastronomía local.',
                'precio' => 649.00,
                'id_tipo' => 2,
                'pais' => 'España',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Crucero (id_tipo: 3)
            [
                'titulo' => 'Crucero por el Mediterráneo',
                'descripcion' => 'Navegación de 10 días visitando Italia, Grecia, Croacia y España. Todo incluido con entretenimiento, múltiples restaurantes y excursiones en cada puerto.',
                'precio' => 2299.00,
                'id_tipo' => 3,
                'pais' => 'Multidestino',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Crucero Caribe Exclusivo',
                'descripcion' => '8 días navegando por las islas más hermosas del Caribe. Visitas a Jamaica, Bahamas, Islas Caimán y más.',
                'precio' => 1899.00,
                'id_tipo' => 3,
                'pais' => 'Multidestino',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Ciudad (id_tipo: 4)
            [
                'titulo' => 'París - Ciudad del Amor',
                'descripcion' => '5 días descubriendo los encantos de París. Incluye visitas a la Torre Eiffel, Louvre, crucero por el Sena y alojamiento céntrico.',
                'precio' => 1099.00,
                'id_tipo' => 4,
                'pais' => 'Francia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Nueva York, la Gran Manzana',
                'descripcion' => '7 días explorando Nueva York. Tours por Manhattan, Brooklyn, visita a museos y espectáculo de Broadway incluido.',
                'precio' => 1799.00,
                'id_tipo' => 4,
                'pais' => 'Estados Unidos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Tokio Moderno y Tradicional',
                'descripcion' => 'Una semana completa en Tokio experimentando la perfecta fusión entre tradición y modernidad. Incluye visitas guiadas, JR Pass y alojamiento.',
                'precio' => 2199.00,
                'id_tipo' => 4,
                'pais' => 'Japón',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Safari (id_tipo: 5)
            [
                'titulo' => 'Safari Africano en Tanzania',
                'descripcion' => '10 días de safari en el Serengeti y Ngorongoro. Alojamiento en lodges de lujo, avistamiento de los Big Five y guías expertos.',
                'precio' => 3899.00,
                'id_tipo' => 5,
                'pais' => 'Tanzania',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Aventura Safari en Kenia',
                'descripcion' => '8 días en Masai Mara y Amboseli. Experiencia única con la gran migración y vistas del Kilimanjaro.',
                'precio' => 3299.00,
                'id_tipo' => 5,
                'pais' => 'Kenia',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Aventura (id_tipo: 6)
            [
                'titulo' => 'Trekking al Machu Picchu',
                'descripcion' => '7 días de aventura por el Camino Inca hasta Machu Picchu. Incluye guía, porteadores, camping y todas las comidas.',
                'precio' => 1499.00,
                'id_tipo' => 6,
                'pais' => 'Perú',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Patagonia Extrema',
                'descripcion' => 'Expedición de 12 días por la Patagonia argentina y chilena. Trekking en glaciares, kayak y acampada en naturaleza salvaje.',
                'precio' => 2599.00,
                'id_tipo' => 6,
                'pais' => 'Argentina/Chile',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Cultural (id_tipo: 7)
            [
                'titulo' => 'Tesoros de Egipto',
                'descripcion' => '10 días descubriendo pirámides, templos y tumbas del antiguo Egipto. Crucero por el Nilo incluido y guías egiptólogos.',
                'precio' => 2099.00,
                'id_tipo' => 7,
                'pais' => 'Egipto',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Grecia Clásica',
                'descripcion' => '8 días visitando Atenas, Delfos, Meteora y Santorini. Inmersión total en la cuna de la civilización occidental.',
                'precio' => 1699.00,
                'id_tipo' => 7,
                'pais' => 'Grecia',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Relax (id_tipo: 8)
            [
                'titulo' => 'Spa & Wellness en Bali',
                'descripcion' => '7 días de relajación total en resort de lujo en Bali. Masajes diarios, yoga, meditación y gastronomía saludable.',
                'precio' => 1899.00,
                'id_tipo' => 8,
                'pais' => 'Indonesia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Retiro de Bienestar en Tailandia',
                'descripcion' => '10 días de desconexión total en Koh Samui. Programa de detox, spa, yoga y actividades mindfulness.',
                'precio' => 1699.00,
                'id_tipo' => 8,
                'pais' => 'Tailandia',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('vacacion')->insert($vacaciones);
    }
}