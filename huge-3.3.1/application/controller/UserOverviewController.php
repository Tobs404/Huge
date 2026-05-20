<?php

/**
 * This controller shows all of our visitors the Users we currently have
 */
class UserOverviewController extends Controller
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
        $this->View->render('UserOverview/index', array(
                'users' => UserModel::getPublicProfilesOfAllUsers())
        );
    }
}
