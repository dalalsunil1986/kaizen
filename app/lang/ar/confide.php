<?php

return array(

    'username' => 'اسم المستخدم',
    'password' => 'كلمة المرور',
    'password_confirmation' => 'تأكيد كلمة المرور',
    'e_mail' => 'البريد الإلكتروني',
    'username_e_mail' => 'اسم المستخدم أو البريد الإلكتروني',

    'signup' => array(
        'title' => 'Signup',
        'desc' => 'Signup for new account',
        'confirmation_required' => 'Confirmation required',
        'submit' => 'Create new account',
    ),

    'login' => array(
        'title' => 'الدخول',
        'desc' => 'إدخال بياناتك السرية',
        'forgot_password' => '(نسيت كلمة المرور)',
        'remember' => 'تذكرني',
        'submit' => 'دخول',
    ),

    'forgot' => array(
        'title' => 'Forgot password',
        'submit' => 'Continue',
    ),

    'alerts' => array(
        'account_created' => 'Your account has been successfully created. Please check your email for the instructions on how to confirm your account.',
        'too_many_attempts' => 'Too many attempts. Try again in few minutes.',
        'wrong_credentials' => 'Incorrect username, email or password.',
        'not_confirmed' => 'Your account may not be confirmed. Check your email for the confirmation link',
        'confirmation' => 'Your account has been confirmed! You may now login.',
        'wrong_confirmation' => 'Wrong confirmation code.',
        'password_forgot' => 'The information regarding password reset was sent to your email.',
        'wrong_password_forgot' => 'User not found.',
        'password_reset' => 'Your password has been changed successfully.',
        'wrong_password_reset' => 'Invalid password. Try again',
        'wrong_token' => 'The password reset token is not valid.',
        'duplicated_credentials' => 'يرجى المحاولة مرة أخرى .. اسم المستخدم أو البريد الإلكتروني مسجل لدينا من قبل ',
    ),

    'email' => array(
        'account_confirmation' => array(
            'subject' => 'Account Confirmation',
            'greetings' => 'Hello :name',
            'body' => 'Please access the link below to confirm your account.',
            'farewell' => 'Regards',
        ),

        'password_reset' => array(
            'subject' => 'Password Reset',
            'greetings' => 'Hello :name',
            'body' => 'Access the following link to change your password',
            'farewell' => 'Regards',
        ),
    ),

);
