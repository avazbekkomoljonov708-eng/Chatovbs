<!-- resources/views/emails/login_code.blade.php -->
<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background:#0f172a; padding:40px; color:#fff;">
    <div style="max-width:480px; margin:0 auto; background:#1e293b; border-radius:16px; padding:32px; text-align:center;">
        <h2 style="color:#a78bfa;">ChatO'VBS</h2>
        <p>Akkountingizga kirish uchun quyidagi kodni kiriting:</p>
        <div style="font-size:32px; letter-spacing:8px; font-weight:bold; background:#0f172a; padding:16px; border-radius:12px; margin:20px 0;">
            {{ $code }}
        </div>
        <p style="color:#94a3b8; font-size:13px;">Kod 10 daqiqa amal qiladi. Agar bu siz bo'lmasangiz, xabarni e'tiborsiz qoldiring.</p>
    </div>
</body>
</html>