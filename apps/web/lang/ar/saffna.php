<?php

return [
    'auth' => [
        'already_authenticated' => 'أنت مسجل الدخول بالفعل.',
        'csrf_mismatch' => 'انتهت صلاحية رمز الجلسة. حدّث الصفحة وحاول مرة أخرى.',
        'forbidden' => 'ليس لديك صلاحية لتنفيذ هذا الإجراء.',
        'invalid_credentials' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        'password_change_required' => 'غيّر كلمة المرور المؤقتة قبل المتابعة.',
        'throttled' => 'محاولات تسجيل الدخول كثيرة. انتظر دقيقة ثم حاول مرة أخرى.',
        'unauthenticated' => 'انتهت جلستك. سجّل الدخول مرة أخرى.',
    ],
    'api' => [
        'not_found' => 'المورد المطلوب غير موجود.',
        'server_error' => 'حدث خطأ غير متوقع. حاول مرة أخرى.',
    ],
    'validation' => [
        'email_invalid' => 'أدخل بريداً إلكترونياً صحيحاً.',
        'email_required' => 'البريد الإلكتروني مطلوب.',
        'failed' => 'صحّح الحقول المحددة.',
        'current_password_invalid' => 'كلمة المرور الحالية غير صحيحة.',
        'current_password_required' => 'كلمة المرور الحالية مطلوبة.',
        'new_password_confirmation' => 'تأكيد كلمة المرور الجديدة غير مطابق.',
        'new_password_different' => 'يجب أن تختلف كلمة المرور الجديدة عن كلمة المرور الحالية.',
        'new_password_policy' => 'استخدم 12 حرفاً على الأقل، مع أحرف إنجليزية كبيرة وصغيرة ورقم.',
        'new_password_required' => 'كلمة المرور الجديدة مطلوبة.',
        'password_required' => 'كلمة المرور مطلوبة.',
        'password_confirmation_required' => 'أكّد كلمة المرور الجديدة.',
        'remember_invalid' => 'قيمة تذكرني غير صحيحة.',
    ],
];
