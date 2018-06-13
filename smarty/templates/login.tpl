<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{$siteTitle}</title>

        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/styles.css" />

        <meta charset="UTF-8" />
        <meta name="description"         content="{$siteMediaDescription}">
        <meta name="twitter:card"        content="summary" />
        <meta name="twitter:site"        content="@briannvalente" />
        <meta name="twitter:title"       content="{$siteMediaTitle}" />
        <meta name="twitter:description" content="{$siteMediaDescription}" />
        <meta property="og:title"        content="{$siteMediaTitle}">
        <meta property="og:description"  content="{$siteMediaDescription}">
        <meta name="viewport"            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color"         content="{$colorBrowser}">

        {if $safariToolbarColoring}
            <style>
                body {
                    padding-top: 100px;
                    background: -webkit-linear-gradient(top, {$colorAccent} 100px, #eee 100px);
                    overflow: hidden;
                }
            </style>
        {/if}
    </head>
    <body>
    {if $safariToolbarColoring}
        <div style="height: 100vh; overflow: scroll; position: relative;">
            {/if}
            {include file='header.tpl'}
            <div id="login_content">

            </div>
            {if $safariToolbarColoring}
        </div>
        <script>
            document.body.scrollTo(1000,1000);
        </script>
    {/if}
    </body>
</html>