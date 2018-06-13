<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{$siteTitle}</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="{$siteUrl}css/reset.css" />
        <link rel="stylesheet" type="text/css" href="{$siteUrl}css/styles.css" />

        <meta name="description" content="{$siteMediaDescription}">

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@briannvalente" />
        <meta name="twitter:creator" content="@briannvalente" />
        <meta name="twitter:title" content="{$siteMediaTitle}" />
        <meta name="twitter:description" content="{$siteMediaDescription}" />
        <meta name="twitter:image" content="{$profileUserPictureUrl}" />

        <meta property="og:title" content="{$siteMediaTitle}">
        <meta property="og:description" content="{$siteMediaDescription}">
        <meta property="og:image" content="{$profileUserPictureUrl}">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

        <meta name="theme-color" content="{$colorBrowser}">

        <style>
            #profile_header {
                background-color: {$colorAccent};
                background-image: url({$profileUserHeaderUrl}) !important;
            }

            #profile_content #content_add {
                border-color: {$colorAccent} !important;
            }

            #content_add_bottombar_send {
                background-color: {$colorAccent} !important;
            }
        </style>
        <script async>var profileUserId = {$profileUserId}</script>
        <script async src="{$siteUrl}js/general.js.php"></script>
        <script async src="{$siteUrl}js/profile.js"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="main_container">
            <div id="profile_header" {if $translucentHeader}class="translucent"{/if}>
                <div id="profile_header_content">
                    <div id="profile_header_picture" style="background-image: url({$profileUserPictureUrl});"></div>
                    <div id="profile_header_container_titles">
                        <span id="profile_header_name">{$profileUserName}</span>
                        <span id="profile_header_description">{$profileUserDescription}</span>
                    </div>
                </div>
            </div>
            <div id="profile_content" class="content_panel">
                <h5>{$profileUserTitle}</h5>
                <div id="content_add">
                    <textarea rows="1" id="content_add_textarea" placeholder="¿...?"></textarea>
                    <div id="content_add_bottombar">
                        <a href="javascript:void(0)" id="content_add_bottombar_send">Preguntar anónimamente</a>
                    </div>
                </div>
                <div id="content_questions">
                    {for $i=0 to (count($profileUserAnsweredQuestions) - 1)}
                        {include file='question_row.tpl' question=$profileUserAnsweredQuestions[$i]}
                    {/for}
                </div>
            </div>
        </div>
    </body>
</html>