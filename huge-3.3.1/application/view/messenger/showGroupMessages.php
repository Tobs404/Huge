<div class="container">
    <h1>Messages</h1>
    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <!-- Invite Users Section -->
        <form action="<?= Config::get('URL'); ?>messenger/inviteUser" method="post">
            <div style="text-align: center;">
                <input type="text" name="ID" placeholder="User ID to invite">
                <input type="hidden" name="group_id" value="<?= $this->groupID ?>">
                <button type="submit">Invite</button>
            </div>
        </form>

        <section class="discussion">
            <?php if (!empty($this->messages)) { ?>
                <?php foreach ($this->messages as $msg) { ?>
                    <?php if ($msg->owner_id == Session::get('user_id')) { ?>
                        <div class="bubble recipient first">
                            <?= htmlspecialchars($msg->message_content) ?>
                        </div>
                    <?php } else { ?>
                        <div class="bubble sender first">
                            <?= htmlspecialchars($msg->message_content) ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <div>No messages yet</div>
            <?php } ?>
        </section>

        <form action="<?= Config::get('URL'); ?>messenger/insertGroupMessage" method="post">
            <div style="text-align: center;">
                <input name="message" type="text" placeholder="Enter text here">
                <input type="hidden" name="groupID" value="<?= $this->groupID ?>">
                <button type="submit">Send</button>
            </div>
        </form>

    </div>
</div>