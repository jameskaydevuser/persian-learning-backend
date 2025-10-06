<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Category;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            // Fruits
            [
                'category_name' => 'fruits',
                'english_word' => 'Apple',
                'persian_word' => 'سیب',
                'emoji' => '🍎',
                'easy_text' => 'سیب',
                'normal_text' => 'این یک سیب است',
                'hard_text' => 'این میوه چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Orange',
                'persian_word' => 'پرتقال',
                'emoji' => '🍊',
                'easy_text' => 'پرتقال',
                'normal_text' => 'این یک پرتقال است',
                'hard_text' => 'این میوه نارنجی چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Banana',
                'persian_word' => 'موز',
                'emoji' => '🍌',
                'easy_text' => 'موز',
                'normal_text' => 'این یک موز است',
                'hard_text' => 'این میوه زرد چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Grape',
                'persian_word' => 'انگور',
                'emoji' => '🍇',
                'easy_text' => 'انگور',
                'normal_text' => 'این انگور است',
                'hard_text' => 'این میوه کوچک چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Strawberry',
                'persian_word' => 'توت فرنگی',
                'emoji' => '🍓',
                'easy_text' => 'توت فرنگی',
                'normal_text' => 'این توت فرنگی است',
                'hard_text' => 'این میوه قرمز چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Watermelon',
                'persian_word' => 'هندوانه',
                'emoji' => '🍉',
                'easy_text' => 'هندوانه',
                'normal_text' => 'این هندوانه است',
                'hard_text' => 'این میوه بزرگ سبز چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Pineapple',
                'persian_word' => 'آناناس',
                'emoji' => '🍍',
                'easy_text' => 'آناناس',
                'normal_text' => 'این آناناس است',
                'hard_text' => 'این میوه خاردار چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Mango',
                'persian_word' => 'انبه',
                'emoji' => '🥭',
                'easy_text' => 'انبه',
                'normal_text' => 'این انبه است',
                'hard_text' => 'این میوه نارنجی شیرین چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Peach',
                'persian_word' => 'هلو',
                'emoji' => '🍑',
                'easy_text' => 'هلو',
                'normal_text' => 'این هلو است',
                'hard_text' => 'این میوه صورتی چیست؟'
            ],
            [
                'category_name' => 'fruits',
                'english_word' => 'Cherry',
                'persian_word' => 'گیلاس',
                'emoji' => '🍒',
                'easy_text' => 'گیلاس',
                'normal_text' => 'این گیلاس است',
                'hard_text' => 'این میوه کوچک قرمز چیست؟'
            ],
            
            // Animals
            [
                'category_name' => 'animals',
                'english_word' => 'Cat',
                'persian_word' => 'گربه',
                'emoji' => '🐱',
                'easy_text' => 'گربه',
                'normal_text' => 'این یک گربه است',
                'hard_text' => 'این حیوان خانگی چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Dog',
                'persian_word' => 'سگ',
                'emoji' => '🐕',
                'easy_text' => 'سگ',
                'normal_text' => 'این یک سگ است',
                'hard_text' => 'این حیوان وفادار چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Lion',
                'persian_word' => 'شیر',
                'emoji' => '🦁',
                'easy_text' => 'شیر',
                'normal_text' => 'این یک شیر است',
                'hard_text' => 'این حیوان سلطان جنگل چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Elephant',
                'persian_word' => 'فیل',
                'emoji' => '🐘',
                'easy_text' => 'فیل',
                'normal_text' => 'این یک فیل است',
                'hard_text' => 'این حیوان بزرگ با خرطوم چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Giraffe',
                'persian_word' => 'زرافه',
                'emoji' => '🦒',
                'easy_text' => 'زرافه',
                'normal_text' => 'این یک زرافه است',
                'hard_text' => 'این حیوان با گردن بلند چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Monkey',
                'persian_word' => 'میمون',
                'emoji' => '🐒',
                'easy_text' => 'میمون',
                'normal_text' => 'این یک میمون است',
                'hard_text' => 'این حیوان باهوش چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Tiger',
                'persian_word' => 'ببر',
                'emoji' => '🐯',
                'easy_text' => 'ببر',
                'normal_text' => 'این یک ببر است',
                'hard_text' => 'این حیوان با خطوط نارنجی چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Bear',
                'persian_word' => 'خرس',
                'emoji' => '🐻',
                'easy_text' => 'خرس',
                'normal_text' => 'این یک خرس است',
                'hard_text' => 'این حیوان قهوه‌ای بزرگ چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Wolf',
                'persian_word' => 'گرگ',
                'emoji' => '🐺',
                'easy_text' => 'گرگ',
                'normal_text' => 'این یک گرگ است',
                'hard_text' => 'این حیوان وحشی چیست؟'
            ],
            [
                'category_name' => 'animals',
                'english_word' => 'Fox',
                'persian_word' => 'روباه',
                'emoji' => '🦊',
                'easy_text' => 'روباه',
                'normal_text' => 'این یک روباه است',
                'hard_text' => 'این حیوان باهوش نارنجی چیست؟'
            ],
            
            // Numbers
            [
                'category_name' => 'numbers',
                'english_word' => 'One',
                'persian_word' => 'یک',
                'emoji' => '1️⃣',
                'easy_text' => 'یک',
                'normal_text' => 'این عدد یک است',
                'hard_text' => 'اولین عدد چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Two',
                'persian_word' => 'دو',
                'emoji' => '2️⃣',
                'easy_text' => 'دو',
                'normal_text' => 'این عدد دو است',
                'hard_text' => 'عدد بعد از یک چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Three',
                'persian_word' => 'سه',
                'emoji' => '3️⃣',
                'easy_text' => 'سه',
                'normal_text' => 'این عدد سه است',
                'hard_text' => 'عدد بعد از دو چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Four',
                'persian_word' => 'چهار',
                'emoji' => '4️⃣',
                'easy_text' => 'چهار',
                'normal_text' => 'این عدد چهار است',
                'hard_text' => 'عدد بعد از سه چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Five',
                'persian_word' => 'پنج',
                'emoji' => '5️⃣',
                'easy_text' => 'پنج',
                'normal_text' => 'این عدد پنج است',
                'hard_text' => 'عدد بعد از چهار چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Six',
                'persian_word' => 'شش',
                'emoji' => '6️⃣',
                'easy_text' => 'شش',
                'normal_text' => 'این عدد شش است',
                'hard_text' => 'عدد بعد از پنج چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Seven',
                'persian_word' => 'هفت',
                'emoji' => '7️⃣',
                'easy_text' => 'هفت',
                'normal_text' => 'این عدد هفت است',
                'hard_text' => 'عدد بعد از شش چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Eight',
                'persian_word' => 'هشت',
                'emoji' => '8️⃣',
                'easy_text' => 'هشت',
                'normal_text' => 'این عدد هشت است',
                'hard_text' => 'عدد بعد از هفت چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Nine',
                'persian_word' => 'نه',
                'emoji' => '9️⃣',
                'easy_text' => 'نه',
                'normal_text' => 'این عدد نه است',
                'hard_text' => 'عدد بعد از هشت چیست؟'
            ],
            [
                'category_name' => 'numbers',
                'english_word' => 'Ten',
                'persian_word' => 'ده',
                'emoji' => '🔟',
                'easy_text' => 'ده',
                'normal_text' => 'این عدد ده است',
                'hard_text' => 'عدد بعد از نه چیست؟'
            ],
            
            // Shapes
            [
                'category_name' => 'shapes',
                'english_word' => 'Circle',
                'persian_word' => 'دایره',
                'emoji' => '⭕',
                'easy_text' => 'دایره',
                'normal_text' => 'این یک دایره است',
                'hard_text' => 'این شکل گرد چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Square',
                'persian_word' => 'مربع',
                'emoji' => '⬜',
                'easy_text' => 'مربع',
                'normal_text' => 'این یک مربع است',
                'hard_text' => 'این شکل چهارگوش چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Triangle',
                'persian_word' => 'مثلث',
                'emoji' => '🔺',
                'easy_text' => 'مثلث',
                'normal_text' => 'این یک مثلث است',
                'hard_text' => 'این شکل سه گوش چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Rectangle',
                'persian_word' => 'مستطیل',
                'emoji' => '⬜',
                'easy_text' => 'مستطیل',
                'normal_text' => 'این یک مستطیل است',
                'hard_text' => 'این شکل چهارگوش کشیده چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Star',
                'persian_word' => 'ستاره',
                'emoji' => '⭐',
                'easy_text' => 'ستاره',
                'normal_text' => 'این یک ستاره است',
                'hard_text' => 'این شکل درخشان چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Heart',
                'persian_word' => 'قلب',
                'emoji' => '❤️',
                'easy_text' => 'قلب',
                'normal_text' => 'این یک قلب است',
                'hard_text' => 'این شکل عاشقانه چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Diamond',
                'persian_word' => 'الماس',
                'emoji' => '💎',
                'easy_text' => 'الماس',
                'normal_text' => 'این یک الماس است',
                'hard_text' => 'این شکل گرانبها چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Oval',
                'persian_word' => 'بیضی',
                'emoji' => '🥚',
                'easy_text' => 'بیضی',
                'normal_text' => 'این یک بیضی است',
                'hard_text' => 'این شکل تخم مرغی چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Hexagon',
                'persian_word' => 'شش ضلعی',
                'emoji' => '⬡',
                'easy_text' => 'شش ضلعی',
                'normal_text' => 'این یک شش ضلعی است',
                'hard_text' => 'این شکل شش گوش چیست؟'
            ],
            [
                'category_name' => 'shapes',
                'english_word' => 'Pentagon',
                'persian_word' => 'پنج ضلعی',
                'emoji' => '⬟',
                'easy_text' => 'پنج ضلعی',
                'normal_text' => 'این یک پنج ضلعی است',
                'hard_text' => 'این شکل پنج گوش چیست؟'
            ],
            
            // Colors
            [
                'category_name' => 'colors',
                'english_word' => 'Red',
                'persian_word' => 'قرمز',
                'emoji' => '🔴',
                'easy_text' => 'قرمز',
                'normal_text' => 'این رنگ قرمز است',
                'hard_text' => 'رنگ خون چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Blue',
                'persian_word' => 'آبی',
                'emoji' => '🔵',
                'easy_text' => 'آبی',
                'normal_text' => 'این رنگ آبی است',
                'hard_text' => 'رنگ آسمان چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Green',
                'persian_word' => 'سبز',
                'emoji' => '🟢',
                'easy_text' => 'سبز',
                'normal_text' => 'این رنگ سبز است',
                'hard_text' => 'رنگ گیاهان چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Yellow',
                'persian_word' => 'زرد',
                'emoji' => '🟡',
                'easy_text' => 'زرد',
                'normal_text' => 'این رنگ زرد است',
                'hard_text' => 'رنگ خورشید چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Purple',
                'persian_word' => 'بنفش',
                'emoji' => '🟣',
                'easy_text' => 'بنفش',
                'normal_text' => 'این رنگ بنفش است',
                'hard_text' => 'رنگ ترکیبی قرمز و آبی چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Orange',
                'persian_word' => 'نارنجی',
                'emoji' => '🟠',
                'easy_text' => 'نارنجی',
                'normal_text' => 'این رنگ نارنجی است',
                'hard_text' => 'رنگ ترکیبی قرمز و زرد چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Pink',
                'persian_word' => 'صورتی',
                'emoji' => '🩷',
                'easy_text' => 'صورتی',
                'normal_text' => 'این رنگ صورتی است',
                'hard_text' => 'رنگ روشن قرمز چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Brown',
                'persian_word' => 'قهوه‌ای',
                'emoji' => '🟤',
                'easy_text' => 'قهوه‌ای',
                'normal_text' => 'این رنگ قهوه‌ای است',
                'hard_text' => 'رنگ چوب چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'Black',
                'persian_word' => 'سیاه',
                'emoji' => '⚫',
                'easy_text' => 'سیاه',
                'normal_text' => 'این رنگ سیاه است',
                'hard_text' => 'تاریک‌ترین رنگ چیست؟'
            ],
            [
                'category_name' => 'colors',
                'english_word' => 'White',
                'persian_word' => 'سفید',
                'emoji' => '⚪',
                'easy_text' => 'سفید',
                'normal_text' => 'این رنگ سفید است',
                'hard_text' => 'روشن‌ترین رنگ چیست؟'
            ]
        ];

        foreach ($words as $wordData) {
            $category = Category::where('name', $wordData['category_name'])->first();
            
            if ($category) {
                Word::create([
                    'category_id' => $category->id,
                    'english_word' => $wordData['english_word'],
                    'persian_word' => $wordData['persian_word'],
                    'emoji' => $wordData['emoji'],
                    'easy_text' => $wordData['easy_text'],
                    'normal_text' => $wordData['normal_text'],
                    'hard_text' => $wordData['hard_text']
                ]);
            }
        }
    }
}
