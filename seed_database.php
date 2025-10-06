<?php

// Simple script to seed the database
$pdo = new PDO('sqlite:database/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if categories exist
$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
$categoryCount = $stmt->fetchColumn();

if ($categoryCount == 0) {
    echo "Seeding categories...\n";
    
    $categories = [
        ['fruits', 'میوه‌ها', 'Learn the names of different fruits in Persian'],
        ['animals', 'حیوانات', 'Learn the names of different animals in Persian'],
        ['numbers', 'اعداد', 'Learn numbers in Persian'],
        ['shapes', 'اشکال', 'Learn the names of different shapes in Persian'],
        ['colors', 'رنگ‌ها', 'Learn the names of different colors in Persian']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO categories (name, persian_name, description, created_at, updated_at) VALUES (?, ?, ?, datetime('now'), datetime('now'))");
    
    foreach ($categories as $category) {
        $stmt->execute($category);
    }
    
    echo "Categories seeded!\n";
}

// Check if words exist
$stmt = $pdo->query("SELECT COUNT(*) FROM words");
$wordCount = $stmt->fetchColumn();

if ($wordCount == 0) {
    echo "Seeding words...\n";
    
    // Get category IDs
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    $words = [
        // Fruits
        ['fruits', 'Apple', 'سیب', '🍎'],
        ['fruits', 'Orange', 'پرتقال', '🍊'],
        ['fruits', 'Banana', 'موز', '🍌'],
        ['fruits', 'Grape', 'انگور', '🍇'],
        ['fruits', 'Strawberry', 'توت فرنگی', '🍓'],
        ['fruits', 'Watermelon', 'هندوانه', '🍉'],
        ['fruits', 'Pineapple', 'آناناس', '🍍'],
        ['fruits', 'Mango', 'انبه', '🥭'],
        ['fruits', 'Peach', 'هلو', '🍑'],
        ['fruits', 'Cherry', 'گیلاس', '🍒'],
        
        // Animals
        ['animals', 'Cat', 'گربه', '🐱'],
        ['animals', 'Dog', 'سگ', '🐕'],
        ['animals', 'Lion', 'شیر', '🦁'],
        ['animals', 'Elephant', 'فیل', '🐘'],
        ['animals', 'Giraffe', 'زرافه', '🦒'],
        ['animals', 'Monkey', 'میمون', '🐒'],
        ['animals', 'Tiger', 'ببر', '🐯'],
        ['animals', 'Bear', 'خرس', '🐻'],
        ['animals', 'Wolf', 'گرگ', '🐺'],
        ['animals', 'Fox', 'روباه', '🦊'],
        
        // Numbers
        ['numbers', 'One', 'یک', '1️⃣'],
        ['numbers', 'Two', 'دو', '2️⃣'],
        ['numbers', 'Three', 'سه', '3️⃣'],
        ['numbers', 'Four', 'چهار', '4️⃣'],
        ['numbers', 'Five', 'پنج', '5️⃣'],
        ['numbers', 'Six', 'شش', '6️⃣'],
        ['numbers', 'Seven', 'هفت', '7️⃣'],
        ['numbers', 'Eight', 'هشت', '8️⃣'],
        ['numbers', 'Nine', 'نه', '9️⃣'],
        ['numbers', 'Ten', 'ده', '🔟'],
        
        // Shapes
        ['shapes', 'Circle', 'دایره', '⭕'],
        ['shapes', 'Square', 'مربع', '⬜'],
        ['shapes', 'Triangle', 'مثلث', '🔺'],
        ['shapes', 'Rectangle', 'مستطیل', '⬜'],
        ['shapes', 'Star', 'ستاره', '⭐'],
        ['shapes', 'Heart', 'قلب', '❤️'],
        ['shapes', 'Diamond', 'الماس', '💎'],
        ['shapes', 'Oval', 'بیضی', '🥚'],
        ['shapes', 'Hexagon', 'شش ضلعی', '⬡'],
        ['shapes', 'Pentagon', 'پنج ضلعی', '⬟'],
        
        // Colors
        ['colors', 'Red', 'قرمز', '🔴'],
        ['colors', 'Blue', 'آبی', '🔵'],
        ['colors', 'Green', 'سبز', '🟢'],
        ['colors', 'Yellow', 'زرد', '🟡'],
        ['colors', 'Purple', 'بنفش', '🟣'],
        ['colors', 'Orange', 'نارنجی', '🟠'],
        ['colors', 'Pink', 'صورتی', '🩷'],
        ['colors', 'Brown', 'قهوه‌ای', '🟤'],
        ['colors', 'Black', 'سیاه', '⚫'],
        ['colors', 'White', 'سفید', '⚪']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO words (category_id, english_word, persian_word, emoji, easy_text, normal_text, hard_text, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))");
    
    foreach ($words as $word) {
        $categoryId = $categories[$word[0]];
        $easyText = $word[2];
        $normalText = 'این ' . $word[2] . ' است';
        $hardText = 'این چیست؟';
        
        $stmt->execute([$categoryId, $word[1], $word[2], $word[3], $easyText, $normalText, $hardText]);
    }
    
    echo "Words seeded!\n";
}

echo "Database seeding completed!\n";
