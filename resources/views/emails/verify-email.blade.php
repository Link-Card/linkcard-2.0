<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .button {
            display: inline-block;
            background-color: #4F46E5;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenue sur Link-Card!</h1>
    </div>
    
    <div class="content">
        <p>Bonjour {{ $user->name }},</p>
        
        <p>Merci de vous être inscrit sur Link-Card! Pour compléter votre inscription, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous:</p>
        
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">
                Vérifier mon email
            </a>
        </div>
        
        <p>Ce lien expirera dans 60 minutes.</p>
        
        <p>Si vous n'avez pas créé de compte sur Link-Card, vous pouvez ignorer cet email.</p>
        
        <p>Cordialement,<br>L'équipe Link-Card</p>
    </div>
    
    <div class="footer">
        <p>Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur:</p>
        <p style="word-break: break-all; color: #4F46E5;">{{ $verificationUrl }}</p>
    </div>
</body>
</html>
