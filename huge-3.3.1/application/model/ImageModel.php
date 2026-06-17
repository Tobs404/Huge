<?php

class ImageModel
{
    public static function UploadImage()
    {
        $path = dirname(__DIR__, 2) . "/UserImages";


        if (!isset($_FILES['datei'])) {
            Session::add('feedback_negative', 'Keine Datei übermittelt.');
            return false;
        }


        if ($_FILES['datei']['error'] !== UPLOAD_ERR_OK) {
            Session::add('feedback_negative', 'Upload fehlgeschlagen.');
            return false;
        }


        if ($_FILES['datei']['size'] > 5 * 1024 * 1024) {
            Session::add('feedback_negative', 'Datei zu groß.');
            return false;
        }

        $mime = mime_content_type($_FILES['datei']['tmp_name']);

        $allowed = [
            "image/jpeg",
            "image/png"
        ];

        if (!in_array($mime, $allowed)) {
            Session::add('feedback_negative', 'Dateityp nicht erlaubt.');
            return false;
        }

        if (!is_dir($path)) {
            mkdir($path,0755,true);
        }

        $extension = pathinfo(
            $_FILES['datei']['name'],
            PATHINFO_EXTENSION
        );

        // create unique filename
        $filename = time() . "_" . uniqid() . "." . $extension;
        $target = $path . "/" . $filename;

        if(move_uploaded_file($_FILES['datei']['tmp_name'],$target)){
            self::SaveToDatabase($filename);
            Session::add(
                'feedback_positive',
                'Datei erfolgreich hochgeladen.'
            );

            return true;
        }

        Session::add(
            'feedback_negative',
            'Datei konnte nicht gespeichert werden.'
        );

        return false;
    }

    private static function SaveToDatabase($filename)
    {
        $database = DatabaseFactory::getFactory()
            ->getConnection();

        $ownerID = Session::get('user_id');

        $sql="CALL saveImage(:ownerID, :imageHash)";

        $query=$database->prepare($sql);

        $query->execute([
            ":ownerID"=>$ownerID,
            ":imageHash"=>$filename
        ]);
    }

    public static function LoadImages()
    {

        $database = DatabaseFactory::getFactory()
            ->getConnection();


        $ownerID = Session::get('user_id');

        $sql="CALL getUserimages(:ownerID)";

        $query=$database->prepare($sql);
        $query->execute([
            ":ownerID"=>$ownerID
        ]);

        return $query->fetchAll();
    }
}
