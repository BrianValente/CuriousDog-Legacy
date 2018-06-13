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
        <script async src="js/home.js?5"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="content">
            <div class="content_panel float_left" id="home_content_panel_account">
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
            <div class="content_panel autosize" id="feed_panel">
                <div class="content_panel_header">
                    <span class="content_panel_header_title">Últimos posts</span>
                </div>
                {for $i=0 to (count($latestPosts) - 1)}
                    {include file='question_row.tpl' question=$latestPosts[$i]}
                {/for}
            </div>
        </div>
    </body>
</html>