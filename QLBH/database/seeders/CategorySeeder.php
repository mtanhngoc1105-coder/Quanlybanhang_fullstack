<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // MÔ HÌNH / FIGURE
        $figure = Category::create(['name' => 'MÔ HÌNH / FIGURE', 'slug' => 'mo-hinh-figure']);
        
        Category::create(['name' => 'MÔ HÌNH PVC', 'slug' => 'mo-hinh-pvc', 'parent_id' => $figure->id]);
        Category::create(['name' => 'MÔ HÌNH RESIN', 'slug' => 'mo-hinh-resin', 'parent_id' => $figure->id]);
        Category::create(['name' => 'HÀNG ĐẶT TRƯỚC', 'slug' => 'hang-dat-truoc', 'parent_id' => $figure->id]);
        Category::create(['name' => 'HÀNG SẮP XUẤT', 'slug' => 'hang-sap-xuat', 'parent_id' => $figure->id]);
        Category::create(['name' => 'SẢN PHẨM NỔI BẬT', 'slug' => 'san-pham-noi-bat', 'parent_id' => $figure->id]);

        // SẢN PHẨM KHÁC
        $other = Category::create(['name' => 'SẢN PHẨM KHÁC', 'slug' => 'san-pham-khac']);
        
        Category::create(['name' => 'ÁO PHÔNG', 'slug' => 'ao-phong', 'parent_id' => $other->id]);
        Category::create(['name' => 'MŨ / NÓN', 'slug' => 'mu-non', 'parent_id' => $other->id]);
        Category::create(['name' => 'PHỤ KIỆN', 'slug' => 'phu-kien', 'parent_id' => $other->id]);

        // KHUYẾN MÃI
        $promo = Category::create(['name' => 'KHUYẾN MÃI', 'slug' => 'khuyen-mai']);
        
        Category::create(['name' => 'FLASH SALE', 'slug' => 'flash-sale', 'parent_id' => $promo->id]);
        Category::create(['name' => 'PROMO MỚI', 'slug' => 'promo-moi', 'parent_id' => $promo->id]);

        // HƯỚNG DẪN
        $guide = Category::create(['name' => 'HƯỚNG DẪN', 'slug' => 'huong-dan']);
        
        Category::create(['name' => 'CÁCH MUA', 'slug' => 'cach-mua', 'parent_id' => $guide->id]);
        Category::create(['name' => 'THANH TOÁN', 'slug' => 'thanh-toan', 'parent_id' => $guide->id]);
        Category::create(['name' => 'GIAO HÀNG', 'slug' => 'giao-hang', 'parent_id' => $guide->id]);

        // TIN TỨC
        $news = Category::create(['name' => 'TIN TỨC', 'slug' => 'tin-tuc']);
        
        Category::create(['name' => 'LIÊN HỆ', 'slug' => 'lien-he', 'parent_id' => $news->id]);
        Category::create(['name' => 'TIN MỚI', 'slug' => 'tin-moi', 'parent_id' => $news->id]);
        Category::create(['name' => 'REVIEW', 'slug' => 'review', 'parent_id' => $news->id]);
        Category::create(['name' => 'SỰ KIỆN', 'slug' => 'su-kien', 'parent_id' => $news->id]);

        // KHÁC
        $otherCat = Category::create(['name' => 'KHÁC', 'slug' => 'khac']);
        
        Category::create(['name' => 'TUYỂN DỤNG', 'slug' => 'tuyen-dung', 'parent_id' => $otherCat->id]);
        Category::create(['name' => 'CỘNG TÁC VIÊN', 'slug' => 'cong-tac-vien', 'parent_id' => $otherCat->id]);
        Category::create(['name' => 'LIÊN HỆ QUẢNG CÁO', 'slug' => 'lien-he-quang-cao', 'parent_id' => $otherCat->id]);
    }
}