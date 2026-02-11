<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publication Certificate</title>
    <style>
        @page { margin: 30px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #1a1a2e; }
        .certificate {
            border: 6px solid #0d2b4e;
            padding: 24px;
            height: 100%;
            position: relative;
        }
        .header { text-align: center; margin-bottom: 18px; }
        .logo { max-height: 70px; margin-bottom: 10px; }
        .title { font-size: 28px; font-weight: 700; letter-spacing: 1px; color: #0d2b4e; }
        .subtitle { font-size: 14px; color: #1a1a2e; margin-top: 6px; }
        .content { text-align: center; margin-top: 28px; }
        .name { font-size: 24px; font-weight: 700; margin: 12px 0; }
        .paper { font-size: 18px; margin: 10px 0; }
        .meta { margin-top: 16px; font-size: 12px; color: #555; }
        .signature { margin-top: 28px; text-align: right; font-size: 12px; }
        .line { display: inline-block; border-top: 1px solid #333; width: 200px; margin-top: 6px; }
        .footer { position: absolute; bottom: 18px; left: 24px; right: 24px; font-size: 11px; color: #555; text-align: center; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            @if(file_exists(public_path('images/share-ij-logo.png')))
                <img src="{{ public_path('images/share-ij-logo.png') }}" alt="SHARE IJ" class="logo">
            @endif
            <div class="title">Certificate of Publication</div>
            <div class="subtitle">Share International Journal of Sustainable Engineering, Management &amp; Social Sciences</div>
        </div>

        <div class="content">
            <div>This is to certify that</div>
            <div class="name">{{ $author->name }}</div>
            <div>has successfully published the paper titled</div>
            <div class="paper"><strong>{{ $paper->title }}</strong></div>
            <div>in SHARE IJ.</div>

            <div class="meta">
                <div>Published Date: {{ $paper->published_at ? $paper->published_at->format('F d, Y') : $paper->created_at->format('F d, Y') }}</div>
                @if($paper->doi)
                    <div>DOI: https://doi.org/{{ $paper->doi }}</div>
                @endif
                <div>Certificate ID: SHAREIJ-{{ str_pad((string) $paper->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <div class="signature">
            <div class="line"></div>
            <div>Editor-in-Chief</div>
        </div>

        <div class="footer">This certificate is generated electronically and is valid without a signature.</div>
    </div>
</body>
</html>
