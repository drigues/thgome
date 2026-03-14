<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc>{{ url('/work') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ url('/about') }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/contact') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    @foreach($projects as $p)
    <url><loc>{{ url('/work/'.$p->slug) }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    @endforeach
    @foreach($posts as $p)
    <url><loc>{{ url('/blog/'.$p->slug) }}</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>
    @endforeach
</urlset>
