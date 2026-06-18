<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use \Core\View;

/**
 * Product controller
 */
class Product extends \Core\Controller
{

    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
    {

        if(isset($_POST['submit'])) {

            try {
                $f = $_POST;

                // TODO: Validation

                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                if (isset($_FILES['picture']) && $_FILES['picture']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $pictureName = Upload::uploadFile($_FILES['picture'], $id);
                    Articles::attachPicture($id, $pictureName);
                }

                header('Location: /product/' . $id);
                exit;
            } catch (\Exception $e){
                    var_dump($e);
            }
        }

        View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch(\Exception $e){
            var_dump($e);
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }
    /**
     * Traite le formulaire de contact d'un produit
     * @return void
     */
    public function contactAction()
    {
        $id = $this->route_params['id'];
        $errors = [];
        $success = null;

        try {
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);

            if (empty($article)) {
                throw new \Exception('Article introuvable.');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $message = trim($_POST['message'] ?? '');

                if ($name === '') {
                    $errors[] = 'Le nom est obligatoire.';
                }

                if ($email === '') {
                    $errors[] = 'L’email est obligatoire.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'L’email est invalide.';
                }

                if ($message === '') {
                    $errors[] = 'Le message est obligatoire.';
                }

                if (empty($errors)) {
                    $success = 'Votre message a bien été envoyé au vendeur.';

                    $_POST['name'] = '';
                    $_POST['email'] = '';
                    $_POST['message'] = '';
                }
            }

            View::renderTemplate('Product/Show.html', [
                'article' => $article[0],
                'suggestions' => $suggestions,
                'contact_errors' => $errors,
                'contact_success' => $success
            ]);
        } catch(\Exception $e) {
            var_dump($e);
        }
    }
}
