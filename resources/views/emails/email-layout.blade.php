<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #0066CC 0%, #004499 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .email-header p {
            margin: 5px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body h2 {
            color: #0066CC;
            font-size: 20px;
            margin-top: 0;
        }
        .email-body h3 {
            color: #333;
            font-size: 16px;
            margin-top: 20px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #0066CC;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #0066CC;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #0066CC;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background: #0052a3;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #3b82f6; color: white; }
        .status-verified { background: #06b6d4; color: white; }
        .status-approved { background: #10b981; color: white; }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }
        table th {
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🏛️ iLab UNMUL</h1>
            <p>Pusat Unggulan Studi Tropis - Integrated Laboratory Management System</p>
        </div>

        <div class="email-body">
            @yield('content')
        </div>

        <div class="email-footer">
            <p><strong>Universitas Mulawarman</strong></p>
            <p>Laboratorium Terpadu FMIPA</p>
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p style="margin-top: 15px;">
                <a href="{{ config('app.url') }}">Kunjungi Website</a> |
                <a href="mailto:ilab@unmul.ac.id">Hubungi Kami</a>
            </p>
        </div>
    </div>
</body>
</html>
