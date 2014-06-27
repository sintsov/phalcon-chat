<div class="trpChatItemContainer read cantEdit isOld">
    <div class="trpChatItem view">
        <div class="trpChatAvatar">
            <div class="trpDisplayPicture avatar" style="background-image: url('{{ message.users.getUserAvatar() }}')" data-original-title="{{ message.users.name }}"></div>
        </div>
        <div class="trpChatBox ">
            <div class="trpChatDetails">
                <div class="trpChatFrom">{{ message.users.name }}</div>
                <div class="trpChatTime">&nbsp;&bull;&nbsp;<span><span title="" data-original-title="{{ message.getUserCreatedAt() }}">{{ message.getUserCreateAtAgo() }}</span></span></div>
                <div class="trpChatEdit" data-original-title="" title=""></div>
            </div>
            <div class="trpChatText">{{ message.message }}</div>
        </div>
    </div>
</div>
