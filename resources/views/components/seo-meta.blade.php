{{-- SEO Meta Tags Component --}}
@php
    $seo = app(\App\Services\SeoService::class)->generateSeoData($pageType ?? 'homepage', $additionalData ?? []);
@endphp

{{-- Meta Tags --}}
<title>{{ $seo['meta']['title'] }}</title>
<meta name="description" content="{{ $seo['meta']['description'] }}">
<meta name="keywords" content="{{ $seo['meta']['keywords'] }}">
<meta name="robots" content="{{ $seo['meta']['robots'] }}">
<meta name="author" content="{{ $seo['meta']['author'] }}">
<meta name="language" content="{{ $seo['meta']['language'] }}">

{{-- Geo Meta Tags --}}
<meta name="geo.region" content="{{ $seo['meta']['geo.region'] }}">
<meta name="geo.placename" content="{{ $seo['meta']['geo.placename'] }}">
<meta name="geo.position" content="{{ $seo['meta']['geo.position'] }}">
<meta name="ICBM" content="{{ $seo['meta']['ICBM'] }}">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $seo['canonicalUrl'] }}">

{{-- Open Graph Tags --}}
@foreach($seo['openGraph'] as $property => $content)
    @if(!empty($content))
        <meta property="{{ $property }}" content="{{ $content }}">
    @endif
@endforeach

{{-- Twitter Card Tags --}}
@foreach($seo['twitterCard'] as $name => $content)
    @if(!empty($content))
        <meta name="{{ $name }}" content="{{ $content }}">
    @endif
@endforeach

{{-- Structured Data --}}
@foreach($seo['structuredData'] as $index => $schema)
    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endforeach

{{-- Breadcrumb --}}
@isset($seo['breadcrumb'])
    <nav aria-label="breadcrumb" class="sr-only">
        <ol class="breadcrumb-list">
            @foreach($seo['breadcrumb'] as $breadcrumb)
                <li>
                    @if(!$loop->last)
                        <a href="{{ $breadcrumb['url'] ?? '#' }}">{{ $breadcrumb['name'] }}</a>
                    @else
                        <span>{{ $breadcrumb['name'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endisset