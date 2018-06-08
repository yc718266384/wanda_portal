<div class="down welcome" <?= !$authOk ? 'style="display: none"' : '' ?>>
    <div class="wel_div user">
        <?php if ($authOkParams['user']): ?>
            <span class="user" set-lan="html:user">User </span>
            <span class="user" id="username"><?= $authOkParams['user'] ?></span>
        <?php endif; ?>
    </div>
    <div class="wel_div wel_title">
        <span set-lan="html:welcome">WELCOME BACK!</span>
    </div>
    <form action="" onsubmit="return false;">
        <div class="wel_div">
            <button type="button" id="member_already_auth" data-type="<?= $authOkType ?>"
                <?= $authOkType == 'member' ? " data-phone='{$authOkParams['user']}' data-card-no='{$authOkParams['cardNo']}'" : '' ?>
                    set-lan="html:agree">CONNECT
            </button>
        </div>
    </form>
    <?php if ($authOkType != 'vpass'): ?>
        <div class="wel_div">
            <a href="javascript:;" id="more_ways" set-lan="html:more_ways">CHANGE AUTHENTICATION >></a>
        </div>
    <?php endif; ?>
</div>