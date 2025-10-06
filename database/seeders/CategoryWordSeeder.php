<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Word;

class CategoryWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $fruits = Category::create([
            'name' => 'Fruits',
            'persian_name' => 'میوه‌ها',
            'description' => 'Learn about different fruits in Persian'
        ]);

        $animals = Category::create([
            'name' => 'Animals',
            'persian_name' => 'حیوانات',
            'description' => 'Learn about different animals in Persian'
        ]);

        $numbers = Category::create([
            'name' => 'Numbers',
            'persian_name' => 'اعداد',
            'description' => 'Learn numbers in Persian'
        ]);

        $shapes = Category::create([
            'name' => 'Shapes',
            'persian_name' => 'اشکال',
            'description' => 'Learn about different shapes in Persian'
        ]);

        $colors = Category::create([
            'name' => 'Colors',
            'persian_name' => 'رنگ‌ها',
            'description' => 'Learn about different colors in Persian'
        ]);

        // Create Words for Fruits
        $fruitsWords = [
            [
                'english_word' => 'Apple',
                'persian_word' => 'سیب',
                'emoji' => '🍎',
                'easy_text' => 'سیب',
                'normal_text' => 'این یک سیب قرمز است',
                'hard_text' => 'آیا می‌توانید سیب را ببینید؟'
            ],
            [
                'english_word' => 'Banana',
                'persian_word' => 'موز',
                'emoji' => '🍌',
                'easy_text' => 'موز',
                'normal_text' => 'موز زرد و خوشمزه است',
                'hard_text' => 'چرا موز برای سلامتی مفید است؟'
            ],
            [
                'english_word' => 'Orange',
                'persian_word' => 'پرتقال',
                'emoji' => '🍊',
                'easy_text' => 'پرتقال',
                'normal_text' => 'پرتقال آبدار و شیرین است',
                'hard_text' => 'آیا پرتقال ویتامین C دارد؟'
            ],
            [
                'english_word' => 'Grape',
                'persian_word' => 'انگور',
                'emoji' => '🍇',
                'easy_text' => 'انگور',
                'normal_text' => 'انگور سبز و بنفش است',
                'hard_text' => 'انگور از کجا می‌آید؟'
            ],
            [
                'english_word' => 'Strawberry',
                'persian_word' => 'توت فرنگی',
                'emoji' => '🍓',
                'easy_text' => 'توت فرنگی',
                'normal_text' => 'توت فرنگی قرمز و شیرین است',
                'hard_text' => 'توت فرنگی در کدام فصل رشد می‌کند؟'
            ]
        ];

        foreach ($fruitsWords as $wordData) {
            Word::create(array_merge($wordData, ['category_id' => $fruits->id]));
        }

        // Create Words for Animals
        $animalsWords = [
            [
                'english_word' => 'Cat',
                'persian_word' => 'گربه',
                'emoji' => '🐱',
                'easy_text' => 'گربه',
                'normal_text' => 'گربه حیوان خانگی است',
                'hard_text' => 'گربه چند پا دارد؟'
            ],
            [
                'english_word' => 'Dog',
                'persian_word' => 'سگ',
                'emoji' => '🐶',
                'easy_text' => 'سگ',
                'normal_text' => 'سگ وفادار و دوست‌داشتنی است',
                'hard_text' => 'سگ چگونه با انسان ارتباط برقرار می‌کند؟'
            ],
            [
                'english_word' => 'Bird',
                'persian_word' => 'پرنده',
                'emoji' => '🐦',
                'easy_text' => 'پرنده',
                'normal_text' => 'پرنده در آسمان پرواز می‌کند',
                'hard_text' => 'پرنده چگونه آواز می‌خواند؟'
            ],
            [
                'english_word' => 'Fish',
                'persian_word' => 'ماهی',
                'emoji' => '🐟',
                'easy_text' => 'ماهی',
                'normal_text' => 'ماهی در آب شنا می‌کند',
                'hard_text' => 'ماهی چگونه نفس می‌کشد؟'
            ],
            [
                'english_word' => 'Rabbit',
                'persian_word' => 'خرگوش',
                'emoji' => '🐰',
                'easy_text' => 'خرگوش',
                'normal_text' => 'خرگوش سریع می‌دود',
                'hard_text' => 'خرگوش چه غذایی می‌خورد؟'
            ]
        ];

        foreach ($animalsWords as $wordData) {
            Word::create(array_merge($wordData, ['category_id' => $animals->id]));
        }

        // Create Words for Numbers
        $numbersWords = [
            [
                'english_word' => 'One',
                'persian_word' => 'یک',
                'emoji' => '1️⃣',
                'easy_text' => 'یک',
                'normal_text' => 'یک عدد اول است',
                'hard_text' => 'یک به چه معناست؟'
            ],
            [
                'english_word' => 'Two',
                'persian_word' => 'دو',
                'emoji' => '2️⃣',
                'easy_text' => 'دو',
                'normal_text' => 'دو عدد زوج است',
                'hard_text' => 'دو از یک بزرگتر است؟'
            ],
            [
                'english_word' => 'Three',
                'persian_word' => 'سه',
                'emoji' => '3️⃣',
                'easy_text' => 'سه',
                'normal_text' => 'سه عدد فرد است',
                'hard_text' => 'سه ضربدر دو چند می‌شود؟'
            ],
            [
                'english_word' => 'Four',
                'persian_word' => 'چهار',
                'emoji' => '4️⃣',
                'easy_text' => 'چهار',
                'normal_text' => 'چهار عدد زوج است',
                'hard_text' => 'چهار به چه شکل نوشته می‌شود؟'
            ],
            [
                'english_word' => 'Five',
                'persian_word' => 'پنج',
                'emoji' => '5️⃣',
                'easy_text' => 'پنج',
                'normal_text' => 'پنج عدد فرد است',
                'hard_text' => 'پنج از چهار بزرگتر است؟'
            ]
        ];

        foreach ($numbersWords as $wordData) {
            Word::create(array_merge($wordData, ['category_id' => $numbers->id]));
        }

        // Create Words for Shapes
        $shapesWords = [
            [
                'english_word' => 'Circle',
                'persian_word' => 'دایره',
                'emoji' => '⭕',
                'easy_text' => 'دایره',
                'normal_text' => 'دایره شکل گرد است',
                'hard_text' => 'دایره چند ضلع دارد؟'
            ],
            [
                'english_word' => 'Square',
                'persian_word' => 'مربع',
                'emoji' => '⬜',
                'easy_text' => 'مربع',
                'normal_text' => 'مربع چهار ضلع دارد',
                'hard_text' => 'مربع چه تفاوتی با مستطیل دارد؟'
            ],
            [
                'english_word' => 'Triangle',
                'persian_word' => 'مثلث',
                'emoji' => '🔺',
                'easy_text' => 'مثلث',
                'normal_text' => 'مثلث سه ضلع دارد',
                'hard_text' => 'مثلث چند زاویه دارد؟'
            ],
            [
                'english_word' => 'Rectangle',
                'persian_word' => 'مستطیل',
                'emoji' => '📱',
                'easy_text' => 'مستطیل',
                'normal_text' => 'مستطیل چهار ضلع دارد',
                'hard_text' => 'مستطیل چه تفاوتی با مربع دارد؟'
            ],
            [
                'english_word' => 'Star',
                'persian_word' => 'ستاره',
                'emoji' => '⭐',
                'easy_text' => 'ستاره',
                'normal_text' => 'ستاره در آسمان می‌درخشد',
                'hard_text' => 'ستاره چند پر دارد؟'
            ]
        ];

        foreach ($shapesWords as $wordData) {
            Word::create(array_merge($wordData, ['category_id' => $shapes->id]));
        }

        // Create Words for Colors
        $colorsWords = [
            [
                'english_word' => 'Red',
                'persian_word' => 'قرمز',
                'emoji' => '🔴',
                'easy_text' => 'قرمز',
                'normal_text' => 'قرمز رنگ گرم است',
                'hard_text' => 'قرمز نماد چیست؟'
            ],
            [
                'english_word' => 'Blue',
                'persian_word' => 'آبی',
                'emoji' => '🔵',
                'easy_text' => 'آبی',
                'normal_text' => 'آبی رنگ آسمان است',
                'hard_text' => 'آبی چه احساسی ایجاد می‌کند؟'
            ],
            [
                'english_word' => 'Green',
                'persian_word' => 'سبز',
                'emoji' => '🟢',
                'easy_text' => 'سبز',
                'normal_text' => 'سبز رنگ طبیعت است',
                'hard_text' => 'سبز نماد چیست؟'
            ],
            [
                'english_word' => 'Yellow',
                'persian_word' => 'زرد',
                'emoji' => '🟡',
                'easy_text' => 'زرد',
                'normal_text' => 'زرد رنگ خورشید است',
                'hard_text' => 'زرد چه احساسی ایجاد می‌کند؟'
            ],
            [
                'english_word' => 'Purple',
                'persian_word' => 'بنفش',
                'emoji' => '🟣',
                'easy_text' => 'بنفش',
                'normal_text' => 'بنفش رنگ زیبایی است',
                'hard_text' => 'بنفش از ترکیب چه رنگ‌هایی ساخته می‌شود؟'
            ]
        ];

        foreach ($colorsWords as $wordData) {
            Word::create(array_merge($wordData, ['category_id' => $colors->id]));
        }
    }
}
