<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class AdminFungsiController extends Controller
{
    public function jawab(Request $request, $id)
    {
        $p = Pertanyaan::findOrFail($id);
        $data = $request->validate(['jawaban' => 'required|string']);

        $p->update([
            'jawaban' => $data['jawaban'],
            'status' => 'dijawab',
            'id_admin_fungsi' => auth()->id(), 
        ]);

        return response()->json(['message'=>'Jawaban disimpan','data'=>$p]);
    }
}
