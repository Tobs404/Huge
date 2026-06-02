<div class="container">
    <h1>Messages</h1>
    <div class="box">

        <?php extract($data); ?>
        <?php $this->renderFeedbackMessages(); ?>
        
        <section class="discussion">
            <?php
            if (!empty($messages)) {
                foreach ($messages as $msg) {
                    if ($msg->owner_id == Session::get('user_id')) {
                        echo '<div class="bubble recipient first">'
                            . htmlspecialchars($msg->message_content)
                            . '</div>';
                    } else {
                        echo '<div class="bubble sender first">'
                            . htmlspecialchars($msg->message_content)
                            . '</div>';
                    }
                }
            } else {
                echo '<div>No messages yet</div>';
            }
            ?>
        </section>

        <form action="<?= Config::get('URL'); ?>messenger/insertMessage" method="post">
            <div style="text-align: center;">
                <input name="message" type="text" placeholder="Enter text here">
                <input type="hidden" name="groupID" value="<?= $groupID ?>">
                <button type="submit">Send</button>
            </div>
        </form>

    </div>
</div>