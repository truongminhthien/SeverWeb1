<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Category::insert([
            [
                'category_name' => 'Thời Trang',
                'status' => 'active',
            ],
            [
                'category_name' => 'Trang Sức',
                'status' => 'active',
            ],
            [
                'category_name' => 'Đồng Hồ',
                'status' => 'active',
            ],
            [
                'category_name' => 'Mắt Kính',
                'status' => 'active',
            ],
            [
                'category_name' => 'Nước Hoa',
                'status' => 'inactive',
            ],
            [
                'category_name' => 'Trang Điểm',
                'status' => 'inactive',
            ],
        ]);


        \App\Models\User::insert(
            [
                [
                    'username' => 'Thiện Trương',
                    'password' => bcrypt('123'),
                    'email' => 'truongminhthien222004@gmail.com',
                    'phone' => 123456789,
                    'address' => '123 Admin Street',
                    'role' => 0,
                ],
                [
                    'username' => 'Tuấn Hiệp',
                    'password' => bcrypt('123'),
                    'email' => 'tuanhiep@gmail.com',
                    'phone' => 123456789,
                    'address' => '123 Admin Street',
                    'role' => 1,
                ],
            ]
        );
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
