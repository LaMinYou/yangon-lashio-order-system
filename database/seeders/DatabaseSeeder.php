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
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Role::truncate();
        Category::truncate();
        Product::truncate();
        SourceArea::truncate();
        Shop::truncate();
        Gate::truncate();

        // enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory()->create([
            'name' => 'Test User',
            'phone' => '09775121526',
        ]);
        User::factory()->create([
            'name' => 'admin',
            'phone' => '09692921797',
            'password' => 'admin@123#abc',
            'role_id' => 2,
        ]);

        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $cat1 = Category::create(['name' => 'ငပိ']);
        $cat2 = Category::create(['name' => 'ငါးခြောက်']);
        $cat3 = Category::create(['name' => 'ပုစွန်ခြောက်']);

        Product::create(['category_id' => $cat2->id, 'name' => 'ငါးရံ့']);
        Product::create(['category_id' => 2, 'name' => 'အာပြဲ']);
        Product::create(['category_id' => 2, 'name' => 'ကဘလူး']);
        Product::create(['category_id' => 2, 'name' => 'မိသံသွယ်']);
        Product::create(['category_id' => 2, 'name' => 'ငါးဒန်ခွဲ']);
        Product::create(['category_id' => 2, 'name' => 'ငါးမဲလုံး']);
        Product::create(['category_id' => 2, 'name' => 'ငါးလေးထောင့်']);
        Product::create(['category_id' => 2, 'name' => 'ငါးနှပ်']);
        Product::create(['category_id' => 3, 'name' => 'ပုစွန်ပွ']);

        SourceArea::create([ 'name' => 'Zaw']);
        SourceArea::create([ 'name' => 'နဒီ']);
        SourceArea::create([ 'name' => 'အာကာ']);
        SourceArea::create([ 'name' => 'ရတနာသိန်း']);
        SourceArea::create([ 'name' => 'ပြည့်စုံ']);
        SourceArea::create([ 'name' => 'ကမ္ဘာကြီး']);

        Shop::create([ 'name' => 'ဝင်းဝင်း']);

        Gate::create([ 'name' => 'ဒေါ်ခင်ထွေး']);
        Gate::create([ 'name' => 'မပိုပို']);
        Gate::create([ 'name' => 'မဝင်းမာ']);
        Gate::create([ 'name' => 'မိုးထက်']);
        Gate::create([ 'name' => 'ဧရာဝတီ']);

        Unit::create(['name' => 'ခြင်း']);
        Unit::create(['name' => 'အိတ်']);
        Unit::create(['name' => 'ဖော့ဘူး']);
    }
}
