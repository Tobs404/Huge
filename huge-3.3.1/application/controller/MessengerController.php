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
                'users' => UserModel::getPublicProfilesOfAllUsers())
        );
    }

    public function showMessages($targetUserID)
    {
        $userID = Session::get('user_id');

        $groupID = MessageModel::createGroup($userID, $targetUserID, "Chat between $userID and $targetUserID");

        if (!$groupID) {
            die("Group could not be created");
        }

        $messages = MessageModel::getMessages($groupID);

        $this->View->render('messenger/showMessages', [
            'messages' => $messages,
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
}
