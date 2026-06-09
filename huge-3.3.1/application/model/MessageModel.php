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

        $sql = "CALL insertMessage(:owner, :message, :date, :is_read, :group_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':owner' => $ownerID, ':message' => $message, ':date' => $date, ':is_read' => 0, ':group_id' => $group_id));
    }

    static function createGroup($user1, $user2, $name, $isGroupChat)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL returnGroup (:user1 , :user2 , :is_group)";

        $query = $database->prepare($sql);
        $query->execute([
            ':user1' => $user1,
            ':user2' => $user2
        ]);

        $existing = $query->fetch();

        if ($existing && $isGroupChat == 0) {
            return $existing->group_id;
        }

        $sql = "CALL createGroup (:name , :is_group)";
        $query = $database->prepare($sql);

        $query->execute([
            ':name' => $name,
            ':is_group' => $isGroupChat
        ]);

        $group_id = $database->lastInsertId();

        MessageModel::assignToGroup($user1, $group_id);
        if($user2 != null){
            MessageModel::assignToGroup($user2, $group_id);
        }

        return $group_id;
    }

    static function getNewMessages($groupID){
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL getNewMessages(:groupID)";
        $query = $database->prepare($sql);
        $query->execute([':groupID' => $groupID]);

        $messages = $query->fetchAll();
        
        return $messages ?: array();
    }

    static function markAsRead($groupID)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL markAsRead(:groupID)";
        $query = $database->prepare($sql);
        $query->execute([':groupID' => $groupID]);
    }

    static function getMessages($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL getMessages(:group_id)";

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
        $sql = "CALL isAlreadyAssigned(:userID, :groupID)";
        $query = $database->prepare($sql);
        $query->execute([':userID' => $userID, ':groupID' => $groupID]);

        if ($query->fetch()) {
            return; // already in group, do nothing
        }

        // Only insert if not already assigned
        $sql = "CALL assignUserToGroup(:userID, :groupID)";
        $query = $database->prepare($sql);
        $query->execute([':userID' => $userID, ':groupID' => $groupID]);
    }

    public static function getGroupsForUser($userID)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL getGroupsForUser(:userID)";

        $query = $database->prepare($sql);
        $query->execute(array(':userID' => $userID));

        $all_users_groups = array(); // fixed typo

        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $group) {
            array_walk_recursive($group, 'Filter::XSSFilter');

            $all_users_groups[$group->group_id] = new stdClass(); // use group_id as key
            $all_users_groups[$group->group_id]->user_id  = $group->user_id;
            $all_users_groups[$group->group_id]->group_id = $group->group_id;
            $all_users_groups[$group->group_id]->name     = $group->name;
            $all_users_groups[$group->group_id]->is_group = $group->is_group;
        }

        return $all_users_groups ?: array();
    }
}
