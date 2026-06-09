<div class="container">
    <h1>User overview</h1>

    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
            This is a simple user overview. It shows all users in the system, their id, username and avatar (if they have one). You can also click on the "Messages" link to chat with that user.
            or simply click on "New Group" to create a new group and chat with multiple users at the same time.
        </div>

        <!-- New Group Form -->
        <form action="<?= Config::get('URL'); ?>Messenger/createGroupChat" method="post">
            <input type="text" name="group_name" placeholder="Enter group name">
            <button type="submit">New Group</button>
        </form>

        <div>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>Chat With User</td>
                    <td>new Messages</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>"/>
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'Messenger/showMessages/' . $user->user_id ?>">
                                Messages
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php foreach ($this->groups ?? [] as $group) { ?>
    <tr class="active">
        <td><?= $group->group_id; ?></td>
        <td><?= $group->name; ?></td>
        <?php if ($group->is_group) { ?>
            <td>
                <a href="<?= Config::get('URL') . 'Messenger/showGroupMessages/' . $group->group_id ?>">
                    Messages
                </a>
                </td>
                    <?php } else { ?>
                        <td>
                            <a href="<?= Config::get('URL') . 'Messenger/showMessages/' . $group->user_id ?>">
                                Messages
                            </a>
                        </td>
                    <?php } ?>
                    <?php $newMessages = MessageModel::getNewMessages($group->group_id); ?>
                    <?php if (!empty($newMessages)) { ?>
                        <td style="background-color: red; color: white; font-weight: bold;">
                            <?= count($newMessages) ?> new
                        </td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>