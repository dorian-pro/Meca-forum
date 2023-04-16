<?php

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
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            //redirection de l'utilisateur sur la page de connexion si il nest pas connecter
            //TODO A REMPLACER PAR UNE FONCTION DE FENETRE MODAL QUI LUI LAISSE LE CHOIX ENTRE
            // LA CONNEXION ET LINSCRIPTION
            return $this->redirectToRoute('app_login');
        }

        $post = new Post();


        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setComment($form['comment']->getData()['comment'])
                ->setPost($comment->getPost())
                ->setIsActive(true)
                ->setUserComment($user);

            $entityManager->persist($comment);
            $entityManager->flush();
        }

        $commentQuery = $postRepository->findCommentByLimit();
        $posts = $postRepository->findAllWithImages();
        $image = $userRepository->findAllWithImages();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts,
            'images' => $image,
            'comment' => $commentQuery,
            'form' =>  $form->createView()
            ]);
    }

    //tri par categorie de véhicule
    #[Route('/Post/{vehicle}', name: 'app_vehicle')]
    public function postByVehicle(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    //affichage detaille par véhicule et par id
    #[Route('/Post/{vehicle}/detail/{id}', name: 'app_vehicle')]
    public function postByVehiclePostId(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/post/add_post', name: 'app_add_post')]
    public function addPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if (!$user) {
                //redirection de l'utilisateur sur la page de connexion si il nest pas connecter
                //TODO A REMPLACER PAR UNE FONCTION DE FENETRE MODAL QUI LUI LAISSE LE CHOIX ENTRE
                // LA CONNEXION ET LINSCRIPTION
                return $this->redirectToRoute('app_login');
            }

            //gestion des images
            $imageFiles = $form->get('images')->getData();

            foreach ($imageFiles as $imageFile) {
                if ($imageFile) {
                    //on recupere le nom reel de limage
                    $fileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                    //on genere un nom unique pour ne pas ecraser les donnés
                    $fileNameId = $fileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                    try {
                        //deplacement de limage dans le dossier
                        $imageFile->move(
                            $this->getParameter('post_directory'),
                            $fileNameId
                        );
                    } catch (FileException $fileException) {
                        //TODO GERER LE CAS D'ERREUR
                    }

                    //on instencie Multimedia pour lui inserer une string dans la bonne ligne
                    $image = new Multimedia();
                    $image->setImagePost($fileNameId)
                        ->setIsActive(true);
                    //on transfere le nouveau nom en bdd
                    $post->addImage($image);
                }
            }

            $post->setUserPost($user)
                ->setIsActive(true)
                ->setVehicle($form['vehicle']->getData())
                ->setDescription($form['description']->getData())
                ->setCreatedAt(new \DateTime('now'))
                ->setTitle($form['title']->getData());

            $entityManager->persist($post);
            $entityManager->flush();
        }

        return $this->render('post/add_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    public function addComment(Request $request, EntityManagerInterface $entityManager): Response
//    {
//
//        $user = $this->getUser();
//        if (!$user) {
//            //redirection de l'utilisateur sur la page de connexion si il nest pas connecter
//            //TODO A REMPLACER PAR UNE FONCTION DE FENETRE MODAL QUI LUI LAISSE LE CHOIX ENTRE
//            // LA CONNEXION ET LINSCRIPTION
//            return $this->redirectToRoute('app_login');
//        }
//
//        $post = new Post();
//
//
//        $comment = new Comment();
//        $form = $this->createForm(PostType::class, $comment);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $comment->setComment($form['comment']->getData())
//                    ->setPost($comment->getPost())
//                    ->setIsActive(true)
//                    ->setUserComment($user);
//
//            $entityManager->persist($comment);
//            $entityManager->flush();
//        }
//        return $this->render('post/index.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

}


