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


        $categories = [
            [
                'category_name' => 'Thời Trang',
                'category_image' => 'categories/thoitrang.jpg',
                'status' => 'inactive',
            ],
            [
                'category_name' => 'Nước Hoa',
                'category_image' => 'categories/nuochoa.jpg',
                'status' => 'active',
            ],
            [
                'category_name' => 'Đồng Hồ',
                'category_image' => 'categories/dongho.jpg',
                'status' => 'active',
            ],
            [
                'category_name' => 'Mắt Kính',
                'category_image' => 'categories/matkinh.jpg',
                'status' => 'active',
            ],
            [
                'category_name' => 'Trang Sức',
                'category_image' => 'categories/trangsuc.jpg',
                'status' => 'active',
            ],
            [
                'category_name' => 'Trang Điểm',
                'category_image' => 'categories/trangdiem.jpg',
                'status' => 'inactive',
            ],

            [
                'category_name' => 'Túi xách Chanel',
                'status' => 'active',
                'id_parent' => 1,
            ],
            [
                'category_name' => 'Giày dép Chanel',
                'status' => 'active',
                'id_parent' => 1,
            ],
            [
                'category_name' => 'Áo khoác Chanel',
                'status' => 'active',
                'id_parent' => 1,
            ],
            // Nước Hoa
            [
                'category_name' => 'Nước hoa nữ Chanel',
                'status' => 'active',
                'id_parent' => 2,
            ],
            [
                'category_name' => 'Nước hoa nam Chanel',
                'status' => 'active',
                'id_parent' => 2,
            ],
            [
                'category_name' => 'Nước hoa unisex Chanel',
                'status' => 'active',
                'id_parent' => 2,
            ],
            // Đồng Hồ
            [
                'category_name' => 'Đồng hồ nữ Chanel',
                'status' => 'active',
                'id_parent' => 3,
            ],
            [
                'category_name' => 'Đồng hồ nam Chanel',
                'status' => 'active',
                'id_parent' => 3,
            ],
            [
                'category_name' => 'Đồng hồ unisex Chanel',
                'status' => 'active',
                'id_parent' => 3,
            ],
            // Mắt Kính
            [
                'category_name' => 'Kính mát nữ Chanel',
                'status' => 'active',
                'id_parent' => 4,
            ],
            [
                'category_name' => 'Kính mát nam Chanel',
                'status' => 'active',
                'id_parent' => 4,
            ],
            [
                'category_name' => 'Kính mát unisex Chanel',
                'status' => 'active',
                'id_parent' => 4,
            ],
            // Trang Sức
            [
                'category_name' => 'Vòng tay Chanel',
                'status' => 'active',
                'id_parent' => 5,
            ],
            [
                'category_name' => 'Nhẫn Chanel',
                'status' => 'active',
                'id_parent' => 5,
            ],
            // Trang Điểm
            [
                'category_name' => 'Son môi Chanel',
                'status' => 'inactive',
                'id_parent' => 6,
            ],
            [
                'category_name' => 'Phấn nền Chanel',
                'status' => 'inactive',
                'id_parent' => 6,
            ],
            [
                'category_name' => 'Túi xách',
                'category_image' => 'categories/tui_xach.jpg',
                'status' => 'inactive',
            ],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }

        // Category::created([
        //     // Thời Trang
        //     [
        //         'category_name' => 'Túi xách Chanel',
        //         'status' => 'active',
        //         'id_parent' => 1,
        //     ],
        //     [
        //         'category_name' => 'Giày dép Chanel',
        //         'status' => 'active',
        //         'id_parent' => 1,
        //     ],
        //     [
        //         'category_name' => 'Áo khoác Chanel',
        //         'status' => 'active',
        //         'id_parent' => 1,
        //     ],
        //     // Nước Hoa
        //     [
        //         'category_name' => 'Nước hoa nữ Chanel',
        //         'status' => 'active',
        //         'id_parent' => 2,
        //     ],
        //     [
        //         'category_name' => 'Nước hoa nam Chanel',
        //         'status' => 'active',
        //         'id_parent' => 2,
        //     ],
        //     [
        //         'category_name' => 'Nước hoa unisex Chanel',
        //         'status' => 'active',
        //         'id_parent' => 2,
        //     ],
        //     // Đồng Hồ
        //     [
        //         'category_name' => 'Đồng hồ nữ Chanel',
        //         'status' => 'active',
        //         'id_parent' => 3,
        //     ],
        //     [
        //         'category_name' => 'Đồng hồ nam Chanel',
        //         'status' => 'active',
        //         'id_parent' => 3,
        //     ],
        //     [
        //         'category_name' => 'Đồng hồ unisex Chanel',
        //         'status' => 'active',
        //         'id_parent' => 3,
        //     ],
        //     // Mắt Kính
        //     [
        //         'category_name' => 'Kính mát nữ Chanel',
        //         'status' => 'active',
        //         'id_parent' => 4,
        //     ],
        //     [
        //         'category_name' => 'Kính mát nam Chanel',
        //         'status' => 'active',
        //         'id_parent' => 4,
        //     ],
        //     [
        //         'category_name' => 'Kính mát unisex Chanel',
        //         'status' => 'active',
        //         'id_parent' => 4,
        //     ],
        //     // Trang Sức
        //     [
        //         'category_name' => 'Vòng cổ Chanel',
        //         'status' => 'inactive',
        //         'id_parent' => 5,
        //     ],
        //     [
        //         'category_name' => 'Nhẫn Chanel',
        //         'status' => 'inactive',
        //         'id_parent' => 5,
        //     ],
        //     // Trang Điểm
        //     [
        //         'category_name' => 'Son môi Chanel',
        //         'status' => 'inactive',
        //         'id_parent' => 6,
        //     ],
        //     [
        //         'category_name' => 'Phấn nền Chanel',
        //         'status' => 'inactive',
        //         'id_parent' => 6,
        //     ],
        // ]);


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
                [
                    'username' => 'Minh Hiệp',
                    'password' => bcrypt('123'),
                    'email' => 'minhhiep@gmail.com',
                    'phone' => 123456789,
                    'address' => '123 Admin Street',
                    'role' => 1,
                ],
            ]
        );

        \App\Models\Product::insert([
            [
                "id_category" => 14, // Đồng hồ nam Chanel
                "name" => "Chanel J12 Bleu Watch 38mm",
                "image" => "images/wristwatch/9568364527646.jpg",
                "price" => 1000000,
                "gender" => "Unisex",
                "quantity" => 30,
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Bleu 38mm, thiết kế mạnh mẽ, phù hợp cho cả nam và nữ, chất liệu ceramic cao cấp.",
                "note" => "Chống nước 100m, kính sapphire, dây ceramic",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel J12 Bleu Watch 33mm",
                "image" => "images/wristwatch/9568365805598.jpg",
                "price" => 2000000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Đồng hồ Chanel J12 Bleu 33mm, thiết kế thanh lịch, phù hợp cho nữ giới, ceramic xanh mờ.",
                "note" => "Chống nước 50m, kính sapphire",
                "status" => "active"
            ],
            [
                "id_category" => 15, // Đồng hồ unisex Chanel
                "name" => "Chanel J12 Bleu Watch Caliber 12.1 38mm",
                "image" => "images/wristwatch/j12-bleu-watch-caliber-12-1-38-mm-blue-steel-sapphire-matte-blue-ceramic-packshot-dos-h10310-9568362463262.jpg",
                "price" => 10000000,

                "quantity" => 30,
                "gender" => "Nam",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Bleu 38mm, bộ máy Caliber 12.1, thiết kế thể thao, ceramic xanh mờ.",
                "note" => "Chống nước 100m, kính sapphire",
                "status" => "active"
            ],
            [
                "id_category" => 14, // Đồng hồ nam Chanel
                "name" => "Chanel J12 Bleu Watch Caliber 12.1 38mm",
                "image" => "images/wristwatch/j12-bleu-watch-caliber-12-1-38-mm-blue-steel-sapphire-matte-blue-ceramic-packshot-default-h10310-9568363118622.jpg",
                "price" => 2000000,

                "quantity" => 30,
                "gender" => "Nam",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Bleu 38mm, bộ máy Caliber 12.1, thiết kế mạnh mẽ, ceramic xanh mờ.",
                "note" => "Chống nước 100m, kính sapphire",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel J12 Bleu Watch Caliber 12.2 33mm Diamond",
                "image" => "images/wristwatch/j12-bleu-watch-caliber-12-2-33-mm-blue-steel-diamond-matte-blue-ceramic-packshot-default-h9657-9570157920286.jpg",
                "price" => 5000000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Bleu 33mm, đính kim cương, bộ máy Caliber 12.2, ceramic xanh mờ.",
                "note" => "Chống nước 50m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel J12 Bleu Watch Caliber 12.2 33mm Diamond",
                "image" => "images/wristwatch/j12-bleu-watch-caliber-12-2-33-mm-blue-steel-diamond-matte-blue-ceramic-packshot-dos-h9657-9568362168350.jpg",
                "price" => 4500000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Bleu 33mm, đính kim cương, thiết kế sang trọng, ceramic xanh mờ.",
                "note" => "Chống nước 50m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco Watch Black Ceramic",
                "image" => "images/wristwatch/code-coco-watch-black-black-ceramic-steel-diamond-packshot-default-h5148-9564284059678.jpg",
                "price" => 2600000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco, ceramic đen, đính kim cương, thiết kế độc đáo, hiện đại.",
                "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco Watch Black Ceramic",
                "image" => "images/wristwatch/code-coco-watch-black-black-ceramic-steel-diamond-packshot-other-h5148-8828925378590.jpg",
                "price" => 700000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco, ceramic đen, đính kim cương, phong cách thời thượng.",
                "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco Leather Watch Silver",
                "image" => "images/wristwatch/code-coco-leather-watch-silver-black-steel-diamond-calfskin-packshot-default-h6208-9564290285598.jpg",
                "price" => 1600000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco, dây da bê, mặt bạc, đính kim cương, thiết kế thanh lịch.",
                "note" => "Chống nước 30m, kính sapphire, dây da bê",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco So Black Watch",
                "image" => "images/wristwatch/code-coco-so-black-watch-black-matte-black-ceramic-steel-diamond-packshot-default-h6426-9564229500958.jpg",
                "price" => 4000000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco So Black, ceramic đen mờ, đính kim cương, cá tính và hiện đại.",
                "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco Watch Black Steel",
                "image" => "images/wristwatch/code-coco-watch-black-steel-black-ceramic-diamond-packshot-default-h6027-8825232359454.jpg",
                "price" => 5600000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco, thép không gỉ, ceramic đen, đính kim cương, thiết kế sang trọng.",
                "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Boy·Friend Skeleton Watch Beige Gold",
                "image" => "images/wristwatch/boy-friend-skeleton-watch-beige-beige-gold-diamond-calfskin-packshot-default-h6949-9570157723678.jpg",
                "price" => 3100000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Manual",
                "description" => "Chanel Boy·Friend Skeleton, vàng beige, dây da bê, thiết kế lộ máy, đính kim cương.",
                "note" => "Chống nước 30m, kính sapphire, dây da bê",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Boy·Friend Watch Silver White Gold",
                "image" => "images/wristwatch/boy-friend-watch-silver-white-gold-diamond-calfskin-packshot-default-h6674-9564215738398.jpg",
                "price" => 4500000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Boy·Friend, vàng trắng, dây da bê, đính kim cương, thiết kế thanh lịch.",
                "note" => "Chống nước 30m, kính sapphire, dây da bê",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel Code Coco Watch Beige Gold",
                "image" => "images/wristwatch/code-coco-watch-beige-beige-gold-diamond-packshot-default-h5146-8825229705246.jpg",
                "price" => 6500000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Quartz",
                "description" => "Chanel Code Coco, vàng beige, đính kim cương, thiết kế sang trọng, nữ tính.",
                "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel J12 Baguette Diamond Bezel Watch Caliber 12.2 33mm",
                "image" => "images/wristwatch/j12-baguette-diamond-bezel-watch-caliber-12-2-33-mm-white-white-ceramic-white-gold-diamond-packshot-default-h7430-9563849031710.jpg",
                "price" => 6000000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Baguette Diamond Bezel, 33mm, ceramic trắng, vàng trắng, đính kim cương baguette.",
                "note" => "Chống nước 50m, kính sapphire, kim cương baguette",
                "status" => "active"
            ],
            [
                "id_category" => 13, // Đồng hồ nữ Chanel
                "name" => "Chanel J12 Baguette Diamond Bezel Watch Caliber 12.2 33mm",
                "image" => "images/wristwatch/j12-baguette-diamond-bezel-watch-caliber-12-2-33-mm-white-white-ceramic-white-gold-diamond-packshot-dos-h7430-9563848081438.jpg",
                "price" => 3000000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Automatic",
                "description" => "Chanel J12 Baguette Diamond Bezel, 33mm, ceramic trắng, vàng trắng, đính kim cương baguette.",
                "note" => "Chống nước 50m, kính sapphire, kim cương baguette",
                "status" => "active"
            ]
        ]);



        \App\Models\Voucher::insert([
            [
                'code' => 'CHANEL100000',
                'discount_amount' => 100000,
                'max_discount_amount' => 1000000,
                'min_order_amount' => 5000000,
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'usage_limit' => 100,
                'description' => 'Giảm 1.000.000đ cho đơn hàng từ 5.000.000đ trở lên',
                'note' => 'Áp dụng cho tất cả sản phẩm Chanel',
                'status' => 'active',
                'type' => 'fixed',
            ],
            [
                'code' => 'CHANEL20',
                'discount_amount' => 10,
                'max_discount_amount' => null,
                'min_order_amount' => 1000000,
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'usage_limit' => 50,
                'description' => 'Giảm 10% cho đơn hàng từ 1.000.000đ trở lên',
                'note' => 'Áp dụng cho tất cả sản phẩm Chanel',
                'status' => 'active',
                'type' => 'percentage',
            ],
        ]);

        \App\Models\Product::insert([
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Nước hoa Chanel No.5",
                "image" => "images/perfume/perfume1.jpg",
                "price" => 2450000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Parfum",
                "description" => "Hương thơm cổ điển, sang trọng, quyến rũ với nét đẹp vượt thời gian.",
                "note" => "Hoa nhài, hoa hồng, gỗ đàn hương",
                "status" => "active",
            ],
            [
                "id_category" => 11, // Nước hoa nam Chanel
                "name" => "Dior Sauvage Eau de Parfum",
                "image" => "images/perfume/perfume2.jpg",
                "price" => 3150000,
                "quantity" => 30,
                "gender" => "Nam",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Hương thơm mạnh mẽ, tự do và đầy cuốn hút dành cho phái mạnh.",
                "note" => "Tiêu, cam bergamot, ambroxan",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Gucci Bloom",
                "image" => "images/perfume/perfume3.jpg",
                "price" => 2800000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Hương hoa trắng tinh tế, tươi mới và nữ tính.",
                "note" => "Hoa nhài, hoa huệ, rễ cây diên vĩ",
                "status" => "active",
            ],
            [
                "id_category" => 11, // Nước hoa nam Chanel
                "name" => "Versace Eros",
                "image" => "images/perfume/perfume4.jpg",
                "price" => 2900000,
                "quantity" => 30,
                "gender" => "Nam",
                "volume" => 100,
                "type" => "Eau de Toilette",
                "description" => "Mang đến cảm giác tươi mát, mạnh mẽ và quyến rũ.",
                "note" => "Bạc hà, táo xanh, đậu Tonka",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "YSL Libre",
                "image" => "images/perfume/perfume5.jpg",
                "price" => 3200000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 90,
                "type" => "Eau de Parfum",
                "description" => "Tự do và táo bạo với sự pha trộn giữa hương hoa và hương gỗ.",
                "note" => "Oải hương, hoa cam, xạ hương",
                "status" => "active",
            ],
            [
                "id_category" => 12, // Nước hoa unisex Chanel
                "name" => "CK One",
                "image" => "images/perfume/perfume6.jpg",
                "price" => 1950000,


                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => 100,
                "type" => "Eau de Toilette",
                "description" => "Hương thơm tươi mát, năng động và phù hợp cho mọi giới.",
                "note" => "Cam bergamot, trà xanh, xạ hương",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Burberry Her",
                "image" => "images/perfume/perfume7.jpg",
                "price" => 2600000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Hương trái cây ngọt ngào, trẻ trung và hiện đại.",
                "note" => "Dâu tây, quả mâm xôi, gỗ hổ phách",
                "status" => "active",
            ],
            [
                "id_category" => 12, // Nước hoa unisex Chanel
                "name" => "Tom Ford Black Orchid",
                "image" => "images/perfume/perfume8.jpg",
                "price" => 4300000,
                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => 100,
                "type" => "Parfum",
                "description" => "Hương thơm đậm đà, quyến rũ và độc đáo.",
                "note" => "Nấm đen, hoa lan, chocolate đắng",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Marc Jacobs Daisy",
                "image" => "images/perfume/perfume9.jpg",
                "price" => 2750000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Toilette",
                "description" => "Tươi mát, dễ thương và trẻ trung như cánh đồng hoa.",
                "note" => "Hoa cúc, quả mâm xôi, xạ hương nhẹ",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Lancome La Vie Est Belle",
                "image" => "images/perfume/perfume10.jpg",
                "price" => 3000000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 75,
                "type" => "Eau de Parfum",
                "description" => "Hương thơm ngọt ngào và lạc quan cho cuộc sống tươi đẹp.",
                "note" => "Hoa diên vĩ, hoắc hương, vanilla",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Jo Malone Peony & Blush Suede",
                "image" => "images/perfume/perfume11.jpg",
                "price" => 4000000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Cologne",
                "description" => "Tinh tế, nhẹ nhàng và thanh lịch với hoa mẫu đơn.",
                "note" => "Táo đỏ, hoa mẫu đơn, da lộn",
                "status" => "active",
            ],
            [
                "id_category" => 11, // Nước hoa nam Chanel
                "name" => "Bvlgari Man in Black",
                "image" => "images/perfume/perfume12.jpg",
                "price" => 3150000,


                "quantity" => 30,
                "gender" => "Nam",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Nam tính, mạnh mẽ và huyền bí với hương cay nồng.",
                "note" => "Rượu rum, hổ phách, da thuộc",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Dolce & Gabbana Light Blue",
                "image" => "images/perfume/perfume13.jpg",
                "price" => 2400000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Toilette",
                "description" => "Tươi mát như biển cả mùa hè với hương cam chanh.",
                "note" => "Táo xanh, chanh Sicilia, tuyết tùng",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Givenchy L’Interdit",
                "image" => "images/perfume/perfume14.jpg",
                "price" => 3100000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 80,
                "type" => "Eau de Parfum",
                "description" => "Bí ẩn và quyến rũ, phá vỡ mọi giới hạn.",
                "note" => "Hoa cam, cỏ vetiver, hoắc hương",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Armani My Way",
                "image" => "images/perfume/perfume15.jpg",
                "price" => 3500000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 90,
                "type" => "Eau de Parfum",
                "description" => "Tinh tế và khám phá bản thân qua hương hoa nữ tính.",
                "note" => "Cam bergamot, hoa nhài, vani",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Kenzo Flower",
                "image" => "images/perfume/perfume16.jpg",
                "price" => 2200000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Hương phấn dịu nhẹ gợi nhớ ký ức tuổi thơ.",
                "note" => "Hoa violet, hoa hồng Bulgaria, vanilla",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Narciso Rodriguez for Her",
                "image" => "images/perfume/perfume17.jpg",
                "price" => 3800000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Toilette",
                "description" => "Sang trọng, gợi cảm với hương xạ đặc trưng.",
                "note" => "Xạ hương, hoa cam châu Phi, gỗ đàn hương",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Hermès Twilly",
                "image" => "images/perfume/perfume18.jpg",
                "price" => 3350000,
                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 85,
                "type" => "Eau de Parfum",
                "description" => "Cá tính, trẻ trung và phá cách.",
                "note" => "Gừng, hoa cam, gỗ đàn hương",
                "status" => "active",
            ],
            [
                "id_category" => 11, // Nước hoa nam Chanel
                "name" => "Montblanc Explorer",
                "image" => "images/perfume/perfume19.jpg",
                "price" => 2900000,


                "quantity" => 30,
                "gender" => "Nam",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Tinh thần khám phá và phiêu lưu với hương gỗ nam tính.",
                "note" => "Cam bergamot, hoắc hương, gỗ đàn hương",
                "status" => "active",
            ],
            [
                "id_category" => 10, // Nước hoa nữ Chanel
                "name" => "Viktor & Rolf Flowerbomb",
                "image" => "images/perfume/perfume20.jpg",
                "price" => 4100000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => 100,
                "type" => "Eau de Parfum",
                "description" => "Bùng nổ hương hoa đầy mê hoặc và quyến rũ.",
                "note" => "Hoa nhài, hoa cam, hoắc hương",
                "status" => "active",
            ]
        ]);


        \App\Models\Product::insert([
            [
                "id_category" => 19,
                "name" => "Vòng tay Coco Crush Beige Gold",
                "image" => "images/jewelry/coco-crush-bracelet-beige-beige-gold-packshot-default-j12324-9571629629470.jpg",
                "price" => 2780000,

                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Beige Gold",
                "description" => "Vòng tay Coco Crush bằng vàng beige, thiết kế sang trọng, phù hợp mọi dịp.",
                "note" => "Chất liệu vàng beige cao cấp, phong cách hiện đại.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Coco Beige Gold",
                "image" => "images/jewelry/coco-bracelet-beige-beige-gold-packshot-default-j12303-9563791097886.jpg",
                "price" => 2390000,

                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Beige Gold",
                "description" => "Vòng tay Coco bằng vàng beige, thiết kế thanh lịch, dễ phối đồ.",
                "note" => "Chất liệu vàng beige, phù hợp cả nam và nữ.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Coco Đỏ Ruby Beige Gold",
                "image" => "images/jewelry/coco-bracelet-red-beige-beige-gold-ruby-packshot-default-j13044-9572044308510.jpg",
                "price" => 2440000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Ruby",
                "description" => "Vòng tay Coco phối vàng beige và đá ruby đỏ, nổi bật và quyến rũ.",
                "note" => "Đính đá ruby, chất liệu vàng beige.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Eternal N°5 Beige Gold Diamond",
                "image" => "images/jewelry/eternal-n-5-bracelet-beige-beige-gold-diamond-packshot-default-j12812-9568831668254.jpg",
                "price" => 1520000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Diamond",
                "description" => "Vòng tay Eternal N°5 bằng vàng beige đính kim cương, biểu tượng vĩnh cửu.",
                "note" => "Kim cương thiên nhiên, vàng beige.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Extrait de N°5 Beige Gold Diamond",
                "image" => "images/jewelry/extrait-de-n-5-bracelet-beige-beige-gold-diamond-packshot-default-j12428-9563792801822.jpg",
                "price" => 1220000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Diamond",
                "description" => "Vòng tay Extrait de N°5 vàng beige đính kim cương, thiết kế tinh tế.",
                "note" => "Chất liệu vàng beige, kim cương thiên nhiên.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Bouton de Camélia White Gold Diamond",
                "image" => "images/jewelry/bouton-de-camelia-supple-bracelet-white-white-gold-diamond-packshot-default-j12065-9575525351454.jpg",
                "price" => 1170000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "White Gold, Diamond",
                "description" => "Vòng tay Bouton de Camélia bằng vàng trắng đính kim cương, hoa trà biểu tượng.",
                "note" => "Thiết kế hoa trà, vàng trắng, kim cương.",
                "status" => "active"
            ],
            [
                "id_category" => 19,
                "name" => "Vòng tay Coco Crush White Gold Diamond",
                "image" => "images/jewelry/coco-crush-bracelet-white-diamond-white-gold-packshot-default-j11162-9564997025822.jpg",
                "price" => 2890000,

                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "White Gold, Diamond",
                "description" => "Vòng tay Coco Crush vàng trắng đính kim cương, phong cách cá tính.",
                "note" => "Chất liệu vàng trắng, kim cương thiên nhiên.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Coco Crush Beige Gold",
                "image" => "images/jewelry/coco-crush-ring-beige-beige-gold-packshot-default-j11785-8829173137438.jpg",
                "price" => 1080000,

                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Beige Gold",
                "description" => "Nhẫn Coco Crush vàng beige, thiết kế đơn giản, tinh tế.",
                "note" => "Chất liệu vàng beige, phù hợp mọi phong cách.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Coco Crush Beige Gold Diamond",
                "image" => "images/jewelry/coco-crush-ring-beige-beige-gold-diamond-packshot-default-j13162-9574508462110.jpg",
                "price" => 1500000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Diamond",
                "description" => "Nhẫn Coco Crush vàng beige đính kim cương, sang trọng và nổi bật.",
                "note" => "Kim cương thiên nhiên, vàng beige.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Coco Crush Beige Gold Diamond",
                "image" => "images/jewelry/coco-crush-ring-beige-beige-gold-diamond-packshot-default-j11786-8829173170206.jpg",
                "price" => 1810000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Diamond",
                "description" => "Nhẫn Coco Crush vàng beige đính kim cương, thiết kế tinh xảo.",
                "note" => "Chất liệu vàng beige, kim cương.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Extrait de N°5 Beige Gold Diamond",
                "image" => "images/jewelry/extrait-de-n-5-ring-beige-beige-gold-diamond-packshot-default-j12400-9572539891742.jpg",
                "price" => 1680000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, Diamond",
                "description" => "Nhẫn Extrait de N°5 vàng beige đính kim cương, biểu tượng Chanel.",
                "note" => "Kim cương thiên nhiên, vàng beige.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Eternal N°5 White Gold Diamond",
                "image" => "images/jewelry/eternal-n-5-ring-white-white-gold-diamond-packshot-default-j12002-9575042646046.jpg",
                "price" => 1530000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "White Gold, Diamond",
                "description" => "Nhẫn Eternal N°5 vàng trắng đính kim cương, thiết kế thanh lịch.",
                "note" => "Chất liệu vàng trắng, kim cương.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Coco Crush Toi et Moi Beige Gold White Gold Diamond",
                "image" => "images/jewelry/coco-crush-toi-et-moi-ring-beige-white-beige-gold-white-gold-diamond-packshot-default-j11971-9564216000542.jpg",
                "price" => 1430000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Beige Gold, White Gold, Diamond",
                "description" => "Nhẫn Coco Crush Toi et Moi phối vàng beige, vàng trắng và kim cương, biểu tượng tình yêu.",
                "note" => "Thiết kế đôi, vàng beige, vàng trắng, kim cương.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Coco Crush White Gold Diamond",
                "image" => "images/jewelry/coco-crush-ring-white-white-gold-diamond-packshot-default-j11871-8830938480670.jpg",
                "price" => 2370000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "White Gold, Diamond",
                "description" => "Nhẫn Coco Crush vàng trắng đính kim cương, phong cách sang trọng.",
                "note" => "Chất liệu vàng trắng, kim cương thiên nhiên.",
                "status" => "active"
            ],
            [
                "id_category" => 20,
                "name" => "Nhẫn Fil de Camélia Diamond White Gold",
                "image" => "images/jewelry/fil-de-camelia-ring-diamond-white-gold-packshot-default-j2579-9564997910558.jpg",
                "price" => 2500000,

                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "White Gold, Diamond",
                "description" => "Nhẫn Fil de Camélia vàng trắng đính kim cương, thiết kế hoa trà tinh tế.",
                "note" => "Hoa trà, vàng trắng, kim cương.",
                "status" => "active"
            ]
        ]);

        \App\Models\Product::insert([
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Rectangle Sunglasses Black Acetate & Calfskin",
                "image" => "images/classes/rectangle-sunglasses-black-acetate-calfskin-acetate-calfskin-packshot-default-a71716x02153s2228-9567932022814.jpg",
                "price" => 700000,


                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Acetate, Calfskin",
                "description" => "Kính mát Chanel dáng chữ nhật, chất liệu acetate đen phối da bê, thiết kế hiện đại, sang trọng.",
                "note" => "Chống tia UV, phù hợp nhiều khuôn mặt",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Rectangle Sunglasses Black & Gold Acetate",
                "image" => "images/classes/rectangle-sunglasses-black-gold-acetate-acetate-packshot-default-a71377x08101s2216-8853782790174.jpg",
                "price" => 1200000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate",
                "description" => "Kính mát Chanel dáng chữ nhật, phối màu đen và vàng, chất liệu acetate cao cấp.",
                "note" => "Gọng nhẹ, chống chói tốt",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Cat Eye Sunglasses White Acetate & Glass Pearls",
                "image" => "images/classes/cat-eye-sunglasses-white-acetate-glass-pearls-acetate-glass-pearls-packshot-default-a71491x08222s5512-9516163104798.jpg",
                "price" => 1600000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Glass Pearls",
                "description" => "Kính mát Chanel mắt mèo, màu trắng, điểm xuyết ngọc trai thủy tinh sang trọng.",
                "note" => "Phong cách nữ tính, thời trang",
                "status" => "active"
            ],
            [
                "id_category" => 18, // Kính mát unisex Chanel
                "name" => "Square Sunglasses Black Acetate",
                "image" => "images/classes/square-sunglasses-black-acetate-acetate-packshot-extra-a71305x08101s2214-8853776203806.jpg",
                "price" => 2100000,


                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Acetate",
                "description" => "Kính mát Chanel dáng vuông, chất liệu acetate đen, phù hợp cả nam và nữ.",
                "note" => "Thiết kế cổ điển, dễ phối đồ",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Cat Eye Sunglasses Black Acetate & Metal",
                "image" => "images/classes/cat-eye-sunglasses-black-acetate-metal-acetate-metal-packshot-default-a71710x06081s2216-9558779789342.jpg",
                "price" => 2900000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Metal",
                "description" => "Kính mát Chanel mắt mèo, gọng đen phối kim loại, phong cách cá tính.",
                "note" => "Chống tia UV, phù hợp mặt trái xoan",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Butterfly Sunglasses Black Acetate & Metal",
                "image" => "images/classes/butterfly-sunglasses-black-acetate-metal-acetate-metal-packshot-other-a71711x06081s2216-9558780280862.jpg",
                "price" => 1400000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Metal",
                "description" => "Kính mát Chanel dáng bướm, gọng đen phối kim loại, tạo điểm nhấn nổi bật.",
                "note" => "Phong cách sang trọng, nữ tính",
                "status" => "active"
            ],
            [
                "id_category" => 18, // Kính mát unisex Chanel
                "name" => "Round Sunglasses Gold & Black Metal Calfskin",
                "image" => "images/classes/round-sunglasses-gold-black-metal-calfskin-metal-calfskin-packshot-extra-a71384x27388l3953-8853784100894.jpg",
                "price" => 990000,


                "quantity" => 30,
                "gender" => "Unisex",
                "volume" => null,
                "type" => "Metal, Calfskin",
                "description" => "Kính mát Chanel tròn, phối màu vàng đen, gọng kim loại bọc da bê cao cấp.",
                "note" => "Phong cách retro, phù hợp nhiều khuôn mặt",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Oval Sunglasses Black Nylon & Metal Leather",
                "image" => "images/classes/oval-sunglasses-black-nylon-metal-leather-nylon-metal-leather-packshot-default-a71713x06023s0116-9558780117022.jpg",
                "price" => 1100000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Nylon, Metal, Leather",
                "description" => "Kính mát Chanel oval, gọng nylon đen phối kim loại và da, thiết kế thanh lịch.",
                "note" => "Chống tia UV, nhẹ và bền",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Square Sunglasses Coral Nylon",
                "image" => "images/classes/square-sunglasses-coral-nylon-nylon-packshot-default-a71692x02081s0714-9558780411934.jpg",
                "price" => 1500000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Nylon",
                "description" => "Kính mát Chanel vuông, màu cam san hô, chất liệu nylon trẻ trung.",
                "note" => "Phong cách năng động, phù hợp mùa hè",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Cat Eye Sunglasses Black Acetate & Strass",
                "image" => "images/classes/cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-extra-a71667x02569s2216-9550223802398.jpg",
                "price" => 1990000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Strass",
                "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass lấp lánh.",
                "note" => "Tạo điểm nhấn nổi bật, thời trang",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Cat Eye Sunglasses Black Acetate & Strass",
                "image" => "images/classes/cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-default-a71668x02569s2216-9550229897246.jpg",
                "price" => 1490000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Strass",
                "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass, phong cách sang trọng.",
                "note" => "Chống tia UV, phù hợp dự tiệc",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Cat Eye Sunglasses Black Acetate & Strass",
                "image" => "images/classes/cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-default-a71669x02569s2287-9550231666718.jpg",
                "price" => 1690000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Strass",
                "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass, thiết kế tinh tế.",
                "note" => "Phong cách quý phái, bảo vệ mắt tối ưu",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Rectangle Sunglasses Red Acetate",
                "image" => "images/classes/rectangle-sunglasses-red-acetate-acetate-packshot-other-a71649x08101s7911-9546504831006.jpg",
                "price" => 1090000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate",
                "description" => "Kính mát Chanel dáng chữ nhật, màu đỏ nổi bật, chất liệu acetate.",
                "note" => "Phong cách trẻ trung, cá tính",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Square Sunglasses Gold Metal Calfskin Denim",
                "image" => "images/classes/square-sunglasses-gold-metal-calfskin-denim-metal-calfskin-denim-packshot-default-a71693x02609l8819-9563891793950.jpg",
                "price" => 1450000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Metal, Calfskin, Denim",
                "description" => "Kính mát Chanel vuông, phối vàng, da bê và denim, thiết kế độc đáo.",
                "note" => "Chống tia UV, phong cách cá tính",
                "status" => "active"
            ],
            [
                "id_category" => 16, // Kính mát nữ Chanel
                "name" => "Square Sunglasses Off White Acetate Tweed Leather",
                "image" => "images/classes/square-sunglasses-off-white-acetate-tweed-leather-acetate-tweed-leather-packshot-default-a71652x22002s8761-9546504667166.jpg",
                "price" => 1290000,


                "quantity" => 30,
                "gender" => "Nữ",
                "volume" => null,
                "type" => "Acetate, Tweed, Leather",
                "description" => "Kính mát Chanel vuông, màu trắng ngà, phối tweed và da, phong cách thanh lịch.",
                "note" => "Thiết kế sang trọng, phù hợp nhiều dịp",
                "status" => "active"
            ]
        ]);


        \App\Models\Order::insert([
            [
                "id_user" => 1,
                "total_amount" => 45645674,
                "customer_name" => "Thiện Trương",
                "phone" => "123456789",
                "address" => "123 Admin Street",
                "payment_method" => "COD",
                "notes" => "Giao hàng trong giờ hành chính",
                "status" => "cart",
                "order_date" => '2024-07-06 00:00:00',
            ],
            [
                "id_user" => 1,
                "total_amount" => 54535353,
                "customer_name" => "Thiện Trương",
                "phone" => "123456789",
                "address" => "123 Admin Street",
                "payment_method" => "Bank Transfer",
                "notes" => "Giao hàng trong giờ hành chính",
                "status" => "preparing",
                "order_date" => '2024-05-03 00:00:00',
            ],
            [
                "id_user" => 1,
                "total_amount" => 4900000,
                "customer_name" => "Thiện Trương",
                "phone" => "123456789",
                "address" => "123 Admin Street",
                "payment_method" => "COD",
                "notes" => "Giao hàng trong giờ hành chính",
                "status" => "delivered",
                "order_date" => '2023-10-22 00:00:00',
            ],
            [
                "id_user" => 1,
                "total_amount" => 4900000,
                "customer_name" => "Thiện Trương",
                "phone" => "123456789",
                "address" => "123 Admin Street",
                "payment_method" => "COD",
                "notes" => "Giao hàng trong giờ hành chính",
                "status" => "shipping",
                "order_date" => '2025-02-22 00:00:00',
            ],
            [
                "id_user" => 2,
                "total_amount" => 7500000,
                "customer_name" => "Tuấn Hiệp",
                "phone" => "123456789",
                "address" => "123 Admin Street",
                "payment_method" => "Bank Transfer",
                "notes" => null,
                "status" => "shipping",
                "order_date" => '2024-06-13 00:00:00',
            ]
        ]);

        \App\Models\OrderDetail::insert([
            [
                "id_order" => 1,
                "id_product" => 1,
                "discount" => 0,
                "quantity" => 2,
            ],
            [
                "id_order" => 2,
                "id_product" => 2,
                "discount" => 100000,
                "quantity" => 1,
            ],
            [
                "id_order" => 3,
                "id_product" => 3,
                "discount" => 0,
                "quantity" => 1,
            ],
            [
                "id_order" => 4,
                "id_product" => 4,
                "discount" => 50000,
                "quantity" => 2,
            ],
            [
                "id_order" => 2,
                "id_product" => 5,
                "discount" => 0,
                "quantity" => 1,
            ],
            [
                "id_order" => 5,
                "id_product" => 6,
                "discount" => 20000,
                "quantity" => 1,
            ],
        ]);


        \App\Models\Review::insert([
            [
                'id_user' => 1,
                'id_product' => 1,
                'rating' => 5,
                'content' => 'Sản phẩm tuyệt vời, chất lượng tốt và giao hàng nhanh chóng.',
                'created_date' => now(),
            ],
            [
                'id_user' => 1,
                'id_product' => 15,
                'rating' => 4,
                'content' => 'Rất hài lòng với sản phẩm, sẽ mua lại.',
                'created_date' => now(),
            ],
            [
                'id_user' => 3,
                'id_product' => 1,
                'rating' => 3,
                'content' => 'Sản phẩm bình thường, không có gì đặc biệt.',
                'created_date' => now(),
            ],
            [
                'id_user' => 2,
                'id_product' => 1,
                'rating' => 5,
                'content' => 'Chất lượng sản phẩm rất tốt, tôi rất thích.',
                'created_date' => now(),
            ],
            [
                'id_user' => 1,
                'id_product' => 2,
                'rating' => 4,
                'content' => 'Sản phẩm đẹp, nhưng giá hơi cao.',
                'created_date' => now(),
            ],
            [
                'id_user' => 2,
                'id_product' => 2,
                'rating' => 5,
                'content' => 'Rất hài lòng với chất lượng và dịch vụ.',
                'created_date' => now(),
            ],
            // Thêm 10 đánh giá mới
            [
                'id_user' => 2,
                'id_product' => 39, // Trang sức
                'rating' => 5,
                'content' => 'Vòng tay thiết kế tinh xảo, rất sang trọng.',
                'created_date' => now(),
            ],
            [
                'id_user' => 3,
                'id_product' => 44, // Trang sức
                'rating' => 4,
                'content' => 'Nhẫn đẹp, vừa tay, giao hàng nhanh.',
                'created_date' => now(),
            ],
            [
                'id_user' => 1,
                'id_product' => 44, // Trang sức
                'rating' => 5,
                'content' => 'Nhẫn kim cương sáng, rất nổi bật khi đeo.',
                'created_date' => now(),
            ],
            [
                'id_user' => 2,
                'id_product' => 58, // Mắt kính
                'rating' => 4,
                'content' => 'Kính mát nhẹ, đeo lâu không bị đau tai.',
                'created_date' => now(),
            ],
            [
                'id_user' => 3,
                'id_product' => 56, // Mắt kính
                'rating' => 5,
                'content' => 'Thiết kế kính rất thời trang, phù hợp với nhiều kiểu mặt.',
                'created_date' => now(),
            ],
            [
                'id_user' => 1,
                'id_product' => 56, // Mắt kính
                'rating' => 3,
                'content' => 'Kính đẹp nhưng hộp đựng hơi đơn giản.',
                'created_date' => now(),
            ],
            [
                'id_user' => 2,
                'id_product' => 30, // Nước hoa
                'rating' => 5,
                'content' => 'Hương thơm nước hoa giữ lâu, rất quyến rũ.',
                'created_date' => now(),
            ],
            [
                'id_user' => 3,
                'id_product' => 30, // Nước hoa
                'rating' => 4,
                'content' => 'Mùi nước hoa nhẹ nhàng, phù hợp đi làm.',
                'created_date' => now(),
            ],
            [
                'id_user' => 1,
                'id_product' => 28, // Nước hoa
                'rating' => 5,
                'content' => 'Nước hoa unisex, cả nhà đều dùng được.',
                'created_date' => now(),
            ],
            [
                'id_user' => 2,
                'id_product' => 31, // Nước hoa
                'rating' => 4,
                'content' => 'Giá hợp lý, mùi thơm dễ chịu.',
                'created_date' => now(),
            ],
        ]);

        //Đồng hồ Chanel
        // \App\Models\Product::insert([
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch Caliber 12.2 33mm",
        //         "image" => "j12-bleu-watch-caliber-12-2-33-mm-blue-steel-sapphire-matte-blue-ceramic-packshot-default-h10309-9568362102814",
        //         "price" => 370322267,
        //         "rating" => 4,
        //         "gender" => "Unisex",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Đồng hồ Chanel J12 Bleu 33mm, chất liệu ceramic xanh mờ, bộ máy Caliber 12.2, thiết kế sang trọng và hiện đại.",
        //         "note" => "Chống nước 50m, kính sapphire, dây ceramic",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch 38mm",
        //         "image" => "9568364527646",
        //         "price" => 211620643,
        //         "rating" => 5,
        //         "gender" => "Unisex",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Bleu 38mm, thiết kế mạnh mẽ, phù hợp cho cả nam và nữ, chất liệu ceramic cao cấp.",
        //         "note" => "Chống nước 100m, kính sapphire, dây ceramic",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch 33mm",
        //         "image" => "9568365805598",
        //         "price" => 300988017,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Đồng hồ Chanel J12 Bleu 33mm, thiết kế thanh lịch, phù hợp cho nữ giới, ceramic xanh mờ.",
        //         "note" => "Chống nước 50m, kính sapphire",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch Caliber 12.1 38mm",
        //         "image" => "j12-bleu-watch-caliber-12-1-38-mm-blue-steel-sapphire-matte-blue-ceramic-packshot-dos-h10310-9568362463262",
        //         "price" => 339544137,
        //         "rating" => 3,
        //         "gender" => "Nam",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Bleu 38mm, bộ máy Caliber 12.1, thiết kế thể thao, ceramic xanh mờ.",
        //         "note" => "Chống nước 100m, kính sapphire",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch Caliber 12.1 38mm",
        //         "image" => "j12-bleu-watch-caliber-12-1-38-mm-blue-steel-sapphire-matte-blue-ceramic-packshot-default-h10310-9568363118622",
        //         "price" => 300823454,
        //         "rating" => 5,
        //         "gender" => "Nam",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Bleu 38mm, bộ máy Caliber 12.1, thiết kế mạnh mẽ, ceramic xanh mờ.",
        //         "note" => "Chống nước 100m, kính sapphire",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch Caliber 12.2 33mm Diamond",
        //         "image" => "j12-bleu-watch-caliber-12-2-33-mm-blue-steel-diamond-matte-blue-ceramic-packshot-default-h9657-9570157920286",
        //         "price" => 463842891,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Bleu 33mm, đính kim cương, bộ máy Caliber 12.2, ceramic xanh mờ.",
        //         "note" => "Chống nước 50m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Bleu Watch Caliber 12.2 33mm Diamond",
        //         "image" => "j12-bleu-watch-caliber-12-2-33-mm-blue-steel-diamond-matte-blue-ceramic-packshot-dos-h9657-9568362168350",
        //         "price" => 326820872,
        //         "rating" => 5,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Bleu 33mm, đính kim cương, thiết kế sang trọng, ceramic xanh mờ.",
        //         "note" => "Chống nước 50m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco Watch Black Ceramic",
        //         "image" => "code-coco-watch-black-black-ceramic-steel-diamond-packshot-default-h5148-9564284059678",
        //         "price" => 394221985,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco, ceramic đen, đính kim cương, thiết kế độc đáo, hiện đại.",
        //         "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco Watch Black Ceramic",
        //         "image" => "code-coco-watch-black-black-ceramic-steel-diamond-packshot-other-h5148-8828925378590",
        //         "price" => 350239578,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco, ceramic đen, đính kim cương, phong cách thời thượng.",
        //         "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco Leather Watch Silver",
        //         "image" => "code-coco-leather-watch-silver-black-steel-diamond-calfskin-packshot-default-h6208-9564290285598",
        //         "price" => 483122978,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco, dây da bê, mặt bạc, đính kim cương, thiết kế thanh lịch.",
        //         "note" => "Chống nước 30m, kính sapphire, dây da bê",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco So Black Watch",
        //         "image" => "code-coco-so-black-watch-black-matte-black-ceramic-steel-diamond-packshot-default-h6426-9564229500958",
        //         "price" => 163317225,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco So Black, ceramic đen mờ, đính kim cương, cá tính và hiện đại.",
        //         "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco Watch Black Steel",
        //         "image" => "code-coco-watch-black-steel-black-ceramic-diamond-packshot-default-h6027-8825232359454",
        //         "price" => 443314743,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco, thép không gỉ, ceramic đen, đính kim cương, thiết kế sang trọng.",
        //         "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Boy·Friend Skeleton Watch Beige Gold",
        //         "image" => "boy-friend-skeleton-watch-beige-beige-gold-diamond-calfskin-packshot-default-h6949-9570157723678",
        //         "price" => 149720049,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Manual",
        //         "description" => "Chanel Boy·Friend Skeleton, vàng beige, dây da bê, thiết kế lộ máy, đính kim cương.",
        //         "note" => "Chống nước 30m, kính sapphire, dây da bê",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Boy·Friend Watch Silver White Gold",
        //         "image" => "boy-friend-watch-silver-white-gold-diamond-calfskin-packshot-default-h6674-9564215738398",
        //         "price" => 111837711,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Boy·Friend, vàng trắng, dây da bê, đính kim cương, thiết kế thanh lịch.",
        //         "note" => "Chống nước 30m, kính sapphire, dây da bê",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel Code Coco Watch Beige Gold",
        //         "image" => "code-coco-watch-beige-beige-gold-diamond-packshot-default-h5146-8825229705246",
        //         "price" => 140072986,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Quartz",
        //         "description" => "Chanel Code Coco, vàng beige, đính kim cương, thiết kế sang trọng, nữ tính.",
        //         "note" => "Chống nước 30m, kính sapphire, kim cương thiên nhiên",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Baguette Diamond Bezel Watch Caliber 12.2 33mm",
        //         "image" => "j12-baguette-diamond-bezel-watch-caliber-12-2-33-mm-white-white-ceramic-white-gold-diamond-packshot-default-h7430-9563849031710",
        //         "price" => 220123909,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Baguette Diamond Bezel, 33mm, ceramic trắng, vàng trắng, đính kim cương baguette.",
        //         "note" => "Chống nước 50m, kính sapphire, kim cương baguette",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 3,
        //         "name" => "Chanel J12 Baguette Diamond Bezel Watch Caliber 12.2 33mm",
        //         "image" => "j12-baguette-diamond-bezel-watch-caliber-12-2-33-mm-white-white-ceramic-white-gold-diamond-packshot-dos-h7430-9563848081438",
        //         "price" => 258823355,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Automatic",
        //         "description" => "Chanel J12 Baguette Diamond Bezel, 33mm, ceramic trắng, vàng trắng, đính kim cương baguette.",
        //         "note" => "Chống nước 50m, kính sapphire, kim cương baguette",
        //         "status" => "active"
        //     ]
        // ]);
        //Mắt kính Chanel
        // \App\Models\Product::insert([
        //     [
        //         "id_category" => 4,
        //         "name" => "Rectangle Sunglasses Black Acetate & Calfskin",
        //         "image" => "rectangle-sunglasses-black-acetate-calfskin-acetate-calfskin-packshot-default-a71716x02153s2228-9567932022814",
        //         "price" => 3740045,
        //         "rating" => 4,
        //         "gender" => "Unisex",
        //         "volume" => null,
        //         "type" => "Acetate, Calfskin",
        //         "description" => "Kính mát Chanel dáng chữ nhật, chất liệu acetate đen phối da bê, thiết kế hiện đại, sang trọng.",
        //         "note" => "Chống tia UV, phù hợp nhiều khuôn mặt",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Rectangle Sunglasses Black & Gold Acetate",
        //         "image" => "rectangle-sunglasses-black-gold-acetate-acetate-packshot-default-a71377x08101s2216-8853782790174",
        //         "price" => 24675613,
        //         "rating" => 5,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate",
        //         "description" => "Kính mát Chanel dáng chữ nhật, phối màu đen và vàng, chất liệu acetate cao cấp.",
        //         "note" => "Gọng nhẹ, chống chói tốt",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Cat Eye Sunglasses White Acetate & Glass Pearls",
        //         "image" => "cat-eye-sunglasses-white-acetate-glass-pearls-acetate-glass-pearls-packshot-default-a71491x08222s5512-9516163104798",
        //         "price" => 30825302,
        //         "rating" => 5,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Glass Pearls",
        //         "description" => "Kính mát Chanel mắt mèo, màu trắng, điểm xuyết ngọc trai thủy tinh sang trọng.",
        //         "note" => "Phong cách nữ tính, thời trang",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Square Sunglasses Black Acetate",
        //         "image" => "square-sunglasses-black-acetate-acetate-packshot-extra-a71305x08101s2214-8853776203806",
        //         "price" => 35565985,
        //         "rating" => 5,
        //         "gender" => "Unisex",
        //         "volume" => null,
        //         "type" => "Acetate",
        //         "description" => "Kính mát Chanel dáng vuông, chất liệu acetate đen, phù hợp cả nam và nữ.",
        //         "note" => "Thiết kế cổ điển, dễ phối đồ",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Cat Eye Sunglasses Black Acetate & Metal",
        //         "image" => "cat-eye-sunglasses-black-acetate-metal-acetate-metal-packshot-default-a71710x06081s2216-9558779789342",
        //         "price" => 33975021,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Metal",
        //         "description" => "Kính mát Chanel mắt mèo, gọng đen phối kim loại, phong cách cá tính.",
        //         "note" => "Chống tia UV, phù hợp mặt trái xoan",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Butterfly Sunglasses Black Acetate & Metal",
        //         "image" => "butterfly-sunglasses-black-acetate-metal-acetate-metal-packshot-other-a71711x06081s2216-9558780280862",
        //         "price" => 30689476,
        //         "rating" => 5,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Metal",
        //         "description" => "Kính mát Chanel dáng bướm, gọng đen phối kim loại, tạo điểm nhấn nổi bật.",
        //         "note" => "Phong cách sang trọng, nữ tính",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Round Sunglasses Gold & Black Metal Calfskin",
        //         "image" => "round-sunglasses-gold-black-metal-calfskin-metal-calfskin-packshot-extra-a71384x27388l3953-8853784100894",
        //         "price" => 44471385,
        //         "rating" => 4,
        //         "gender" => "Unisex",
        //         "volume" => null,
        //         "type" => "Metal, Calfskin",
        //         "description" => "Kính mát Chanel tròn, phối màu vàng đen, gọng kim loại bọc da bê cao cấp.",
        //         "note" => "Phong cách retro, phù hợp nhiều khuôn mặt",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Oval Sunglasses Black Nylon & Metal Leather",
        //         "image" => "oval-sunglasses-black-nylon-metal-leather-nylon-metal-leather-packshot-default-a71713x06023s0116-9558780117022",
        //         "price" => 39587638,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Nylon, Metal, Leather",
        //         "description" => "Kính mát Chanel oval, gọng nylon đen phối kim loại và da, thiết kế thanh lịch.",
        //         "note" => "Chống tia UV, nhẹ và bền",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Square Sunglasses Coral Nylon",
        //         "image" => "square-sunglasses-coral-nylon-nylon-packshot-default-a71692x02081s0714-9558780411934",
        //         "price" => 44170299,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Nylon",
        //         "description" => "Kính mát Chanel vuông, màu cam san hô, chất liệu nylon trẻ trung.",
        //         "note" => "Phong cách năng động, phù hợp mùa hè",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Cat Eye Sunglasses Black Acetate & Strass",
        //         "image" => "cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-extra-a71667x02569s2216-9550223802398",
        //         "price" => 6117802,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Strass",
        //         "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass lấp lánh.",
        //         "note" => "Tạo điểm nhấn nổi bật, thời trang",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Cat Eye Sunglasses Black Acetate & Strass",
        //         "image" => "cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-default-a71668x02569s2216-9550229897246",
        //         "price" => 34693608,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Strass",
        //         "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass, phong cách sang trọng.",
        //         "note" => "Chống tia UV, phù hợp dự tiệc",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Cat Eye Sunglasses Black Acetate & Strass",
        //         "image" => "cat-eye-sunglasses-black-acetate-strass-acetate-strass-packshot-default-a71669x02569s2287-9550231666718",
        //         "price" => 45781576,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Strass",
        //         "description" => "Kính mát Chanel mắt mèo, gọng đen đính đá strass, thiết kế tinh tế.",
        //         "note" => "Phong cách quý phái, bảo vệ mắt tối ưu",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Rectangle Sunglasses Red Acetate",
        //         "image" => "rectangle-sunglasses-red-acetate-acetate-packshot-other-a71649x08101s7911-9546504831006",
        //         "price" => 1504700,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate",
        //         "description" => "Kính mát Chanel dáng chữ nhật, màu đỏ nổi bật, chất liệu acetate.",
        //         "note" => "Phong cách trẻ trung, cá tính",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Square Sunglasses Gold Metal Calfskin Denim",
        //         "image" => "square-sunglasses-gold-metal-calfskin-denim-metal-calfskin-denim-packshot-default-a71693x02609l8819-9563891793950",
        //         "price" => 7636831,
        //         "rating" => 4,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Metal, Calfskin, Denim",
        //         "description" => "Kính mát Chanel vuông, phối vàng, da bê và denim, thiết kế độc đáo.",
        //         "note" => "Chống tia UV, phong cách cá tính",
        //         "status" => "active"
        //     ],
        //     [
        //         "id_category" => 4,
        //         "name" => "Square Sunglasses Off White Acetate Tweed Leather",
        //         "image" => "square-sunglasses-off-white-acetate-tweed-leather-acetate-tweed-leather-packshot-default-a71652x22002s8761-9546504667166",
        //         "price" => 15928583,
        //         "rating" => 3,
        //         "gender" => "Nữ",
        //         "volume" => null,
        //         "type" => "Acetate, Tweed, Leather",
        //         "description" => "Kính mát Chanel vuông, màu trắng ngà, phối tweed và da, phong cách thanh lịch.",
        //         "note" => "Thiết kế sang trọng, phù hợp nhiều dịp",
        //         "status" => "active"
        //     ]
        // ]);


        // \App\Models\User=>=>factory(10)->create();

        // \App\Models\User=>=>factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
