<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($username){
        $author = Author::where('username', $username)->first();
        
        if (!$author) {
            abort(404, 'Author not found');
        }

        return view('pages.author.show', compact('author'));
    }
}
