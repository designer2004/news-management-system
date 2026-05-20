<?php
session_start();
require_once 'db_connection.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$error = '';
$success = '';

$catQuery = "SELECT Id, Name FROM categories ORDER BY Name ASC";
$catResult = mysqli_query($conn, $catQuery);

if(!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if(isset($_POST['addNews'])) {
    extract($_POST);
    $UserId = $_SESSION['user_id'];
    
    if(empty($Title) || empty($Content) || empty($CategoryId)) {
        $error = 'جميع الحقول مطلوبة (العنوان، التفاصيل، الفئة)';
    }
    else {
        $Image = '';
        if(isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES['Image']['name']; 
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if(in_array($ext, $allowed)) {
                $new_name = time() . '_' . uniqid() . '.' . $ext;
                $upload_path = 'uploads/' . $new_name;
                
                if(move_uploaded_file($_FILES['Image']['tmp_name'], $upload_path)) {
                    $Image = $upload_path;
                } else {
                    $error = 'فشل رفع الصورة';
                }
            } else {
                $error = 'نوع الملف غير مسموح. الأنواع المسموحة: jpg, jpeg, png, gif, webp';
            }
        }
        
        if(empty($error)) {
            $query = "INSERT INTO news (Title, Content, Image, CategoryId, UserId) 
                      VALUES ('$Title', '$Content', '$Image', '$CategoryId', '$UserId')";
            $result = mysqli_query($conn, $query);
            
            if($result === FALSE) {
                $error = 'حدث خطأ: ' . mysqli_error($conn);
            }
            else {
                $success = 'تم إضافة الخبر بنجاح';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نظام إدارة الأخبار - إضافة خبر</title>
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
                max-width: 700px;
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
            .form-group {
                margin-bottom: 25px;
            }
            .form-group label {
                display: block;
                margin-bottom: 10px;
                color: rgba(255, 255, 255, 0.8);
                font-weight: 500;
            }
            .input-field, select, textarea {
                width: 100%;
                padding: 12px 16px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                text-align: right;
                outline: none;
                font-family: 'Cairo', sans-serif;
                transition: 0.3s;
                box-sizing: border-box;
            }
            textarea {
                resize: vertical;
                min-height: 120px;
            }
            select option {
                background: #1E293B;
                color: white;
            }
            .input-field:focus, select:focus, textarea:focus {
                border-color: #38BDF8;
                background: rgba(255, 255, 255, 0.1);
            }
            .image-upload-area {
                border: 2px dashed rgba(56, 189, 248, 0.3);
                border-radius: 15px;
                padding: 20px;
                text-align: center;
                cursor: pointer;
                transition: 0.3s;
            }
            .image-upload-area:hover {
                border-color: #38BDF8;
                background: rgba(56, 189, 248, 0.05);
            }
            .image-upload-area p {
                color: white;
                margin-bottom: 5px;
                font-size: 14px;
            }
            .image-upload-area small {
                color: rgba(255, 255, 255, 0.5);
                font-size: 12px;
                display: block;
            }
            .upload-icon {
                font-size: 48px;
                color: #38BDF8;
                margin-bottom: 10px;
            }
            .image-preview {
                width: 100%;
                max-height: 200px;
                object-fit: cover;
                border-radius: 12px;
                margin-top: 15px;
                display: none;
            }
            .image-preview.show {
                display: block;
            }
            .file-input {
                display: none;
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
                padding: 12px 16px;
                border-radius: 12px;
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
                <h1>إضافة خبر </h1>
                <p>أضف خبرا إلى نظام إدارة الأخبار</p>
            </div>

            <div class="form-card">
                <?php if($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>عنوان الخبر</label>
                        <input type="text" name="Title" placeholder="أدخل عنوان الخبر" class="input-field" required>
                    </div>

                    <div class="form-group">
                        <label>تفاصيل الخبر</label>
                        <textarea name="Content" placeholder="أدخل تفاصيل الخبر" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>صورة الخبر </label>
                        <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p>انقر لرفع صورة من جهازك</p>
                            <small>الصيغ المدعومة: JPG, JPEG, PNG, GIF, WEBP</small>
                            <img id="imagePreview" class="image-preview" alt="معاينة الصورة">
                        </div>
                        <input type="file" id="imageInput" name="Image" class="file-input" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" onchange="previewImage(this)">
                    </div>

                    <div class="form-group">
                        <label>تصنيف الخبر</label>
                        <select name="CategoryId" required>
                            <option value=""> حدد التصنيف</option>
                            <?php if(mysqli_num_rows($catResult) > 0): ?>
                                <?php while($category = mysqli_fetch_assoc($catResult)): ?>
                                    <option value="<?php echo $category['Id']; ?>">
                                        <?php echo $category['Name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="" disabled>لا توجد تصنيفات، يرجى إضافة تصنيف أولا</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <small style="color: rgba(255, 255, 255, 0.5); display: block; text-align: center;">
                            منشئ الخبر: <strong><?php echo $_SESSION['user_name']; ?></strong>
                        </small>
                    </div>

                    <button type="submit" name="addNews" class="btn-primary">
                        نشر الخبر
                    </button>
                </form>

                <div class="nav-links">
                    <a href="Dashboard.php" class="nav-link">
                        الرئيسية
                    </a>
                    <a href="viewNews.php" class="nav-link">
                        عرض الأخبار
                    </a>
                </div>
            </div>
        </div>

        <script>
            function previewImage(input) {
                const preview = document.getElementById('imagePreview');
                if(input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.add('show');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>

</html>

<?php
mysqli_close($conn);
?>