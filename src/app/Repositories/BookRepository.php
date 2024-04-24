<?php
namespace App\Repositories;

use App\Repositories\Contracts\IBookRepository;
use App\Models\Book;
use Recca0120\Repository\EloquentRepository;

class BookRepository extends EloquentRepository implements IBookRepository
{
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    /**
     * Create a book
     * @params  $inputBook Array
     * @authors $authors   Array
     */
    public function createBook($inputBook, $authors = []) {
        $newBook = $this->create($input);
        $newBook->authors()->attach($authors);

        $newBook->setSearchable('true');
        $newBook->searchable();
    }

    public function searchBooks($keyword)
    {

        /*$body = [
            'query' => [
                'match' => [
                    'title' => $keyword,
                ]
            ]
        ];

        $body = [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['title' => $keyword,]],
                        ['match' => ['summary' => $keyword,]],
                        ['match' => ['publisher' => $keyword,]],
                    ]
                ]
            ]
        ];*/
        /*$query = \Elastic\ScoutDriverPlus\Support\Query::bool()
        ->should(
            \Elastic\ScoutDriverPlus\Support\Query::match()
                ->field('title')
                ->query($keyword)
        )
        ->should(
            \Elastic\ScoutDriverPlus\Support\Query::match()
                ->field('summary')
                ->query($keyword)
        )->should(
            \Elastic\ScoutDriverPlus\Support\Query::match()
                ->field('publisher')
                ->query($keyword)
        );
        $lBookFromESs = $this->model->searchQuery($query)->execute();*/
        $lBookFromESs = $this->model->search($keyword)
        ->paginate(2);
        //->orderBy('title', 'asc')
        //->get();

        return $lBookFromESs;
    }
}
