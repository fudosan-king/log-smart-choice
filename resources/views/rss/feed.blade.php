<?php
echo '<?xml version="1.0" encoding="UTF-8"?>'
?>
<rss version="2.0"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  >

  <channel>
    <title>Order Renove</title>
    <atom:link href="https://order-renove.jp/feed" rel="self" type="application/rss+xml" />
    <link>https://order-renove.jp/feed</link>
    <description>Feed</description>
    <lastBuildDate>{{ now() }}</lastBuildDate>
    <language>ja</language>
    <sy:updatePeriod>hourly</sy:updatePeriod>
    <sy:updateFrequency>1</sy:updateFrequency>
    <generator>Order Renove</generator>

    @foreach($posts as $post)
      <item>
        <title>{{ $post->title }}</title>
        <link>{{ $post->slug }}</link>
        <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
        <dc:creator>{{ $post->user  }}</dc:creator>
        <category>{{ $post->category }}</category>
        <guid isPermaLink="false">{{ $post->id }}</guid>
        <description><![CDATA[{!! $post->body !!}]]></description>
        <content:encoded><![CDATA[{!! $post->body !!}]]></content:encoded>
        <enclosure url="{!! $post->photo_first !!}" type="image/jpeg" />
      </item>
    @endforeach

  </channel>
</rss>