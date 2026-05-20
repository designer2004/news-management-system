<?php
session_start();
require_once 'db_connection.php';

$error = '';

if(isset($_POST['login'])) {
    extract($_POST);
    
    if(empty($Email) || empty($Password)) {
        $error = 'البريد الإلكتروني وكلمة المرور مطلوبان';
    }
    else {
        $query = "SELECT Id, Name, Email, Password FROM users WHERE Email='$Email'";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            if(password_verify($Password, $user['Password'])) {
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['user_name'] = $user['Name'];
                header("Location: Dashboard.php");
                exit();
            }
            else {
                $error = 'كلمة المرور غير صحيحة';
            }
        }
        else {
            $error = 'البريد الإلكتروني غير مسجل';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>إدارة الأخبار - تسجيل دخول</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            body { 
                background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
                font-family: 'Cairo', sans-serif; 
                color: white; 
                min-height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                margin: 0;
            }
            .glass-box { 
                background: rgba(255, 255, 255, 0.05); 
                backdrop-filter: blur(20px); 
                border: 1px solid rgba(255, 255, 255, 0.15); 
                border-radius: 40px; 
                padding: 40px; 
                width: 90%; 
                max-width: 400px; 
            }
            .input-field { 
                width: 100%; 
                padding: 15px; 
                margin-bottom: 15px; 
                border-radius: 20px; 
                background: rgba(255, 255, 255, 0.05); 
                border: 1px solid rgba(255, 255, 255, 0.1); 
                color: white; 
                text-align: right; 
                outline: none; 
                box-sizing: border-box;
            }
            .btn-main { 
                background: linear-gradient(135deg, #38BDF8 0%, #0284C7 100%);
                color: white; 
                padding: 15px; 
                border-radius: 20px; 
                font-weight: bold; 
                width: 100%; 
                cursor: pointer; 
                border: none;
            }
            .text-center {
                text-align: center;
            }
        
        </style>
    </head>

    <body>
        <div class="glass-box">
            <h2 class="text-2xl font-bold mb-6 text-center">تسجيل الدخول</h2>
            
            <?php if($error): ?>
                <div style="background: rgba(248, 113, 113, 0.2); border: 1px solid #f87171; color: #f87171; text-align: center; margin-bottom: 15px; padding: 12px; border-radius: 15px; font-weight: bold;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="email" name="Email" placeholder="البريد الإلكتروني" class="input-field" required>
                <input type="password" name="Password" placeholder="كلمة المرور" class="input-field" required>
                <button type="submit" name="login" class="btn-main">دخول</button>
            </form>
            
            <p class="mt-6 text-sm text-center opacity-70">ليس لديك حساب؟ <a href="Register.php" class="underline">إنشاء حساب</a></p>
        </div> 
    </body>
    
</html>

<?php
mysqli_close($conn);
?>