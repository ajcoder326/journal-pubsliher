<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Preview: {{ $emailTemplate->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-subject {
            background-color: #e9ecef;
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .email-subject strong {
            color: #495057;
        }
        .email-body {
            padding: 30px;
        }
        .preview-bar {
            background-color: #212529;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .preview-bar a {
            color: white;
            text-decoration: none;
        }
        .preview-bar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="preview-bar">
        <span><i class="fas fa-eye"></i> Email Preview Mode</span>
        <a href="{{ route('admin.email-templates.edit', $emailTemplate) }}">&larr; Back to Edit</a>
    </div>

    <div class="email-container">
        <div class="email-header">
            <h1>SHARE IJ</h1>
        </div>
        <div class="email-subject">
            <strong>Subject:</strong> {{ $subject }}
        </div>
        <div class="email-body">
            {!! $body !!}
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px; color: #6c757d; font-size: 12px;">
        <p>This is a preview with sample data. Actual emails will contain real information.</p>
        <p>Template: <strong>{{ $emailTemplate->name }}</strong></p>
    </div>
</body>
</html>