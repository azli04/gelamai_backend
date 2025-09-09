<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(Faq::orderBy('created_at','desc')->paginate(20));
    }

    public function show($id)
    {
        return response()->json(Faq::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan'=>'required|string',
            'jawaban'=>'required|string',
        ]);
        $faq = Faq::create($data);
        return response()->json(['message'=>'FAQ dibuat','data'=>$faq],201);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $data = $request->validate([
            'pertanyaan'=>'sometimes|string',
            'jawaban'=>'sometimes|string',
        ]);
        $faq->update($data);
        return response()->json(['message'=>'FAQ diupdate','data'=>$faq]);
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return response()->json(['message'=>'FAQ dihapus']);
    }
}
