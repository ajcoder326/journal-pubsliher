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
        .status { display: inline-block; padding: 5px 10px; border-radius: 3px; font-weight: bold; }
        .status-pending { background: #ffc107; color: #000; }
        .status-under_review { background: #17a2b8; color: #fff; }
        .status-accepted { background: #28a745; color: #fff; }
        .status-rejected { background: #dc3545; color: #fff; }
        .status-published { background: #28a745; color: #fff; }
        .status-revision_required { background: #fd7e14; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SHARE IJ</h1>
            <p>Paper Status Update</p>
        </div>
        <div class="content">
            <p>Dear {{ $paper->user->name }},</p>
            
            <p>The status of your paper has been updated.</p>
            
            <h3>{{ $paper->title }}</h3>
            
            <p>
                <strong>Previous Status:</strong> 
                <span class="status status-{{ $oldStatus }}">{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</span>
            </p>
            <p>
                <strong>New Status:</strong> 
                <span class="status status-{{ $newStatus }}">{{ ucfirst(str_replace('_', ' ', $newStatus)) }}</span>
            </p>
            
            @if($newStatus === 'accepted')
                <p>Congratulations! Your paper has been accepted for publication.</p>
            @elseif($newStatus === 'revision_required')
                <p>Please review the feedback and submit a revised version of your paper.</p>
            @elseif($newStatus === 'published')
                <p>Your paper is now published and available in our journal.</p>
            @elseif($newStatus === 'rejected')
                <p>We regret to inform you that your paper was not accepted. Please review the feedback for future submissions.</p>
            @endif
            
            <p style="margin-top: 20px;">
                <a href="{{ url('/dashboard') }}" class="btn">View Dashboard</a>
            </p>
        </div>
        <div class="footer">
            <p> {{ date('Y') }} SHARE IJ. All rights reserved.</p>
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>