<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Category;
use App\Form\SortType;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/", name="books_index", methods={"GET", "POST"})
     */
    public function index(BooksRepository $booksRepository, Request $request): Response
    {
        $form = $this->createForm(SortType::class);
        $form->handleRequest($request);
        //si le form est envoyer je le stoque dans la variable
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            dump($category);
            $books = $booksRepository->findByCategory($category['Category']);
        }
        else {
            //
            $books = $booksRepository->findAll();
        }
        return $this->render('books/index.html.twig', [
            'books' => $books,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/new", name="books_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Books();
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('books_index');
        }

        return $this->render('books/new.html.twig', [
            'book' => $book,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="books_show", methods={"GET"})
     */
    public function show(Books $book): Response
    {
        return $this->render('books/show.html.twig', [
            'book' => $book,
        ]);
        // $categoryName = $book -> getCategory () -> getCategory ();
    }

    /**
     * @Route("/{id}/edit", name="books_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Books $book): Response
    {
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('books_index', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('books/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="books_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Books $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }
        return $this->redirectToRoute('books_index');
    }

}
