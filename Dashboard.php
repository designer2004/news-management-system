<?php
session_start();
require_once 'db_connection.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نظام إدارة الأخبار - الرئيسية</title>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
                font-family: 'Cairo', sans-serif;
                min-height: 100vh;
            }
            
            .dashboard-container {
                max-width: 900px;
                margin: 50px auto;
                padding: 0 20px;
            }
            .welcome-card {
                background: linear-gradient(135deg, rgba(56, 189, 248, 0.15), rgba(56, 189, 248, 0.05));
                border: 1px solid rgba(56, 189, 248, 0.3);
                border-radius: 25px;
                padding: 35px 30px;
                text-align: center;
                margin-bottom: 40px;
            }
            .welcome-card h1 {
                font-size: 28px;
                color: #38BDF8;
                margin-bottom: 12px;
            }
            .welcome-card p {
                color: rgba(255, 255, 255, 0.8);
                font-size: 16px;
                font-weight: 500;
            }
            .main-menu {
                background: rgba(255, 255, 255, 0.03);
                border-radius: 25px;
                border: 1px solid rgba(255, 255, 255, 0.08);
                overflow: hidden;
            }
            .menu-item {
                display: flex;
                align-items: center;
                padding: 18px 25px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                text-decoration: none;
                transition: all 0.3s ease;
            }
            .menu-item:last-child {
                border-bottom: none;
            }
            .menu-item:hover {
                background: rgba(56, 189, 248, 0.1);
                padding-right: 35px;
            }
            .menu-icon {
                width: 45px;
                height: 45px;
                background: rgba(56, 189, 248, 0.15);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-left: 18px;
            }
            .menu-icon i {
                font-size: 22px;
                color: #38BDF8;
            }
            .menu-content {
                flex: 1;
            }
            .menu-title {
                font-size: 18px;
                font-weight: 600;
                color: white;
                margin-bottom: 5px;
            }
            .menu-desc {
                font-size: 13px;
                color: rgba(255, 255, 255, 0.5);
            }
            .menu-arrow {
                color: rgba(255, 255, 255, 0.3);
                font-size: 18px;
            }
        </style>
    </head>

    <body>
        <div class="dashboard-container">

            <div class="welcome-card">
                <h1>مرحباً <?php echo $user_name; ?></h1>
                <h2 style="color: white; font-size: 22px; margin-bottom: 12px;">لوحة التحكم - نظام إدارة الأخبار</h2>
                <p>منصة إدارة المحتوى الإخباري | التحكم الكامل بالفئات والأخبار</p>
            </div>

            <div class="main-menu">
                <a href="addCategory.php" class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-folder-plus"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">إضافة فئة</div>
                        <div class="menu-desc">إضافة فئة جديدة (سياسية، رياضية، اقتصادية)</div>
                    </div>
                    <div class="menu-arrow"><i class="fas fa-chevron-left"></i></div>
                </a>

                <a href="viewCategories.php" class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">عرض الفئات</div>
                        <div class="menu-desc">عرض جميع الفئات المخزنة في قاعدة البيانات</div>
                    </div>
                    <div class="menu-arrow"><i class="fas fa-chevron-left"></i></div>
                </a>

                <a href="addNews.php" class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-pen-alt"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">إضافة خبر</div>
                        <div class="menu-desc">إضافة خبر جديد (عنوان، تفاصيل، صورة، فئة)</div>
                    </div>
                    <div class="menu-arrow"><i class="fas fa-chevron-left"></i></div>
                </a>

                <a href="viewNews.php" class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">عرض الأخبار</div>
                        <div class="menu-desc">عرض جميع الأخبار مع خيارات التعديل والحذف</div>
                    </div>
                    <div class="menu-arrow"><i class="fas fa-chevron-left"></i></div>
                </a>

                <a href="deletedNews.php" class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">الأخبار المحذوفة</div>
                        <div class="menu-desc">عرض الأخبار التي تم حذفها من النظام</div>
                    </div>
                    <div class="menu-arrow"><i class="fas fa-chevron-left"></i></div>
                </a>

            </div>
        </div>

    </body>
    
</html>

<?php
mysqli_close($conn);
?>