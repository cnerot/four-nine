<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PhotoController
{
    public function preDeploy($args)
    {

    }

    /**
     * Static pages main
     */
    public function indexAction($args)
    {
        /** Get BDD data */
        $fb = new FBApp();
        $contestCurrent = (new Contest())->getCurrent();
        $currentUserPhoto = (new Photo())->getCurrentUserPhoto($_SESSION['idUser'], $contestCurrent->getId());
        $currentUserLink = (new Link())->getCurrentUserLink($_SESSION['idUser'], $contestCurrent->getId());
        /**Get FB Albums*/
        $albums = $fb->getFBUserData("/me?fields=albums{name,photos{source}}");
        if (isset($albums['albums'])) {
            $albums = $albums['albums']['data'];
        } else {
            $albums = array();
        }
        /**Get Current Photo URL*/
        if ($currentUserPhoto) {
            $currentUserPhotoUrl = $currentUserPhoto->getFbPhotoUrl();
        } else {
            $currentUserPhotoUrl = false;
        }

        if (isset($_POST['submit'])) {
            echo "<pre>";

            if (isset($_POST['idPhotoFbToSend'])) {
                $source = $fb->getFBUserData($_POST['idPhotoFbToSend'] . '?fields=source');
                $source = $source['source'];
                $args = array(
                    'url' => $source
                );
                $data = $fb->postFBPageData(Config::DATA_PAGE_ID . '/photos', $args);
                $newFb = $data->getDecodedBody();
                $newFbId = $newFb['id'];
            }
            if (isset($_FILES['file_img'])) {
                if ($_FILES['file_img']['type'] != "image/png" && $_FILES['file_img']['type'] != "image/jpeg") {
                    $error[] = "Veuillez sélectionner une image de type png ou jpg";
                    $err = true;
                }
                if ($_FILES['file_img']['size'] > 10000000) {
                    $error[] = "Veuillez sélectionner un fichier de 10 mo maximum";
                    $err = true;
                }
                $path = $_FILES['file_img']['tmp_name'];
                $args = array(
                    'source' => $fb->fb->fileToUpload($path),
                );
                $data = $fb->postFBPageData(Config::DATA_PAGE_ID . '/photos', $args);

                $newFb = $data->getDecodedBody();
                $newFbId = $newFb['id'];
            }
            //var_dump($newFbId);
            if (isset($newFbId)) {
                $new_photo = new Photo();
                $new_link = new Link();
                if ($currentUserPhoto) {
                    $new_photo = $currentUserPhoto;
                    $new_link = $currentUserLink;
                }
                //$new_photo->setDescription($newFbId);
                $new_photo->setIdUser($_SESSION['idUser']);
                $new_photo->setIdFb($newFbId);
                $photo_id = $new_photo->save();
                $new_link->setIdContest($contestCurrent->getId());
                $new_link->setIdPhoto($photo_id);
                $new_link->save();
            } else {
                $error[] = "Une erreur s'est produite";
            }
            echo "</pre>";
        }


        /** Compile errors */
        $error = array();
        if (!$contestCurrent)
            $error[] = 'Aucun concours photo de prévu pour le moment';
        /** Set view and add data */
        $view = new View();
        $view->setView('photoSelect');
        $view->putData('Error', $error);
        $view->putData('albums', $albums);
        $view->putData('currentPhoto', $currentUserPhotoUrl);
    }


    public function deleteImgFbAction($args)
    {
        $Photo = new Photo();

        if (isset($_GET['idPhoto'])) {
            $photoToDelete = $Photo->getWhere(['id' => $_GET['idPhoto']]);
        } else if (isset($_GET['idFb'])) {
            $photoToDelete = $Photo->getWhere(['id_fb' => $_GET['idFb']]);
        }


        // vérifie que la photo appartient à l'utilisateur
        if ($photoToDelete[0]->id_user == $_SESSION['idUser']) {
            // suppression de la photo dans la table "photo"

            // suppression du link dans la table "link"
            $Link = new Link();
            $linkToDelete = $Link->getWhere(['id_photo' => $photoToDelete[0]->id]);

            $exit = false;
            foreach ($linkToDelete as $linkToDeleteCurrent) {
                if ($exit == false) {
                    if ($linkToDeleteCurrent->id_contest == $_SESSION['idContest']) { // si link correspond avec id_photo et id_contest
                        $Link->setId($linkToDeleteCurrent->id);

                        if (count($linkToDelete) == 1) { // si la photo fb n'était liée qu'à un seul concours
                            $Photo->setId($photoToDelete[0]->id);
                            $Photo->delete();
                        }
                        $Link->delete();
                        $exit = true;
                    }
                }
            }
        }
    }

    public
    function testAction($args)
    {
        $fb = new FBApp();
        $data = $fb->getFBUserData('app');
        Logger::debug($data);
    }
}