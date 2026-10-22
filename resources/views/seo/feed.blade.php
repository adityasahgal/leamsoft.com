{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>{{ config('seo.short_brand') }} blog</title>
        <link>{{ url('blog') }}</link>
        <atom:link href="{{ url('feed.xml') }}" rel="self" type="application/rss+xml"/>
        <description>AI, innovation and engineering from the team at {{ config('seo.brand') }}.</description>
        <language>en-in</language>
@if($posts->count())
        <lastBuildDate>{{ $posts->first()->updated_at?->toRfc2822String() }}</lastBuildDate>
@endif
@foreach($posts as $post)
        <item>
            <title>{{ $post->name }}</title>
            <link>{{ url('blog/' . $post->slug) }}</link>
            <guid isPermaLink="true">{{ url('blog/' . $post->slug) }}</guid>
            <pubDate>{{ $post->created_at?->toRfc2822String() }}</pubDate>
            <description>{{ \App\Support\Ui::excerpt($post->short_description ?? $post->description, 300) }}</description>
            <content:encoded><![CDATA[{!! str_replace(']]>', ']]]]><![CDATA[>', (string) $post->description) !!}]]></content:encoded>
@if(!empty($post->banner))
            <media:content url="{{ url('storage/' . $post->banner) }}" medium="image"/>
@endif
        </item>
@endforeach
    </channel>
</rss>
