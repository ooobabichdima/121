<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductRelation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categoryNames = [
            'Приводы',
            'Магазины',
            'Шары',
            'АКБ',
            'Зарядки',
            'Защита',
            'Тюнинг',
        ];

        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[$name] = Category::updateOrCreate([
                'slug' => Str::slug($name)
            ], [
                'name' => $name,
            ]);
        }

        $brands = collect([
            'Specna Arms',
            'CYMA',
            'G&G',
            'APS',
            'Tokyo Marui',
            'LCT',
            'PTS',
            'Valken',
            'Nuprol',
        ])->mapWithKeys(fn ($name) => [$name => Brand::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name])]);

        $attributes = collect([
            ['code' => 'platform', 'name' => 'Платформа', 'type' => 'string'],
            ['code' => 'type', 'name' => 'Тип', 'type' => 'string'],
            ['code' => 'fps', 'name' => 'FPS', 'type' => 'number'],
            ['code' => 'material', 'name' => 'Материал', 'type' => 'string'],
            ['code' => 'mosfet', 'name' => 'MOSFET', 'type' => 'bool'],
            ['code' => 'capacity', 'name' => 'Ёмкость', 'type' => 'number'],
            ['code' => 'voltage', 'name' => 'Напряжение', 'type' => 'string'],
            ['code' => 'connector', 'name' => 'Разъём', 'type' => 'string'],
            ['code' => 'compatibility', 'name' => 'Совместимость', 'type' => 'string'],
        ])->mapWithKeys(function ($data) {
            $attr = AttributeDefinition::updateOrCreate(['code' => $data['code']], $data);
            return [$data['code'] => $attr];
        });

        $products = [];

        $rifles = [
            ['name' => 'AEG M4 CQB Base', 'brand' => 'Specna Arms', 'platform' => 'M4', 'fps' => 105, 'material' => 'полимер', 'mosfet' => false, 'price' => 9990, 'stock' => 9],
            ['name' => 'AEG AK Tactical', 'brand' => 'CYMA', 'platform' => 'AK', 'fps' => 115, 'material' => 'металл', 'mosfet' => false, 'price' => 10490, 'stock' => 12],
            ['name' => 'AEG M4 PDW Fast', 'brand' => 'G&G', 'platform' => 'M4', 'fps' => 110, 'material' => 'металл', 'mosfet' => true, 'price' => 12990, 'stock' => 6],
            ['name' => 'AEG SMG-45 CQB', 'brand' => 'APS', 'platform' => 'SMG', 'fps' => 100, 'material' => 'полимер', 'mosfet' => true, 'price' => 11990, 'stock' => 8],
            ['name' => 'AEG AK Classic', 'brand' => 'LCT', 'platform' => 'AK', 'fps' => 120, 'material' => 'металл', 'mosfet' => false, 'price' => 13990, 'stock' => 5],
            ['name' => 'AEG M4 DMR', 'brand' => 'Specna Arms', 'platform' => 'M4', 'fps' => 125, 'material' => 'металл', 'mosfet' => true, 'price' => 14990, 'stock' => 7],
            ['name' => 'AEG M4 Speed Soft', 'brand' => 'APS', 'platform' => 'M4', 'fps' => 100, 'material' => 'полимер', 'mosfet' => true, 'price' => 13290, 'stock' => 10],
            ['name' => 'AEG AKSU Compact', 'brand' => 'CYMA', 'platform' => 'AK', 'fps' => 110, 'material' => 'металл', 'mosfet' => false, 'price' => 11290, 'stock' => 9],
            ['name' => 'GBB SMG Speed', 'brand' => 'Tokyo Marui', 'platform' => 'SMG', 'fps' => 95, 'material' => 'полимер', 'mosfet' => false, 'price' => 15990, 'stock' => 4],
            ['name' => 'HPA M4 Hybrid', 'brand' => 'Specna Arms', 'platform' => 'M4', 'fps' => 130, 'material' => 'металл', 'mosfet' => true, 'price' => 18990, 'stock' => 3],
        ];

        foreach ($rifles as $idx => $rifle) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($rifle['name']),
            ], [
                'category_id' => $categories['Приводы']->id,
                'brand_id' => $brands[$rifle['brand']]->id,
                'name' => $rifle['name'],
                'sku' => 'AEG-'.($idx+1),
                'price' => $rifle['price'],
                'old_price' => $rifle['price'] + 800,
                'stock' => $rifle['stock'],
                'description' => 'Страйкбольный привод '.$rifle['platform'].' с базовой настройкой.',
                'specs_json' => [
                    'platform' => $rifle['platform'],
                    'fps' => $rifle['fps'],
                    'material' => $rifle['material'],
                ],
                'is_featured' => $idx < 3,
                'is_new' => $idx === 0,
            ]);

            $products[] = $product;

            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['platform']->id,
            ], ['value_string' => $rifle['platform']]);

            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['type']->id,
            ], ['value_string' => 'AEG']);

            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['fps']->id,
            ], ['value_number' => $rifle['fps']]);

            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['material']->id,
            ], ['value_string' => $rifle['material']]);

            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['mosfet']->id,
            ], ['value_bool' => $rifle['mosfet']]);

            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/rifle-'.$idx.'.svg'
            ], ['sort' => 0]);
        }

        $magazines = [
            ['name' => 'Магазин M4 Mid-cap 120', 'platform' => 'M4', 'capacity' => 120, 'price' => 390],
            ['name' => 'Магазин AK Mid-cap 140', 'platform' => 'AK', 'capacity' => 140, 'price' => 420],
            ['name' => 'Магазин M4 Hi-cap 300', 'platform' => 'M4', 'capacity' => 300, 'price' => 360],
            ['name' => 'Магазин SMG 100', 'platform' => 'SMG', 'capacity' => 100, 'price' => 350],
        ];

        foreach ($magazines as $i => $mag) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($mag['name']),
            ], [
                'category_id' => $categories['Магазины']->id,
                'brand_id' => $brands['PTS']->id,
                'name' => $mag['name'],
                'sku' => 'MAG-'.($i+1),
                'price' => $mag['price'],
                'stock' => 30,
                'description' => 'Страйкбольный магазин '.$mag['platform'].' с ёмкостью '.$mag['capacity'].' шаров.',
                'is_featured' => $i === 0,
            ]);
            $products[] = $product;
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['platform']->id,
            ], ['value_string' => $mag['platform']]);
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['capacity']->id,
            ], ['value_number' => $mag['capacity']]);
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['type']->id,
            ], ['value_string' => 'magazine']);
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/mag-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        $batteries = [
            ['name' => 'LiPo 7.4V 1200mAh', 'voltage' => '7.4V', 'capacity' => 1200, 'connector' => 'T-Dean', 'price' => 790],
            ['name' => 'LiPo 11.1V 1100mAh', 'voltage' => '11.1V', 'capacity' => 1100, 'connector' => 'Tamiya', 'price' => 850],
            ['name' => 'Li-Ion 7.4V Stick 2000mAh', 'voltage' => '7.4V', 'capacity' => 2000, 'connector' => 'T-Dean', 'price' => 980],
            ['name' => 'LiPo 7.4V Crane 1600mAh', 'voltage' => '7.4V', 'capacity' => 1600, 'connector' => 'T-Dean', 'price' => 820],
        ];
        foreach ($batteries as $i => $bat) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($bat['name']),
            ], [
                'category_id' => $categories['АКБ']->id,
                'brand_id' => $brands['Valken']->id,
                'name' => $bat['name'],
                'sku' => 'BAT-'.($i+1),
                'price' => $bat['price'],
                'stock' => 50,
                'description' => 'LiPo/Li-Ion аккумулятор для страйкбольных приводов.',
                'is_new' => $i === 0,
            ]);
            $products[] = $product;
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['voltage']->id,
            ], ['value_string' => $bat['voltage']]);
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['capacity']->id,
            ], ['value_number' => $bat['capacity']]);
            ProductAttribute::updateOrCreate([
                'product_id' => $product->id,
                'attribute_id' => $attributes['connector']->id,
            ], ['value_string' => $bat['connector']]);
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/bat-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        $chargers = [
            ['name' => 'Зарядка Smart LiPo', 'price' => 1290],
            ['name' => 'Зарядка Balance Pro', 'price' => 1690],
        ];
        foreach ($chargers as $i => $charger) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($charger['name']),
            ], [
                'category_id' => $categories['Зарядки']->id,
                'brand_id' => $brands['Nuprol']->id,
                'name' => $charger['name'],
                'sku' => 'CHR-'.($i+1),
                'price' => $charger['price'],
                'stock' => 20,
                'description' => 'Умная зарядка с балансировкой.',
            ]);
            $products[] = $product;
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/charger-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        $bbs = [
            ['name' => 'Шары 0.25г (1кг)', 'price' => 390],
            ['name' => 'Шары 0.28г (1кг)', 'price' => 420],
            ['name' => 'Шары 0.30г (1кг)', 'price' => 460],
        ];
        foreach ($bbs as $i => $bb) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($bb['name']),
            ], [
                'category_id' => $categories['Шары']->id,
                'brand_id' => $brands['G&G']->id,
                'name' => $bb['name'],
                'sku' => 'BBS-'.($i+1),
                'price' => $bb['price'],
                'stock' => 80,
                'description' => 'Биобезопасные страйкбольные шары.',
                'is_featured' => $i === 0,
            ]);
            $products[] = $product;
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/bbs-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        $protection = [
            ['name' => 'Очки страйкбольные', 'price' => 990],
            ['name' => 'Маска сетчатая', 'price' => 690],
            ['name' => 'Шлем легкий', 'price' => 1990],
            ['name' => 'Перчатки тактические', 'price' => 790],
            ['name' => 'Наушники активные (demo)', 'price' => 2790],
        ];
        foreach ($protection as $i => $item) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($item['name']),
            ], [
                'category_id' => $categories['Защита']->id,
                'brand_id' => $brands['Nuprol']->id,
                'name' => $item['name'],
                'sku' => 'SAFE-'.($i+1),
                'price' => $item['price'],
                'stock' => 25,
                'description' => 'Средства защиты для игры.',
            ]);
            $products[] = $product;
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/protect-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        $tuning = [
            ['name' => 'Набор тюнинга “Стабильность”', 'price' => 1490],
            ['name' => 'Набор тюнинга “Реакция”', 'price' => 2490],
            ['name' => 'Набор тюнинга “Дальность”', 'price' => 3290],
        ];
        foreach ($tuning as $i => $kit) {
            $product = Product::updateOrCreate([
                'slug' => Str::slug($kit['name']),
            ], [
                'category_id' => $categories['Тюнинг']->id,
                'brand_id' => $brands['Specna Arms']->id,
                'name' => $kit['name'],
                'sku' => 'TUNE-'.($i+1),
                'price' => $kit['price'],
                'stock' => 99,
                'description' => 'Готовый пакет апгрейда.',
            ]);
            $products[] = $product;
            ProductImage::updateOrCreate([
                'product_id' => $product->id,
                'path' => '/images/placeholders/tune-'.$i.'.svg'
            ], ['sort' => 0]);
        }

        // relations: add tuning kits and recommended bundles for first 5 rifles
        $rifleProducts = array_slice($products, 0, 5);
        foreach ($rifleProducts as $p) {
            foreach ($tuning as $idx => $kit) {
                $kitProduct = Product::where('sku', 'TUNE-'.($idx+1))->first();
                if ($kitProduct) {
                    ProductRelation::updateOrCreate([
                        'product_id' => $p->id,
                        'related_id' => $kitProduct->id,
                        'type' => 'tuning_kit',
                    ]);
                }
            }
            // recommended: goggles, bbs, magazines
            $recommendedSkus = ['SAFE-1', 'BBS-1', 'MAG-1'];
            foreach ($recommendedSkus as $sku) {
                $related = Product::where('sku', $sku)->first();
                if ($related) {
                    ProductRelation::updateOrCreate([
                        'product_id' => $p->id,
                        'related_id' => $related->id,
                        'type' => 'recommended',
                    ]);
                }
            }
        }
    }
}
