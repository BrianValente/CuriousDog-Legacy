<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="html-header.tpl"}

        <style>
            .settings_tab {
                border-color: {$colorAccent} !important;
            }

            input[type="text"]:focus,
            input[type="password"]:focus {
                border-color: {$colorAccent} !important;
                box-shadow: {$colorAccent} 0 0 3px -1px;
            }

            #settings_personalinfo_save {
                background-color: {$colorAccent} !important;
                border: none;
            }
        </style>

        <script async src="js/general.js.php"></script>
        <script async src="js/settings.js"></script>
    </head>
    <body>
        {include file='header.tpl'}
        <div id="settings_content">
            <div id="settings_tabs" style="display: none;">
                <span class="settings_tab active" data-section="settings_personalinfo">Personal Info</span>
                <span class="settings_tab" data-section="settings_profile">Profile</span>
                <span class="settings_tab" data-section="settings_password">Password</span>
                <span class="settings_tab" data-section="settings_twitter">Twitter</span>
            </div>
            <div class="settings_section enable" id="settings_personalinfo">
                <div id="settings_personalinfo_header">
                    <div id="settings_personalinfo_profile_picture_container">
                        <span id="settings_personalinfo_profile_picture_uploading">Uploading</span>
                        <input type="file" id="settings_personalinfo_profile_picture_input" accept="image/*"/>
                        <div id="settings_personalinfo_profile_picture" style="background-image:url({$userPictureUrl})"></div>
                        <span id="settings_personalinfo_profile_picture_edit">Edit</span>
                    </div>
                    <div id="settings_personalinfo_header_data">
                        <div id="settings_personalinfo_header_data_container">
                            <span id="settings_personalinfo_name" contenteditable>{$loggedUser->getName()}</span>
                            <br />
                            <span id="settings_personalinfo_description" contenteditable>{$loggedUser->getProfileDescription()}</span>
                        </div>
                    </div>
                </div>
                <div id="settings_personalinfo_content">
                    <div class="settings_input">
                        <span class="settings_input_title">Email address</span>
                        <input class="input settings_input_input" id="settings_personalinfo_email" type="text" value="{$loggedUser->getEmailAddress()}" />
                    </div>
                    <div class="settings_input">
                        <span class="settings_input_title">Date of birth</span>
                        <input class="input settings_input_input" type="text" value="{$loggedUser->getBirthDate()}" disabled />
                    </div>
                    <div class="settings_input">
                        <span class="settings_input_title">Username</span>
                        <input class="input settings_input_input" id="settings_personalinfo_username" type="text" value="{$loggedUser->getUsername()}" />
                    </div>
                    <div class="settings_input">
                        <span class="settings_input_title">Time zone</span>
                        <input class="input settings_input_input" type="text" value="GMT -3 | Buenos Aires" disabled />
                    </div>
                </div>
                <span class="button" id="settings_personalinfo_save">Save changes</span>
            </div>
            <div class="settings_section" id="settings_profile">
                <span>profile</span>
            </div>
            <div class="settings_section" id="settings_password">
                <span>password</span>
            </div>
            <div class="settings_section" id="settings_twitter">
                {if isset($twitter_account)}
                    {$twitter_account->name}
                {else}
                    No hay ninguna cuenta de Twitter enlazada. Para enlazar una cuenta <a href="http://ask.brianvalente.tk/social/ConnectToTwitter.php">haz click aquí.</a>
                {/if}
            </div>
        </div>
    </body>
</html>