<?php

/**
 * Class CaptchaModel
 *
 * This model class handles all the captcha stuff.
 * Currently this uses the excellent Captcha generator lib from https://github.com/Gregwar/Captcha
 * Have a look there for more options etc.
 */
class MessageModel
{
    static function insertMessage($message, $group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $date = date('Y-m-d H:i:s');
        $ownerID = Session::get('user_id');

        $sql = "INSERT INTO messages (owner_id, message_content, date, is_read, group_id) VALUES (:owner, :message, :date, :is_read , :group_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':owner' => $ownerID, ':message' => $message, ':date' => $date, ':is_read' => 0, 'group_id' => $group_id));
    }

    static function createGroup($user1, $user2, $name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        // 1. Check if group already exists between these 2 users
        $sql = "
            SELECT gm1.group_id
            FROM user_groups gm1
            JOIN user_groups gm2 ON gm1.group_id = gm2.group_id
            WHERE gm1.user_id = :user1
            AND gm2.user_id = :user2
            LIMIT 1
            ";

        $query = $database->prepare($sql);
        $query->execute([
            ':user1' => $user1,
            ':user2' => $user2
        ]);

        $existing = $query->fetch();

        // 2. If found → return it
        if ($existing) {
            return $existing->group_id;
        }

        // 3. Otherwise create new group
        $sql = "INSERT INTO groups (name) VALUES (:name)";
        $query = $database->prepare($sql);

        $query->execute([
            ':name' => $name
        ]);

        $group_id = $database->lastInsertId();

        MessageModel::assignToGroup($user1, $group_id);
        MessageModel::assignToGroup($user2, $group_id);

        return $group_id;
    }

    static function getMessages($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            SELECT *
            FROM messages
            WHERE group_id = :group_id
            ORDER BY date ASC
        ";

        $query = $database->prepare($sql);
        $query->execute([
            ':group_id' => $group_id
        ]);

        return $query->fetchAll();
    }
    
    static function assignToGroup($userID, $groupID)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        // Check if already assigned
        $sql = "SELECT * FROM user_groups WHERE user_id = :userID AND group_id = :groupID";
        $query = $database->prepare($sql);
        $query->execute([':userID' => $userID, ':groupID' => $groupID]);

        if ($query->fetch()) {
            return; // already in group, do nothing
        }

        // Only insert if not already assigned
        $sql = "INSERT INTO user_groups (user_id, group_id) VALUES (:userID, :groupID)";
        $query = $database->prepare($sql);
        $query->execute([':userID' => $userID, ':groupID' => $groupID]);
    }
}
