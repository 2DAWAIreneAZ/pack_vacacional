<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotoSeeder extends Seeder
{
    public function run(): void
    {
        $fotos = [
            // Fotos para Paraíso Caribeño en Cancún (id_vacacion: 1)
            ['id_vacacion' => 1, 'ruta' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 1, 'ruta' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 1, 'ruta' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Costa del Sol - Málaga (id_vacacion: 2)
            ['id_vacacion' => 2, 'ruta' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 2, 'ruta' => 'https://images.unsplash.com/photo-1583422409516-2895a77efded', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Maldivas de Ensueño (id_vacacion: 3)
            ['id_vacacion' => 3, 'ruta' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 3, 'ruta' => 'https://images.unsplash.com/photo-1589197331516-7f86ea28161f', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 3, 'ruta' => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Aventura en los Alpes Suizos (id_vacacion: 4)
            ['id_vacacion' => 4, 'ruta' => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 4, 'ruta' => 'https://images.unsplash.com/photo-1605540436563-5bca919ae766', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Escapada a los Pirineos (id_vacacion: 5)
            ['id_vacacion' => 5, 'ruta' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 5, 'ruta' => 'https://images.unsplash.com/photo-1519904981063-b0cf448d479e', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Crucero por el Mediterráneo (id_vacacion: 6)
            ['id_vacacion' => 6, 'ruta' => 'https://images.unsplash.com/photo-1545124469-66bad7c6f1f8', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 6, 'ruta' => 'https://images.unsplash.com/photo-1599640842225-85d111c60e6b', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Crucero Caribe Exclusivo (id_vacacion: 7)
            ['id_vacacion' => 7, 'ruta' => 'https://images.unsplash.com/photo-1548574505-5e239809ee19', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 7, 'ruta' => 'https://images.unsplash.com/photo-1563178307-0c2b902943d3', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para París - Ciudad del Amor (id_vacacion: 8)
            ['id_vacacion' => 8, 'ruta' => 'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 8, 'ruta' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 8, 'ruta' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Nueva York (id_vacacion: 9)
            ['id_vacacion' => 9, 'ruta' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 9, 'ruta' => 'https://images.unsplash.com/photo-1546436836-07a91091f160', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Tokio (id_vacacion: 10)
            ['id_vacacion' => 10, 'ruta' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 10, 'ruta' => 'https://images.unsplash.com/photo-1513407030348-c983a97b98d8', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Safari Africano en Tanzania (id_vacacion: 11)
            ['id_vacacion' => 11, 'ruta' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 11, 'ruta' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 11, 'ruta' => 'https://images.unsplash.com/photo-1489392191049-fc10c97e64b6', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Aventura Safari en Kenia (id_vacacion: 12)
            ['id_vacacion' => 12, 'ruta' => 'https://images.unsplash.com/photo-1535083783855-76ae62b2914e', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 12, 'ruta' => 'https://images.unsplash.com/photo-1564760055775-d63b17a55c44', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Trekking al Machu Picchu (id_vacacion: 13)
            ['id_vacacion' => 13, 'ruta' => 'https://images.unsplash.com/photo-1587595431973-160d0d94add1', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 13, 'ruta' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Patagonia Extrema (id_vacacion: 14)
            ['id_vacacion' => 14, 'ruta' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 14, 'ruta' => 'https://images.unsplash.com/photo-1534067783941-51c9c23ecefd', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Tesoros de Egipto (id_vacacion: 15)
            ['id_vacacion' => 15, 'ruta' => 'https://images.unsplash.com/photo-1553913861-c0fddf2619ee', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 15, 'ruta' => 'https://images.unsplash.com/photo-1572252009286-268acec5ca0a', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Grecia Clásica (id_vacacion: 16)
            ['id_vacacion' => 16, 'ruta' => 'https://images.unsplash.com/photo-1555993539-1732b0258235', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 16, 'ruta' => 'https://images.unsplash.com/photo-1503152394-c571994fd383', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Spa & Wellness en Bali (id_vacacion: 17)
            ['id_vacacion' => 17, 'ruta' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 17, 'ruta' => 'https://images.unsplash.com/photo-1559628376-f3fe5f782a2e', 'created_at' => now(), 'updated_at' => now()],

            // Fotos para Retiro de Bienestar en Tailandia (id_vacacion: 18)
            ['id_vacacion' => 18, 'ruta' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a', 'created_at' => now(), 'updated_at' => now()],
            ['id_vacacion' => 18, 'ruta' => 'https://images.unsplash.com/photo-1528181304800-259b08848526', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('foto')->insert($fotos);
    }
}