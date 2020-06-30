<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Entities\File;
use App\Entities\Foo;
use App\Entities\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class FileController extends Controller
{
    public function upload(Request $request): Response
    {
        $file = new File();
        $file->setFile($request->file('archive'));
        $file->save();

        return new Response($file->id);
    }

    public function update(string $id, Request $request): Response
    {
        $file = File::findOrFail($id);
        $file->setFile($request->file('archive'));
        $file->save();

        return new Response($file->id);
    }

    public function find(string $id)
    {
        $test = Test::findOrFail($id);

        foreach ($test->foos as $foo) {
            $foo->name .= ' update';
        }

        $test->push();


        $file = File::findOrFail($id);

        dd($file);
    }

    public function deleteAll()
    {
        $files = File::all();
        foreach ($files as $file) {
            $file->delete();
        }

        return new Response('files deleted');
    }

    public function delete(string $id)
    {
//        dd(1);
        $file = File::findOrFail($id);
        $file->delete();
        dd($id);

        dd($id);
    }

    public function foo(): Response
    {
        $test = $this->getTest();

        foreach (range(1, 5) as $number) {
            $foo = (new Foo)->change("Foo{$number}");
            $test->addFoo($foo);
            $foo->save();
        }

//        $tests = Test::all()->where('id', '>', 2);
        $foos = Foo::all();

        return new Response($foos->count());
    }

    public function showTest(): Response
    {
        dd($this->getTest()->foos()->count());

        return new Response('x');
    }

    public function cool(): Response
    {
        $test = (new Test)->change('My test');
        $foos = array_map(fn(int $i): Foo => (new Foo)->change("Foo {$i}"), [1, 2]);
        foreach ($foos as $foo) {
            $test->addFoo($foo);
        }
        dd($test->foos()->getRelated());

//        $test->foos()->create();
//        $test->save();

        dd($test->foos());

        $test->foos()->saveMany($foos);
//        dd($test->relations);
//        $test->push();

        return new Response('Check db');
    }

    protected function getTest(): Test
    {
        return Test::query()->orderBy('created_at', 'desc')->first();
    }
}
