<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Contracts\IBookRepository;
use App\Http\Requests\BookSearchRequest;
use App\Http\Resources\BookCollection;

class BookController extends ApiController
{
    //
    public function search(BookSearchRequest $request, IBookRepository $repoBook)
    {
        $this->logEntry([
            'keyword' => $request->get('keyword')
        ]);

        $lBooks = $repoBook->searchBooks($request->get('keyword'));

        $lData = new BookCollection($lBooks);

        $this->logExit([
            'data' => $lData
        ]);

        return $lData;
    }
}
