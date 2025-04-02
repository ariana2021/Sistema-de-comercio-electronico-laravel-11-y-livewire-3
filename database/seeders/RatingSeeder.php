<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
use App\Models\Product;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $products = range(1, 50);

        $comments = [
            "Excelente calidad, el material es resistente y duradero.",
            "Muy útil para trabajos de carpintería, lo recomiendo.",
            "Cumple su función perfectamente, nada que mejorar.",
            "Me sorprendió la resistencia del producto, vale cada centavo.",
            "Ideal para proyectos de construcción, super práctico.",
            "Entrega rápida y bien empaquetado, muy satisfecho con la compra.",
            "Buena relación calidad-precio, lo volvería a comprar sin dudarlo.",
            "El mejor en su categoría, superó mis expectativas.",
            "Recomiendo este producto para cualquier profesional del área.",
            "Funciona perfectamente, se nota que es de buena marca.",
            "Fácil de usar, incluso para principiantes en bricolaje.",
            "Las herramientas llegaron en perfecto estado y bien afiladas.",
            "Súper resistente, lo he usado en varios proyectos sin problema.",
            "No esperaba tanto por este precio, pero la calidad es increíble.",
            "Se adapta bien a la mano, no es incómodo de usar.",
            "Tiene un diseño robusto y ergonómico, excelente para trabajos largos.",
            "Material anticorrosivo, ideal para zonas húmedas.",
            "He comprado varios y nunca me han fallado, 100% recomendado.",
            "Buen agarre y precisión, una herramienta imprescindible en mi taller.",
            "Probado en condiciones difíciles y sigue como nuevo.",
            "Diseño innovador y muy práctico, facilita mucho el trabajo.",
            "La potencia es impresionante para su tamaño.",
            "No se oxida fácilmente, ideal para trabajos en exteriores.",
            "Gran durabilidad, lo he usado por meses y sigue como nuevo.",
            "El filo se mantiene después de varios usos, increíble calidad.",
            "El motor es potente y silencioso, vale cada peso.",
            "Nada que envidiar a otras marcas más caras, funciona excelente.",
            "Buena sujeción y fácil ajuste, muy bien diseñado.",
            "La batería dura bastante, ideal para trabajos prolongados.",
            "Producto bien equilibrado, no cansa la mano al usarlo.",
            "Sólido y bien construido, sin piezas flojas o mal ensambladas.",
            "Muy preciso, se nota la calidad de fabricación.",
            "Compacto pero poderoso, lo llevo a todos mis proyectos.",
            "Tiene gran capacidad de corte, muy recomendable.",
            "Los acabados son de primera, realmente vale la pena.",
            "Soporta golpes sin problema, material muy resistente.",
            "El sistema de seguridad es un gran plus, me da confianza al usarlo.",
            "La marca no decepciona, calidad garantizada.",
            "Herramienta profesional a un precio accesible, excelente compra."
        ];

        for ($i = 0; $i < 200; $i++) {
            Rating::create([
                'user_id' => $users[array_rand($users)],
                'product_id' => $products[array_rand($products)],
                'rating' => rand(4, 5),
                'comment' => $comments[array_rand($comments)],
                'featured' => rand(0, 1),
            ]);
        }
    }
}

