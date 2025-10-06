<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Word;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if categories already exist
        if (Category::count() == 0) {
            $categories = [
                [
                    'name' => 'fruits',
                    'persian_name' => 'میوه‌ها',
                    'description' => 'Learn the names of different fruits in Persian'
                ],
                [
                    'name' => 'animals',
                    'persian_name' => 'حیوانات',
                    'description' => 'Learn the names of different animals in Persian'
                ],
                [
                    'name' => 'numbers',
                    'persian_name' => 'اعداد',
                    'description' => 'Learn numbers in Persian'
                ],
                [
                    'name' => 'shapes',
                    'persian_name' => 'اشکال',
                    'description' => 'Learn the names of different shapes in Persian'
                ],
                [
                    'name' => 'colors',
                    'persian_name' => 'رنگ‌ها',
                    'description' => 'Learn the names of different colors in Persian'
                ]
            ];

            foreach ($categories as $category) {
                Category::create($category);
            }
        }

        // Check if words already exist
        if (Word::count() == 0) {
            $words = [
                // Fruits
                ['category_name' => 'fruits', 'english_word' => 'Apple', 'persian_word' => 'سیب', 'emoji' => '🍎'],
                ['category_name' => 'fruits', 'english_word' => 'Orange', 'persian_word' => 'پرتقال', 'emoji' => '🍊'],
                ['category_name' => 'fruits', 'english_word' => 'Banana', 'persian_word' => 'موز', 'emoji' => '🍌'],
                ['category_name' => 'fruits', 'english_word' => 'Grape', 'persian_word' => 'انگور', 'emoji' => '🍇'],
                ['category_name' => 'fruits', 'english_word' => 'Strawberry', 'persian_word' => 'توت فرنگی', 'emoji' => '🍓'],
                ['category_name' => 'fruits', 'english_word' => 'Watermelon', 'persian_word' => 'هندوانه', 'emoji' => '🍉'],
                ['category_name' => 'fruits', 'english_word' => 'Pineapple', 'persian_word' => 'آناناس', 'emoji' => '🍍'],
                ['category_name' => 'fruits', 'english_word' => 'Mango', 'persian_word' => 'انبه', 'emoji' => '🥭'],
                ['category_name' => 'fruits', 'english_word' => 'Peach', 'persian_word' => 'هلو', 'emoji' => '🍑'],
                ['category_name' => 'fruits', 'english_word' => 'Cherry', 'persian_word' => 'گیلاس', 'emoji' => '🍒'],
                
                // Animals
                ['category_name' => 'animals', 'english_word' => 'Cat', 'persian_word' => 'گربه', 'emoji' => '🐱'],
                ['category_name' => 'animals', 'english_word' => 'Dog', 'persian_word' => 'سگ', 'emoji' => '🐕'],
                ['category_name' => 'animals', 'english_word' => 'Lion', 'persian_word' => 'شیر', 'emoji' => '🦁'],
                ['category_name' => 'animals', 'english_word' => 'Elephant', 'persian_word' => 'فیل', 'emoji' => '🐘'],
                ['category_name' => 'animals', 'english_word' => 'Giraffe', 'persian_word' => 'زرافه', 'emoji' => '🦒'],
                ['category_name' => 'animals', 'english_word' => 'Monkey', 'persian_word' => 'میمون', 'emoji' => '🐒'],
                ['category_name' => 'animals', 'english_word' => 'Tiger', 'persian_word' => 'ببر', 'emoji' => '🐯'],
                ['category_name' => 'animals', 'english_word' => 'Bear', 'persian_word' => 'خرس', 'emoji' => '🐻'],
                ['category_name' => 'animals', 'english_word' => 'Wolf', 'persian_word' => 'گرگ', 'emoji' => '🐺'],
                ['category_name' => 'animals', 'english_word' => 'Fox', 'persian_word' => 'روباه', 'emoji' => '🦊'],
                
                // Numbers
                ['category_name' => 'numbers', 'english_word' => 'One', 'persian_word' => 'یک', 'emoji' => '1️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Two', 'persian_word' => 'دو', 'emoji' => '2️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Three', 'persian_word' => 'سه', 'emoji' => '3️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Four', 'persian_word' => 'چهار', 'emoji' => '4️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Five', 'persian_word' => 'پنج', 'emoji' => '5️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Six', 'persian_word' => 'شش', 'emoji' => '6️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Seven', 'persian_word' => 'هفت', 'emoji' => '7️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Eight', 'persian_word' => 'هشت', 'emoji' => '8️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Nine', 'persian_word' => 'نه', 'emoji' => '9️⃣'],
                ['category_name' => 'numbers', 'english_word' => 'Ten', 'persian_word' => 'ده', 'emoji' => '🔟'],
                
                // Shapes
                ['category_name' => 'shapes', 'english_word' => 'Circle', 'persian_word' => 'دایره', 'emoji' => '⭕'],
                ['category_name' => 'shapes', 'english_word' => 'Square', 'persian_word' => 'مربع', 'emoji' => '⬜'],
                ['category_name' => 'shapes', 'english_word' => 'Triangle', 'persian_word' => 'مثلث', 'emoji' => '🔺'],
                ['category_name' => 'shapes', 'english_word' => 'Rectangle', 'persian_word' => 'مستطیل', 'emoji' => '⬜'],
                ['category_name' => 'shapes', 'english_word' => 'Star', 'persian_word' => 'ستاره', 'emoji' => '⭐'],
                ['category_name' => 'shapes', 'english_word' => 'Heart', 'persian_word' => 'قلب', 'emoji' => '❤️'],
                ['category_name' => 'shapes', 'english_word' => 'Diamond', 'persian_word' => 'الماس', 'emoji' => '💎'],
                ['category_name' => 'shapes', 'english_word' => 'Oval', 'persian_word' => 'بیضی', 'emoji' => '🥚'],
                ['category_name' => 'shapes', 'english_word' => 'Hexagon', 'persian_word' => 'شش ضلعی', 'emoji' => '⬡'],
                ['category_name' => 'shapes', 'english_word' => 'Pentagon', 'persian_word' => 'پنج ضلعی', 'emoji' => '⬟'],
                
                // Colors
                ['category_name' => 'colors', 'english_word' => 'Red', 'persian_word' => 'قرمز', 'emoji' => '🔴'],
                ['category_name' => 'colors', 'english_word' => 'Blue', 'persian_word' => 'آبی', 'emoji' => '🔵'],
                ['category_name' => 'colors', 'english_word' => 'Green', 'persian_word' => 'سبز', 'emoji' => '🟢'],
                ['category_name' => 'colors', 'english_word' => 'Yellow', 'persian_word' => 'زرد', 'emoji' => '🟡'],
                ['category_name' => 'colors', 'english_word' => 'Purple', 'persian_word' => 'بنفش', 'emoji' => '🟣'],
                ['category_name' => 'colors', 'english_word' => 'Orange', 'persian_word' => 'نارنجی', 'emoji' => '🟠'],
                ['category_name' => 'colors', 'english_word' => 'Pink', 'persian_word' => 'صورتی', 'emoji' => '🩷'],
                ['category_name' => 'colors', 'english_word' => 'Brown', 'persian_word' => 'قهوه‌ای', 'emoji' => '🟤'],
                ['category_name' => 'colors', 'english_word' => 'Black', 'persian_word' => 'سیاه', 'emoji' => '⚫'],
                ['category_name' => 'colors', 'english_word' => 'White', 'persian_word' => 'سفید', 'emoji' => '⚪']
            ];

            foreach ($words as $wordData) {
                $category = Category::where('name', $wordData['category_name'])->first();
                
                if ($category) {
                    Word::create([
                        'category_id' => $category->id,
                        'english_word' => $wordData['english_word'],
                        'persian_word' => $wordData['persian_word'],
                        'emoji' => $wordData['emoji'],
                        'easy_text' => $wordData['persian_word'],
                        'normal_text' => 'این ' . $wordData['persian_word'] . ' است',
                        'hard_text' => 'این چیست؟'
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't delete data in down migration
    }
};
