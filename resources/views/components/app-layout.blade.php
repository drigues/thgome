<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? '' }} {{ isset($metaTitle) && $metaTitle ? '—' : '' }} {{ \App\Models\Setting::get('site_name', 'Thiago Rodrigues') }} {{ \App\Models\Setting::get('seo_title_suffix', '· Product Designer') }}</title>
    <meta name="description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description', '') }}">
    <meta property="og:title" content="{{ $metaTitle ?? \App\Models\Setting::get('site_name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description') }}">
    @isset($metaImage)<meta property="og:image" content="{{ $metaImage }}">@endisset
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    @if(\App\Models\Setting::get('google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('google_analytics_id') }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config','{{ \App\Models\Setting::get('google_analytics_id') }}');</script>
    @endif

    @isset($schemaOrg)
    <script type="application/ld+json">{!! json_encode($schemaOrg) !!}</script>
    @endisset
</head>
<body class="bg-[var(--color-bg)] text-[var(--color-text)] antialiased">
    @include('partials.nav')
    <main id="main-content">
        {{ $slot }}
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>
