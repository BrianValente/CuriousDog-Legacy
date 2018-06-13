<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="html-header.tpl"}

        <style>
            input[type="text"]:focus,
            input[type="password"]:focus {
                border-color: {$colorAccent} !important;
                box-shadow: {$colorAccent} 0 0 3px -1px;
            }

            {if $isLogged}
                #panel_account_header_image {
                    background-image: url({$userHeaderUrl});
                    background-color: {$colorAccent};
                }
            {/if}
        </style>

        <script async src="js/general.js.php"></script>
        <script async src="js/home.js"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="content">
            <div class="float_left" style="width: 250px; margin-right: 20px;">
                <div class="content_panel" id="home_content_panel_account">
                    {if $isLogged}
                        <div id="panel_account">
                            <div id="panel_account_header_image"></div>
                            <a href="{$siteUrl}{$username}" id="panel_account_picture" style="background-image: url({$userPictureUrl});"></a>
                        </div>
                    {else}
                        <div class="panel_account_section" id="panel_account_description">
                            {$siteDescriptionLong}
                        </div>
                        <div class="panel_account_section" id="panel_account_login">
                            <span class="panel_account_title">Iniciar sesión</span>
                            <div class="panel_account_content">
                                <input class="input" placeholder="Usuario o correo electrónico" id="login_username" autocomplete="username" type="text" />
                                    <div>
                                        <span class="button" id="login_button">Ingresar</span>
                                        <div class="autosize">
                                            <input class="input" placeholder="Contraseña" id="login_password" autocomplete="current-password" type="password" />
                                        </div>
                                    </div>
                                <a href="{$siteUrl}/social/ConnectToTwitter.php" id="panel_account_login_twitter" class="button icon">Ingresar con Twitter</a>
                            </div>
                        </div>
                        <div class="panel_account_section">
                            <span class="panel_account_title">Registrarme usando</span>
                            <div class="panel_account_content_centered">
                                <span id="panel_account_register_email" class="button icon disable">Correo</span>
                                <a href="{$siteUrl}/social/ConnectToTwitter.php" id="panel_account_register_twitter" class="button icon">Twitter</a>
                            </div>
                        </div>
                    {/if}
                </div>
                <div class="content_panel" style="margin-top: 20px;">
                    <a href="brianvalente" style="display: flex;align-items: center;padding: 10px 15px;cursor: pointer;text-decoration: none;">
                        <div style="background-image: url(https://ask.brianvalente.tk/uploads/profile/picture/brianvalente_1495936513833.jpg);background-size: cover;width: 56px;height: 56px;border-radius: 100%;"></div>
                        <div style="flex: 1;box-sizing: border-box;padding-left: 10px;">
                            <span style="display: block; font-size: 14px; color:black;">Brian 🥖</span>
                            <span style="padding-top:5px;font-size: 12px;word-wrap: break-word;text-overflow: ellipsis; height: 12px;display: inline-block;overflow: hidden; color:black;">
                                18 años. Developer. Twitter @briannvalente
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="content_panel autosize" id="feed_panel">
                <div class="content_panel_header">
                    <span class="content_panel_header_title">Últimos posts</span>
                </div>
                {for $i=0 to (count($latestPosts) - 1)}
                    <div class="question">
                        <div class="question_header">
                            <a href="{$siteUrl}{$latestPosts[$i]['user_to_array']['username']}">
                                <div class="question_header_picture" style="background-image: url({$latestPosts[$i]['user_to_array']['picture_url']});"></div>
                            </a>
                            <div class="question_header_content">
                                <a href="{$siteUrl}{$latestPosts[$i]['user_to_array']['username']}" class="question_header_user">{$latestPosts[$i]['user_to_array']['name']}
                                    <span class="question_header_user_username">@{$latestPosts[$i]['user_to_array']['username']}</span>
                                </a>
                                <span class="question_header_content">{$latestPosts[$i]['answer']}</span>
                            </div>
                        </div>
                        <div class="question_middle">
                            {if !isset($latestPosts[$i]['user_from_array'])}
                                <span class="question_middle_content">Preguntado por un usuario anónimo: <span class="question_middle_question">{$latestPosts[$i]['question']}</span></span>
                            {else}
                                <span class="question_middle_content">Preguntado por <a href="{$siteUrl}{$latestPosts[$i]['user_from_array']['username']}" class="question_middle_user">{$latestPosts[$i]['user_from_array']['name']} <span class="question_middle_user_username">@{$latestPosts[$i]['user_from_array']['username']}</span></a>: <span class="question_middle_question">{$latestPosts[$i]['question']}</span></span>
                            {/if}
                        </div>
                        <div class="question_bottom">
                            <span class="question_bottom_time">{$latestPosts[$i]['date_ago']}</span>
                        </div>
                    </div>
                {/for}
                <!--
                <span style="display:block; padding:50px 0; color:#ccc; font-size:48px; text-align: center;">Disponible pronto</span>
                -->
            </div>
        </div>
    </body>
</html>