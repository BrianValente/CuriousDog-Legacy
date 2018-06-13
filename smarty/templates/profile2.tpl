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
                background-image:url({$profileUserHeaderUrl}) !important;
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
                    <img id="profile_header_picture" src="{$profileUserPictureUrl}" />
                    <div id="profile_header_container_titles">
                        <span id="profile_header_name">{$profileUserName}</span>
                        <span id="profile_header_description">{$profileUserDescription}</span>
                    </div>
                </div>
            </div>
            <div id="profile_container">
                <div id="profile_info" class="content_panel float_left">
                    sdjsdljglkdfsj
                </div>
                <div id="profile_content" class="content_panel autosize">
                    <h5>{$profileUserTitle}</h5>
                    <div id="content_add">
                        <textarea rows="1" id="content_add_textarea" placeholder="¿...?"></textarea>
                        <div id="content_add_bottombar">
                            <a href="javascript:void(0)" id="content_add_bottombar_send">Preguntar anónimamente</a>
                        </div>
                    </div>
                    <div id="content_questions">
                        {for $i=0 to (count($profileUserAnsweredQuestions) - 1)}
                            <div class="question">
                                <div class="question_header">
                                    <a href="{$siteUrl}{$profileUserAnsweredQuestions[$i]['user_to_array']['username']}">
                                        <div class="question_header_picture" style="background-image: url({$profileUserAnsweredQuestions[$i]['user_to_array']['picture_url']});"></div>
                                    </a>
                                    <div class="question_header_content">
                                        <a href="{$siteUrl}{$profileUserAnsweredQuestions[$i]['user_to_array']['username']}" class="question_header_user">{$profileUserAnsweredQuestions[$i]['user_to_array']['name']}
                                            <span class="question_header_user_username">@{$profileUserAnsweredQuestions[$i]['user_to_array']['username']}</span>
                                        </a>
                                        <span class="question_header_content">{$profileUserAnsweredQuestions[$i]['answer']}</span>
                                    </div>
                                </div>
                                <div class="question_middle">
                                    {if !isset($profileUserAnsweredQuestions[$i]['user_from_array'])}
                                        <span class="question_middle_content">Preguntado por un usuario anónimo: <span class="question_middle_question">{$profileUserAnsweredQuestions[$i]['question']}</span></span>
                                    {else}
                                        <span class="question_middle_content">Preguntado por <a href="{$siteUrl}{$profileUserAnsweredQuestions[$i]['user_from_array']['username']}" class="question_middle_user">{$profileUserAnsweredQuestions[$i]['user_from_array']['name']} <span class="question_middle_user_username">@{$profileUserAnsweredQuestions[$i]['user_from_array']['username']}</span></a>: <span class="question_middle_question">{$profileUserAnsweredQuestions[$i]['question']}</span></span>
                                    {/if}
                                </div>
                                <div class="question_bottom">
                                    <span class="question_bottom_time">{$profileUserAnsweredQuestions[$i]['date_ago']}</span>
                                </div>
                            </div>
                        {/for}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>