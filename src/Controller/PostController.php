<?php

// Import des différentes classes et interfaces utilisées
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Multimedia;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\MultimediaRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    // Route principale pour afficher tous les posts
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération de l'utilisateur courant
        $user = $this->getUser();
        if (!$user) {
            // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Création d'une nouvelle instance de Post pour pouvoir l'utiliser dans le formulaire de création de post
        $post = new Post();

        // Création d'une nouvelle instance de Comment pour pouvoir l'utiliser dans le formulaire de création de commentaire
        $comment = new Comment();

        // Création du formulaire de création de commentaire avec le formulaire CommentType
        $form = $this->createForm(CommentType::class, $comment);

        // Gestion de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire pour créer un nouveau commentaire
            $comment->setComment($form['comment']->getData()['comment'])
                ->setPost($comment->getPost())
                ->setIsActive(true)
                ->setUserComment($user);

            // Persistance du nouveau commentaire dans la base de données
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        // Récupération des commentaires et des posts à afficher sur la page
        $commentQuery = $postRepository->findCommentByLimit();
        $posts = $postRepository->findAllWithImages();
        $image = $userRepository->findAllWithImages();

        // Affichage de la page post/index.html.twig avec les données récupérées
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts,
            'images' => $image,
            'comment' => $commentQuery,
            'form' =>  $form->createView()
        ]);
    }

    // Route pour afficher les posts correspondant à une catégorie de véhicule
    #[Route('/Post/{vehicle}', name: 'app_vehicle')]
    public function postByVehicle(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }


    #[Route('/post/add_post', name: 'app_add_post')]
    public function addPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        // On crée une nouvelle instance de Post
        $post = new Post();
        // On crée le formulaire associé à l'objet $post avec PostType comme modèle
        $form = $this->createForm(PostType::class, $post);
        // On traite les données du formulaire envoyé via la requête HTTP
        $form->handleRequest($request);

        // On vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère l'utilisateur connecté
            $user = $this->getUser();
            // On vérifie si l'utilisateur est connecté
            if (!$user) {
                // Si l'utilisateur n'est pas connecté, on redirige vers la page de connexion
                // TODO: remplacer par une fonction de fenêtre modale qui lui laisse le choix entre
                // la connexion et l'inscription
                return $this->redirectToRoute('app_login');
            }

            // Gestion des images
            // On récupère les fichiers image envoyés via le formulaire
            $imageFiles = $form->get('images')->getData();

            // On boucle sur les fichiers images pour les traiter individuellement
            foreach ($imageFiles as $imageFile) {
                if ($imageFile) {
                    // On récupère le nom réel de l'image
                    $fileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                    // On génère un nom unique pour ne pas écraser les données
                    $fileNameId = $fileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                    try {
                        // On déplace l'image dans le dossier de destination
                        $imageFile->move(
                            $this->getParameter('post_directory'),
                            $fileNameId
                        );
                    } catch (FileException $fileException) {
                        // TODO: gérer le cas d'erreur
                    }

                    // On crée une instance de Multimedia pour y stocker le nom de l'image dans la bonne ligne
                    $image = new Multimedia();
                    $image->setImagePost($fileNameId)
                        ->setIsActive(true);
                    // On stocke le nouveau nom de l'image dans la base de données
                    $post->addImage($image);
                }
            }

            // On remplit les champs de l'objet $post avec les données du formulaire
            $post->setUserPost($user)
                ->setIsActive(true)
                ->setVehicle($form['vehicle']->getData())
                ->setDescription($form['description']->getData())
                ->setCreatedAt(new \DateTime('now'))
                ->setTitle($form['title']->getData());

            // On persiste l'objet $post et on le sauvegarde en base de données
            $entityManager->persist($post);
            $entityManager->flush();
        }

        // On affiche le formulaire de création de post
        return $this->render('post/add_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


