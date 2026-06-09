<?php

/**
 * This controller shows all of our visitors the Users we currently have
 */
class MessengerController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */
    public function index()
    {
       $this->View->render('messenger/index', array(
            'users'  => UserModel::getPublicProfilesOfAllUsers(),
            'groups' => MessageModel::getGroupsForUser(Session::get('user_id'))
        ));
    }

    public function createGroupChat()
    {
        $userID    = Session::get('user_id');
        $groupName = Request::post('group_name') ?? 'New Group';

        $groupID = MessageModel::createGroup($userID, null, $groupName, 1);

        Redirect::to('messenger/showGroupMessages/' . $groupID);
    }

    public function showGroupMessages($groupID)
    {
        MessageModel::markAsRead($groupID);
        
        $this->View->render('messenger/showGroupMessages', array(
            'messages' => MessageModel::getMessages($groupID),
            'newMessages' => MessageModel::getNewMessages($groupID),
            'groupID'  => $groupID,
            'users'    => UserModel::getPublicProfilesOfAllUsers()
        ));
    }

    public function showMessages($targetUserID)
    {
        $userID = Session::get('user_id');

        $groupID = MessageModel::createGroup($userID, $targetUserID, "Chat between $userID and $targetUserID", 0);

        if (!$groupID) {
            die("Group could not be created");
        }

        MessageModel::markAsRead($groupID);

        $messages = MessageModel::getMessages($groupID);

        $this->View->render('messenger/showMessages', [
            'messages' => $messages,
            'newMessages' => MessageModel::getNewMessages($groupID),
            'groupID' => $groupID,
            'targetUserID' => $targetUserID
        ]);
    }

    public function insertMessage()
    {
        $groupID = $_POST['groupID'];
        $message = $_POST['message'];
        
        MessageModel::insertMessage($message, $groupID);
        $this->View->render('messenger/showMessages', [
            'messages' => MessageModel::getMessages($groupID),
            'groupID' => $groupID
        ]);
    }

    public function insertGroupMessage()
    {
        $groupID = Request::post('groupID');
        $message = Request::post('message');
        
        MessageModel::insertMessage($message, $groupID);
        Redirect::to('messenger/showGroupMessages/' . $groupID);
    }

    public function inviteUser()
    {
        $groupID = Request::post('group_id');
        $userID = Request::post('ID');

        MessageModel::assignToGroup($userID, $groupID);
        Redirect::to('messenger/showGroupMessages/' . $groupID);
    }
}
