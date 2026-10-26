<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000">
    <meta name="description" content="جاب‌ویژن">
    <title>جاب‌ویژن</title>
    @php
        $manifestPath = public_path('asset-manifest.json');
        $manifest = file_exists($manifestPath)
            ? json_decode(file_get_contents($manifestPath), true)
            : null;
        $files = $manifest['files'] ?? [];
        $css = $files['main.css'] ?? null;
        $js = $files['main.js'] ?? null;
    @endphp
    @if ($css)
        <link href="{{ $css }}" rel="stylesheet">
    @endif
</head>
<body>
    <noscript>برای اجرای این برنامه باید JavaScript فعال باشد.</noscript>
    <div id="root"></div>
    @if ($js)
        <script src="{{ $js }}" defer></script>
    @endif
</body>
</html>
