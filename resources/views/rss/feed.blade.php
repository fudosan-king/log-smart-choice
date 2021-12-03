<?php
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
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
        <title><![CDATA[ Order Renove ]]></title>
        <link><![CDATA[ http://order-renove.jp/feed ]]></link>
        <description><![CDATA[ Feed ]]></description>
        <language>ja</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>{{ $post->slug }}</link>
                <description><![CDATA[{!! $post->body !!}]]></description>
                <category>{{ $post->category }}</category>
                <author><![CDATA[{{ $post->user  }}]]></author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>