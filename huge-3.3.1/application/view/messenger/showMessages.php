<div class="container">
    <h1>Messages</h1>

    <div class="box">

        <?php extract($data); ?>
        <?php $this->renderFeedbackMessages(); ?>
        <section class="discussion">

            <?php if (!empty($messages)) { ?>
                <?php foreach ($messages as $msg) { ?>
                    <div class="bubble sender">
                        <?= htmlspecialchars($msg->message_content) ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div>No messages yet</div>
            <?php } ?>

        </section>

         <form action="<?= config::get("URL"); ?>messenger/insertMessage" method="post">
                <div style="text-align: center;">
                    <input name="message" type="text" placeholder="Enter text here">
                    <input type="hidden" name="groupID" value="<?= $groupID ?>">
                </div>
        </form>

    </div>
</div>