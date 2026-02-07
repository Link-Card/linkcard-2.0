<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2C2A27;
            margin: 0;
            padding: 0;
            background-color: #F7F8F4;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .email-header {
            text-align: center;
            padding: 32px 0 24px;
        }
        .email-header img {
            height: 28px;
            width: auto;
        }
        .email-body {
            background-color: #FFFFFF;
            border-radius: 12px;
            padding: 40px 32px;
            border: 1px solid #E5E7EB;
        }
        .email-title {
            font-size: 22px;
            font-weight: 600;
            color: #2C2A27;
            margin: 0 0 8px 0;
        }
        .email-subtitle {
            font-size: 14px;
            color: #4B5563;
            margin: 0 0 24px 0;
        }
        .email-text {
            font-size: 14px;
            color: #4B5563;
            margin: 0 0 16px 0;
        }
        .email-btn {
            display: inline-block;
            background-color: #42B574;
            color: #FFFFFF !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin: 8px 0 24px;
        }
        .email-btn:hover {
            background-color: #3DA367;
        }
        .email-btn-secondary {
            display: inline-block;
            background-color: transparent;
            color: #2C2A27 !important;
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            border: 1.5px solid #D1D5DB;
        }
        .info-box {
            background-color: #F0F9F4;
            border-radius: 8px;
            padding: 20px 24px;
            margin: 20px 0;
        }
        .info-box-blue {
            background-color: #EFF6FF;
            border-radius: 8px;
            padding: 20px 24px;
            margin: 20px 0;
        }
        .info-label {
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px 0;
        }
        .info-value {
            font-size: 14px;
            color: #2C2A27;
            font-weight: 500;
            margin: 0 0 12px 0;
        }
        .info-value:last-child {
            margin-bottom: 0;
        }
        .divider {
            border: none;
            border-top: 1px solid #E5E7EB;
            margin: 24px 0;
        }
        .email-footer {
            text-align: center;
            padding: 24px 0;
            color: #9CA3AF;
            font-size: 12px;
        }
        .email-footer a {
            color: #42B574;
            text-decoration: none;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-green {
            background-color: #F0F9F4;
            color: #42B574;
        }
        .badge-blue {
            background-color: #EFF6FF;
            color: #4A7FBF;
        }
        .badge-orange {
            background-color: #FEF3C7;
            color: #D97706;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header --}}
        <div class="email-header">
            <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card">
        </div>

        {{-- Body --}}
        <div class="email-body">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Link-Card &middot; <a href="{{ url('/') }}">linkcard.ca</a></p>
            <p style="margin-top: 8px;">Transformez chaque rencontre en connexion durable.</p>
        </div>
    </div>
</body>
</html>
