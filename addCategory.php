<?php
session_start();
require_once 'db_connection.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$error = '';
$success = '';

if(isset($_POST['addCategory'])) {
    extract($_POST);
    
    if(empty($Name)) {
        $error = 'اسم الفئة مطلوب';
    }
    else {
        $query = "INSERT INTO categories (Name) VALUES ('$Name')";
        $result = mysqli_query($conn, $query);
        
        if($result === FALSE) {
            $error = 'حدث خطأ: ' . mysqli_error($conn);
        }
        else {
            $success = 'تم إضافة الفئة بنجاح';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نظام إدارة الأخبار - إضافة فئة</title>
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
            .btn-primary {
                background: linear-gradient(135deg, #38BDF8 0%, #0284C7 100%);
                color: white;
                padding: 14px 25px;
                border-radius: 15px;
                font-weight: 600;
                width: 100%;
                cursor: pointer;
                border: none;
                font-family: 'Cairo', sans-serif;
                font-size: 16px;
                transition: 0.3s;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(56, 189, 248, 0.3);
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
                max-width: 450px;
                margin: 0 auto;
            }
            .form-group {
                margin-bottom: 25px;
            }
            .form-group label {
                display: block;
                margin-bottom: 10px;
                color: rgba(255, 255, 255, 0.8);
                font-weight: 500;
            }
            .input-field {
                width: 100%;
                padding: 14px 18px;
                border-radius: 15px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                text-align: right;
                outline: none;
                font-family: 'Cairo', sans-serif;
                transition: 0.3s;
            }
            .input-field:focus {
                border-color: #38BDF8;
                background: rgba(255, 255, 255, 0.1);
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

            .alert {
                padding: 14px 18px;
                border-radius: 15px;
                text-align: center;
                margin-bottom: 25px;
                font-weight: 500;
            }
            .alert-error {
                background: rgba(248, 113, 113, 0.15);
                border: 1px solid rgba(248, 113, 113, 0.3);
                color: #f87171;
            }
            .alert-success {
                background: rgba(74, 222, 128, 0.15);
                border: 1px solid rgba(74, 222, 128, 0.3);
                color: #4ade80;
            }
        </style>
    </head>

    <body>
        <div class="main-container">
        
            <div class="page-header">
                <h1>إدارة الفئات</h1>
                <p>إضافة تصنيف جديد للأخبار (سياسية، رياضية، اقتصادية، ثقافية)</p>
            </div>

            <div class="form-card">
                
                <?php if($error): ?>
                    <div class="alert alert-error">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>اسم الفئة</label>
                        <input type="text" name="Name" placeholder="مثال: سياسية، رياضية، اقتصادية" class="input-field" required>
                    </div>

                    <button type="submit" name="addCategory" class="btn-primary">
                        حفظ الفئة
                    </button>
                </form>

                <div class="nav-links">
                    <a href="Dashboard.php" class="nav-link">
                        الرئيسية
                    </a>
                </div>
            </div>
        </div>

    </body>
    
</html>

<?php
mysqli_close($conn);
?>