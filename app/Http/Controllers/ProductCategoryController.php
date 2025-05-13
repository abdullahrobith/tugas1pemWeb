<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categories;
class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
    $categories = Categories::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
        })
        ->paginate(10);

    return view('dashboard.categories.index', [
        'categories' => $categories,
        'q' => $request->q,
    ]);
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255',
            'description' => 'required',
        ]);
        
        /**
         * Jika validasi gagal,
         * maka redirect kembali dengan pesan error
         */
        if ($validator->fails()) {
            return redirect()->back()->with([
                'errors'       => $validator->errors(),
                'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu',
            ]);
        }
        
        $category              = new Categories;
        $category->name        = $request->name;
        $category->slug        = $request->slug;
        $category->description = $request->description;
        
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $imagePath  = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }
        
        $category->save();
        
        return redirect()->back()->with([
            'successMessage' => 'Data Berhasil Disimpan',
        ]);
        
    }

    public function show(string $id)
    {
        $category = Categories::find($id);
        return view('dashboard.categories.detail',[
            'category'=>$category
        ]);
    }

    public function edit(string $id)
    {
        $category = Categories::find($id);
        return view('dashboard.categories.edit',[
            'category'=>$category
        ]);
    }

    public function update(Request $request, string $id)
    {
        /**
         * Cek validasi input
         */
        $validator = \Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255',
            'description' => 'required',
        ]);
    
        /**
         * Jika validasi gagal, maka redirect kembali dengan pesan error
         */
        if ($validator->fails()) {
            return redirect()->back()->with([
                'errors'       => $validator->errors(),
                'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu',
            ]);
        }
    
        $category = Categories::find($id);
        $category->name        = $request->name;
        $category->slug        = $request->slug;
        $category->description = $request->description;
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
    
            // Simpan gambar baru
            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }
    
        $category->save();
    
        return redirect()->back()->with([
            'successMessage' => 'Data Berhasil Disimpan',
        ]);
    }    

    public function destroy(string $id)
    {
        $category = Categories::find($id);
        $category->delete();
        return redirect()->back()
            ->with(
                [
                    'successMessage'=>'Data Berhasil Dihapus'
                ]
            );
    }
}
