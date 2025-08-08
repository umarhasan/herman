<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\FileUpload;
use App\Models\FileUploadCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class FileUploadController extends Controller
{
    public function index()
    {
        $files = FileUpload::with('categories')->orderBy('created_at','asc')->get();
		return view('admin.files.index', compact('files'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.files.create', compact('categories'));
    }

    public function store(Request $request)
    {

        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'author' => 'nullable',
        //     'testified' => 'nullable',
        //     'description' => 'nullable|string',
        //     'cover_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        //     'category_amounts.*' => 'numeric|min:0',
        //     'category_files.*' => 'required|mimes:pdf',
        // ]);

        $file = new FileUpload();
        $file->name = $request->title;
        $file->title = $request->title;
        $file->author = $request->author;
         $file->testified = $request->testified;
        $file->description = $request->description;

        // Upload Cover Image
        $coverImage = $request->file('cover_image');
        $coverImageName = Str::uuid() . '.' . $coverImage->getClientOriginalExtension();
        $coverImagePath = $coverImage->storeAs('uploads', $coverImageName, 'public');
        $file->cover_image = $coverImagePath;

        $file->save();

        foreach ($request->categories as $key => $category_id) {
            $category = Category::findOrFail($category_id);

            // Upload Files for this category
            $categoryFile = $request->category_files[$key];
            $uniqueFileName = Str::uuid() . '.' . $categoryFile->getClientOriginalExtension();
            $filePath = $categoryFile->storeAs('uploads', $uniqueFileName, 'public');


            // Attach Category with amount and file path
            $file->categories()->attach($category_id, [
                'amount' => $request->category_amounts[$key],
                'file_path' => $filePath
            ]);
        }
        return redirect()->route('admin.files.index')->with('success', 'File uploaded successfully');
    }


    public function edit($id)
    {
        $file = FileUpload::with('FileCategory')->findOrFail($id);
        $categories = Category::all();
        return view('admin.files.edit', compact('file', 'categories'));
    }

    public function update(Request $request, $id)
    {

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable',
            'testified' => 'nullable',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf', // Allow null cover image
            'categories' => 'nullable|array',
            'category_amounts.*' => 'numeric|min:0',
            'category_files.*' => 'nullable|mimes:pdf', // Allow null category files
        ]);

        try {
            // Find the file to be updated
            $file = FileUpload::findOrFail($id);

            // Handle cover image update
            if ($request->hasFile('cover_image')) {
                // Delete existing cover image
                Storage::disk('public')->delete($file->cover_image);

                $newCoverImage = $request->file('cover_image');
                $coverImagePath = $newCoverImage->storeAs('uploads', Str::uuid() . '.' . $newCoverImage->getClientOriginalExtension(), 'public');
            } else {
                $coverImagePath = $file->cover_image;
            }

            // Update the main file details
            $file->update([
                'title' => $request->title,
                'author' => $request->author,
                'testified' => $request->testified,
                'description' => $request->description,
                'cover_image' => $coverImagePath,
            ]);

            // Loop through the categories and create new associated records
            if ($request->has('categories')) {
                foreach ($request->categories as $key => $category_id) {
                    $category = Category::findOrFail($category_id);
                    // Upload Files for this category if provided
                    if ($request->hasFile('category_files.'.$key)) {
                        $categoryFile = $request->file('category_files.'.$key);
                        $uniqueFileName = Str::uuid() . '.' . $categoryFile->getClientOriginalExtension();
                        $filePath = $categoryFile->storeAs('uploads', $uniqueFileName, 'public');
                    } else {
                        $filePath = null; // No new file provided
                    }

                    // Attach Category with amount and file path
                    $amount = isset($request->category_amounts[$key]) ? $request->category_amounts[$key] : 0;

                    $file->categories()->attach($category_id, [
                        'amount' => $amount,
                        'file_path' => $filePath,
                    ]);
                }
            }

            return redirect()->route('admin.files.index')->with('success', 'File updated successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur
            return redirect()->back()->with('error', 'Failed to update file: '.$e->getMessage());
        }
    }


    public function destroy($id)
    {
        $file = FileUpload::findOrFail($id);

        // Delete associated file and cover image
        // Storage::disk('public')->delete($file->file_path);
        // Storage::disk('public')->delete($file->cover_image);

        // Detach Categories
        $file->categories()->detach();

        // Delete FileUpload record
        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully');
    }


	 public function FileCatUpdate(Request $request)
    {

        $id = $request->id;
        $fileCategory = FileUploadCategory::findOrFail($id);

        // Check if the request has category_files or not
        if ($request->has('category_files')) {
            // Upload new files if provided
            if ($request->hasFile('category_files')) {
                $categoryFile = $request->file('category_files');
                $uniqueFileName = Str::uuid() . '.' . $categoryFile->getClientOriginalExtension();
                $filePath = $categoryFile->storeAs('uploads', $uniqueFileName, 'public');
            } else {
                $filePath = null; // No new file provided
            }
        } else {
            // If category_files is not provided, keep the existing file path
            $filePath = $fileCategory->file_path;
        }

        // Update file category details
        $fileCategory->file_category_id = $request->categories;
        $fileCategory->amount = $request->amount;
        $fileCategory->file_path = $filePath;
        $fileCategory->save();

        return redirect()->back()->with(['message' => 'File category updated successfully']);
    }

    public function FileCatDelete($id)
    {
        // Find the file category by ID
        $fileCategory = FileUploadCategory::findOrFail($id);
        // Delete the file category
        $fileCategory->delete();
        return redirect()->back()->with(['message' => 'File category deleted successfully']);

    }

}
