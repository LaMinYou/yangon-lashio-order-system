<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Gate;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use App\Models\SourceArea;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Role::truncate();
        Category::truncate();
        Product::truncate();
        SourceArea::truncate();
        Shop::truncate();
        Gate::truncate();
        Unit::truncate(); // Added this to keep it consistent

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create Roles first (since Users depend on role_id)
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        // 3. Create Users manually (No Factory/Faker used here)
        User::create([
            'name' => 'Test User',
            'phone' => '09775121526',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'birth_date' => '2000-01-01',
        ]);

        User::create([
            'name' => 'admin',
            'phone' => '09692921797',
            'password' => Hash::make('admin@123#abc'),
            'role_id' => 2,
            'birth_date' => '1990-01-01',
        ]);

        // 4. Create Categories
        $cat1 = Category::create(['name' => 'ငပိ']);
        $cat2 = Category::create(['name' => 'ငါးခြောက်']);
        $cat3 = Category::create(['name' => 'ပုစွန်ခြောက်']);

        // 5. Create Products
        Product::create(['category_id' => $cat2->id, 'name' => 'ငါးရံ့']);
        Product::create(['category_id' => 2, 'name' => 'အာပြဲ']);
        Product::create(['category_id' => 2, 'name' => 'ကဘလူး']);
        Product::create(['category_id' => 2, 'name' => 'မိသံသွယ်']);
        Product::create(['category_id' => 2, 'name' => 'ငါးဒန်ခွဲ']);
        Product::create(['category_id' => 2, 'name' => 'ငါးမဲလုံး']);
        Product::create(['category_id' => 2, 'name' => 'ငါးလေးထောင့်']);
        Product::create(['category_id' => 2, 'name' => 'ငါးနှပ်']);
        Product::create(['category_id' => 3, 'name' => 'ပုစွန်ပွ']);

        // 6. Create Miscellaneous Data
        SourceArea::create(['name' => 'Zaw']);
        SourceArea::create(['name' => 'နဒီ']);
        SourceArea::create(['name' => 'အာကာ']);
        SourceArea::create(['name' => 'ရတနာသိန်း']);
        SourceArea::create(['name' => 'ပြည့်စုံ']);
        SourceArea::create(['name' => 'ကမ္ဘာကြီး']);

        Shop::create(['name' => 'ဝင်းဝင်း']);

        Gate::create(['name' => 'ဒေါ်ခင်ထွေး']);
        Gate::create(['name' => 'မပိုပို']);
        Gate::create(['name' => 'မဝင်းမာ']);
        Gate::create(['name' => 'မိုးထက်']);
        Gate::create(['name' => 'ဧရာဝတီ']);

        Unit::create(['name' => 'ခြင်း']);
        Unit::create(['name' => 'အိတ်']);
        Unit::create(['name' => 'ဖော့ဘူး']);
    }
}
