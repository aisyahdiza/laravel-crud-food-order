<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Admin', 'email' => 'admin@dudukdulu.test', 'role' => 'admin', 'phone' => '081234567890'],
            ['name' => 'Customer Contoh', 'email' => 'customer@dudukdulu.test', 'role' => 'customer', 'phone' => '081298765432'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);
            $user->forceFill([
                'name' => $account['name'],
                'role' => $account['role'],
                'phone' => $account['phone'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->save();
        }

        $data = [
            'Main Course' => [
                ['Grilled Garlic Butter Chicken', 'Tender grilled chicken breast with garlic butter', 38000],
                ['Classic Beef Bolognese', 'Al dente pasta in slow-cooked beef ragu with parmesan', 42000],
                ['Pan-Seared Salmon', 'Crispy salmon fillet with lemon herb oil and asparagus', 65000],
                ['Smoky BBQ Beef Burger', 'Juicy beef patty with cheddar cheese and barbecue sauce', 45000],
                ['Indonesian Nasi Goreng', 'Traditional fried rice with chicken satay and fried egg', 35000],
            ],
            'Snack & Appetizer' => [
                ['Crispy Seasoned Tofu', 'Golden crispy tofu cubes with sweet chili sauce', 18000],
                ['Truffle Parmesan Fries', 'Hand-cut fries tossed in truffle oil and parmesan', 28000],
                ['Loaded Nachos Supreme', 'Tortilla chips with melted cheese, salsa, and sour cream', 32000],
                ['Crispy Calamari Rings', 'Battered squid rings served with garlic aioli', 30000],
                ['Vegetable Spring Rolls', 'Crispy rolls filled with vegetables and sweet plum sauce', 20000],
            ],
            'Beverage' => [
                ['Iced Lemon Mint Tea', 'Brewed black tea with lemon juice and crushed mint', 15000],
                ['Matcha Oat Milk Latte', 'Japanese green tea with creamy iced oat milk', 28000],
                ['Sparkling Passion Fruit', 'Passion fruit pulp with fresh lime and soda water', 22000],
                ['Iced Caramel Macchiato', 'Espresso with cold milk, vanilla, and caramel drizzle', 25000],
                ['Strawberry Mango Smoothie', 'Blended fresh strawberries, mango, and Greek yogurt', 27000],
            ],
            'Dessert' => [
                ['Mango Sticky Rice', 'Sweet ripe mango with warm sticky rice and coconut cream', 25000],
                ['Fudgy Chocolate Brownie', 'Warm chocolate brownie with vanilla ice cream', 28000],
                ['New York Cheesecake', 'Classic cheesecake with fresh mixed berry compote', 32000],
                ['Vanilla Bean Panna Cotta', 'Silky Italian cooked cream with passion fruit coulis', 26000],
                ['Churros Dark Chocolate', 'Crispy cinnamon pastries with thick dark chocolate dip', 24000],
            ],
        ];

        foreach ($data as $categoryName => $menus){
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($menus as [$name, $description, $price]){
                Menu::updateOrCreate(
                    ['name' => $name],
                    [
                        'category_id' => $category->id,
                        'description' => $description,
                        'price' => $price,
                        'is_available' => true,
                    ]
                );
            }

            Menu::where('name', 'Vegetable Spring Rolls')->update(['is_available' => false]);
        }
    }
}
