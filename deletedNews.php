<?php
session_start();
require_once 'db_connection.php';

if(!isset($_SESSION['user_id'])) {
    header("Location:Login.php");
    exit();
}

$query = "SELECT news.*, categories.Name as category_name, users.Name as user_name 
          FROM news 
          LEFT JOIN categories ON news.CategoryId = categories.Id 
          LEFT JOIN users ON news.UserId = users.Id 
          WHERE news.IsDeleted = 1 
          ORDER BY news.Id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نظام إدارة الأخبار - الأخبار المحذوفة</title>
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
            .page-header {
                text-align: center;
                margin-bottom: 40px;
            }
            .page-header h1 {
                font-size: 32px;
                color: white;
                margin-bottom: 10px;
            }
            .page-header p {
                color: rgba(255, 255, 255, 0.6);
                font-size: 15px;
            }
            .main-container {
                max-width: 1200px;
                margin: 50px auto;
                padding: 0 20px;
            }
            .form-card {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 25px;
                padding: 35px;
                margin: 0 auto;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th {
                background: rgba(248, 113, 113, 0.15);
                color: #f87171;
                padding: 15px;
                text-align: center;
                font-weight: 600;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            td {
                padding: 12px 15px;
                text-align: center;
                color: rgba(255, 255, 255, 0.8);
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                vertical-align: middle;
            }
            tr:hover {
                background: rgba(255, 255, 255, 0.03);
            }
            .news-image {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 10px;
                opacity: 0.7;
            }
            .no-image {
                color: rgba(255, 255, 255, 0.4);
                font-size: 12px;
            }
            .badge-category {
                background: rgba(56, 189, 248, 0.15);
                color: #38BDF8;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                display: inline-block;
            }
            .empty-row td {
                text-align: center;
                padding: 60px;
                color: rgba(255, 255, 255, 0.5);
            }
            .nav-links {
                display: flex;
                justify-content: center;
                gap: 30px;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }
            .nav-link {
                color: rgba(255, 255, 255, 0.6);
                text-decoration: none;
                transition: 0.3s;
            }
            .nav-link:hover {
                color: #38BDF8;
            }
            .title-cell {
                max-width: 250px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    </head>

    <body>
        <div class="main-container">
        
            <div class="page-header">
                <h1>الأخبار المحذوفة</h1>
                <p>جميع الأخبار التي تم حذفها من النظام</p>
            </div>

            <div class="form-card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم الخبر</th>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>التصنيف</th>
                                <th>المنشئ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php $counter = 1; ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td>
                                            <?php echo $counter++; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($row['Image'])): ?>
                                                <img src="<?php echo $row['Image']; ?>" class="news-image" alt="صورة الخبر">
                                            <?php else: ?>
                                                <span class="no-image"><i class="fas fa-image"></i> لا توجد</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="title-cell" title="<?php echo $row['Title']; ?>">
                                            <?php echo $row['Title']; ?>
                                        </td>
                                        <td><span class="badge-category"><?php echo $row['category_name'] ?? 'غير مصنف'; ?></span></td>
                                        <td><?php echo $row['user_name'] ?? 'غير معروف'; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="5">
                                        <i class="fas fa-trash-alt" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 15px;"></i>
                                        لا توجد أخبار محذوفة
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="nav-links">
                    <a href="Dashboard.php" class="nav-link">
                        الرئيسية
                    </a>
                    <a href="viewNews.php" class="nav-link">
                        عرض الأخبار المنشورة
                    </a>
                </div>
            </div>
        </div>
    </body>

</html>

<?php
mysqli_close($conn);
?>