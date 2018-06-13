<header id="main_header" {if $translucentHeader}class="translucent"{/if}>
    <div id="main_header_logo">
        <a href="{$siteUrl}" style="display: inline-block; white-space: nowrap; color: white; text-decoration: none; font-weight: bold;">
            Curious Dog
        </a>
    </div>
    <div id="main_header_search">
        <div id="main_header_search_content">
            <span id="main_header_search_content_icon"></span>
            <input id="main_header_search_input" placeholder="Buscar">
        </div>
    </div>
    <div id="main_header_navigation">
        {if $isLogged}
            <div id="main_header_navigation_logged_in">
                <!--<a href="{$siteUrl}" class="main_header_button_icon" id="main_header_navigation_home"></a>
                <a href="javascript:void(0)" class="main_header_button_icon" id="main_header_navigation_messages"></a>-->
                <a href="{$siteUrl}notifications" class="main_header_button_icon" id="main_header_navigation_notifications"></a>
                <div id="main_header_navigation_profile" style="background-image: url({$userPictureUrl});"></div>
            </div>
        {else}
            <div id="main_header_navigation_logged_out">
                <a href="{$siteUrl}social/ConnectToTwitter.php" class="main_header_button" id="main_header_login">Ingresar</a>
                <a href="{$siteUrl}social/ConnectToTwitter.php" class="main_header_button">Registrarme</a>
            </div>
        {/if}
    </div>
    {if $isLogged}
        <div id="main_header_profile_menu_container">
            <div id="main_header_profile_menu">
                <a href="{$siteUrl}{$username}">Mi perfil</a>
                <a href="{$siteUrl}settings">Configuración</a>
                <a href="javascript:void(0)" id="main_header_profile_menu_logout">Cerrar sesión</a>
            </div>
        </div>
    {/if}
</header>
