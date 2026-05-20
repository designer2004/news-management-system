<?php
require_once 'db_connection.php';

$error = '';
$success = '';

if(isset($_POST['register'])) {
    extract($_POST);
    
    if(empty($Name) || empty($Email) || empty($Password)) {
        $error = 'جميع الحقول مطلوبة';
    }

    elseif($Password !== $PasswordConfirm) {
        $error = 'كلمة المرور وتأكيدها غير متطابقين';
    }

    elseif(strlen($Password) < 6) {
        $error = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
    }

    else {
        $check = mysqli_query($conn, "SELECT Id FROM users WHERE Email='$Email'");
        
        if(mysqli_num_rows($check) > 0) {
            $error = 'البريد الإلكتروني مسجل مسبقاً';
        }

        else {
            $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (Name, Email, Password) VALUES ('$Name', '$Email', '$hashed_password')";
            $result = mysqli_query($conn, $query);
            
            if($result === FALSE) {
                $error = 'حدث خطأ: ' . mysqli_error($conn);
            }

            else {
                $success = 'تم إنشاء الحساب بنجاح. جاري التوجيه...';
                header("refresh:2; url=Login.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>إدارة الأخبار - إنشاء حساب</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
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
            .text-danger { color: #f87171; }
            .text-success { color: #4ade80; }
        </style>
    </head>

    <body>
        <div class="glass-box">
            <h2 class="text-2xl font-bold mb-6 text-center">إنشاء حساب</h2>
            <?php if($error): ?>
                <div style="background: rgba(248, 113, 113, 0.2); border: 1px solid #f87171; color: #f87171; text-align: center; margin-bottom: 15px; padding: 12px; border-radius: 15px; font-weight: bold;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div style="background: rgba(74, 222, 128, 0.2); border: 1px solid #4ade80; color: #4ade80; text-align: center; margin-bottom: 15px; padding: 12px; border-radius: 15px; font-weight: bold;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                
                <input type="text" name="Name" placeholder="الاسم الكامل" class="input-field">
                <input type="email" name="Email" placeholder="البريد الإلكتروني" class="input-field">
                <input type="password" name="Password" placeholder="كلمة المرور" class="input-field">
                <input type="password" name="PasswordConfirm"  placeholder="تأكيد كلمة المرور" class="input-field">
                <button type="submit" name="register" class="btn-main">تسجيل</button>
            </form>
            <p class="mt-6 text-sm text-center opacity-70">لديك حساب بالفعل؟ <a href="Login.php" class="underline">دخول</a></p>
        </div> 
    </body>

</html>
<?php
mysqli_close($conn);
?>