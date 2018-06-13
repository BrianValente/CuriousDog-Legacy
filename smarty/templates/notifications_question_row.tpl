{for $i=0 to (count($questions) - 1)}
    {assign var='user_from' value=$questions[$i]->getUserFrom()}
    {assign var='question'  value=$questions[$i]->getQuestionHtml()}
    {assign var='date'      value=$questions[$i]->getDateReadable()}
    {assign var='id'        value=$questions[$i]->getId()}
    <div class="question">
        <div class="question_header">
            {*<div class="question_header_actions">
                <a href="javascript:void(0)" class="question_header_action question_action_delete"></a>
            </div>*}
            {if $user_from !== null}
                <a href="{$siteUrl}{$user_from->getUsername()}">
                    <div class="question_header_picture" style="background-image: url({$user_from->getUserProfilePictureUrl()})"></div>
                </a>
            {else}
                <div class="question_header_picture"></div>
            {/if}
            <div class="question_header_content">
                {if $user_from !== null}
                    <a href="{$siteUrl}{$user_from->getUsername()}" class="question_header_user">{$user_from->getName()} <span class="question_header_user_username">@{$user_from->getUsername()}</span></a>
                {else}
                    <span class="question_header_user">Anónimo</span>
                {/if}
                <span class="question_header_content">{$question}</span>
            </div>
        </div>
        <div class="question_middle">
            <span class="question_bottom_time">{$date}
                {if $loggedUser->getGroup() === 1}
                    | {$questions[$i]->getIp()} | {$questions[$i]->getUseragent()}
                {/if}
            </span>
        </div>
        <div class="question_bottom">
            <span data-questionid="{$id}" class="question_bottom_reply_send float_right"></span>
            <div class="question_bottom_reply_textarea_container autosize">
                <textarea rows="1" id="textarea_question_{$id}" class="question_bottom_reply_textarea" placeholder="Escribe tu respuesta"></textarea>
            </div>
        </div>
    </div>
{/for}