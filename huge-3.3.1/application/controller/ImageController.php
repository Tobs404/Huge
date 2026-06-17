<?php

class ImageController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
     * when user moves to /index or enter your application at base level
     */
    public function index()
    {
        $approvedImages = ImageModel::LoadImages();

        $this->View->render('Image/index', [
            'approvedImages' => $approvedImages
        ]);
    }
    
    public function UploadImageToModell(){
        ImageModel::UploadImage();
        $approvedImages = ImageModel::LoadImages();
    
        $this->View->render('Image/index', ['approvedImages' => $approvedImages]);
    }

    public function image($picture)
    {
        if (!$picture) {
            http_response_code(404);
            exit('Not found');
        }

        $file = dirname(__DIR__, 2) . "/UserImages/" . basename($picture);

        if (!file_exists($file)) {
            http_response_code(404);
            exit('File missing');
        }

        header('Content-Type: ' . mime_content_type($file));
        header('Content-Length: ' . filesize($file));

        readfile($file);
        exit;
    }
}
