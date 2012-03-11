<?php

function getBooks(){
    $xml = simplexml_load_file('books.xml');
    $abooks = json_decode(json_encode($xml));
    $abooks = $abooks->book;

    $books = array();
    foreach ($abooks as $book) {
        @$books[$book->id] = array(
            'id' => $book->id,
            'image'=>$book->image,
            'name'=>$book->name,
            'author'=>$book->author, 
            'description'=>$book->description,
            'thumb'=>$book->thumb
            );
    }
    return $books;
}

?>
