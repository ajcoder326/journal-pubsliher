<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e3a5f, #3498db); color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .btn { display: inline-block; padding: 10px 20px; background: #1e3a5f; color: white; text-decoration: none; border-radius: 5px; }
        .paper-info { background: #fff; padding: 15px; border-left: 4px solid #3498db; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SIJSEMSS</h1>
            <p>Review Request</p>
        </div>
        <div class="content">
            <p>Dear {{ $reviewer->name }},</p>
            
            <p>You have been assigned to review a paper submitted to SIJSEMSS.</p>
            
            <div class="paper-info">
                <h3>{{ $paper->title }}</h3>
                <p><strong>Authors:</strong> {{ $paper->authors }}</p>
                @if($paper->keywords)
                    <p><strong>Keywords:</strong> {{ $paper->keywords }}</p>
                @endif
            </div>
            
            <h4>Abstract:</h4>
            <p>{{ Str::limit($paper->abstract, 400) }}</p>
            
            <p>Please complete your review within the next 2 weeks.</p>
            
            <p style="margin-top: 20px;">
                <a href="{{ url('/dashboard/reviews') }}" class="btn">Submit Review</a>
            </p>
        </div>
        <div class="footer">
            <p> {{ date('Y') }} SIJSEMSS. All rights reserved.</p>
        </div>
    </div>
</body>
</html>