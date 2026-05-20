<?php
session_start();
require_once 'db_connection.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$query = "SELECT Id, Name FROM categories ORDER BY Id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نظام إدارة الأخبار - عرض الفئات</title>
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
                max-width: 800px;
                margin: 50px auto;
                padding: 0 20px;
            }
            .form-card {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 25px;
                padding: 35px;
                max-width: 600px;
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
                background: rgba(56, 189, 248, 0.15);
                color: #38BDF8;
                padding: 12px 15px;
                text-align: center;
                font-weight: 600;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            td {
                padding: 12px 15px;
                text-align: center;
                color: rgba(255, 255, 255, 0.8);
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            tr:hover {
                background: rgba(255, 255, 255, 0.03);
            }
            .empty-row td {
                text-align: center;
                padding: 40px;
                color: rgba(255, 255, 255, 0.5);
            }
            .badge-id {
                background: rgba(56, 189, 248, 0.2);
                color: #38BDF8;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                display: inline-block;
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
        </style>
    </head>

    <body>
        <div class="main-container">
        
            <div class="page-header">
                <h1>عرض الفئات</h1>
                <p>جميع التصنيفات المخزنة في قاعدة البيانات</p>
            </div>

            <div class="form-card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم الفئة</th>
                                <th>اسم الفئة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><span class="badge-id"><?php echo $row['Id']; ?></span></td>
                                        <td><?php echo $row['Name']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="2"> لا توجد فئات مسجلة حتى الآن</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="nav-links">
                    <a href="Dashboard.php" class="nav-link">
                        الرئيسية
                    </a>
                    <a href="addCategory.php" class="nav-link">
                         إضافة فئة جديدة
                    </a>
                </div>
            </div>
        </div>

    </body>
    
</html>

<?php
mysqli_close($conn);
?>