<?php

namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BooksController extends AbstractController
{
    #[Route('/library', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET'])]
    public function createBook(
    ): Response {

        return $this->render('books/new_book.html.twig');
    }

    #[Route('/library/create/book', name: 'library_create_post', methods: ['POST'])]
    public function createBooks(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $picture = $request->request->get('picture');

        $book = new Books();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setPicture($picture);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // return new Response('Saved new product with id '.$book->getId());
        return $this->redirectToRoute('library_show');
    }

    #[Route('/library/show', name: 'library_show')]
    public function showAllProduct(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('books/show_all.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'book_by_id', methods: ['GET'])]
    public function showBookById(
        BooksRepository $productRepository,
        int $id
    ): Response {
        $book = $productRepository->find($id);

        return $this->render('books/show_one.html.twig', ['book' => $book]);
    }

    #[Route('/library/edit/{id}', name: 'book_by_id_edit', methods: ['POST'])]
    public function editBookById(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $picture = $request->request->get('picture');

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setPicture($picture);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->render('books/show_one.html.twig', ['book' => $book]);
    }

    #[Route('/library/delete/{id}', name: 'book_delete_by_id')]
    public function deleteProductById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_show');
    }

    #[Route('/api/library/books', name: 'library_show_all')]
    public function showAllBooks(
        BooksRepository $booksRepository
    ): Response {
        $products = $booksRepository
            ->findAll();

        $response = $this->json($products);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
        // return $this->json($products);
    }

    #[Route("/api")]
    public function api(): Response
    {

        $data = [
            'api/library/books' => 'Shows all books',
            'api/library/book/<isbn>' => 'Show book by ISBN'
        ];

        return $this->render('books/api.html.twig', ['data' => $data]);
    }

    #[Route('/api/library/books', name: 'library_show_all_api')]
    public function showAllProductApi(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        $response = new JsonResponse($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/books/{isbn}', name: 'library_book_isbn')]
    public function showBookIsbnApi(
        BooksRepository $booksRepository,
        string $isbn
    ): Response {

        $book = $booksRepository->findOneByIsbnField2($isbn);

        if (!$book) {
            return new JsonResponse([$isbn => 'Book not found in library']);
        }

        $response = new JsonResponse($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
