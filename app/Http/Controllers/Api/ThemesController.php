<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ThemesController extends Controller
{
    private $theme;
    public function __construct(Theme $theme)
    {
       $this->theme = $theme;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'min:3', 'max:255'],
            'mode' => ['required', 'in:ENEM,UVA'],
            'img_preview' => ['mimes:jpeg,bmp,png,gif,svg', 'max:1024'],
            'pdf' => ['required', 'mimes:pdf', 'max:5120'],
        ]);

        $data = $request->all();

        // Upload Img Preview
        $savedImgPreview = $request->file('img_preview');;
        if($savedImgPreview) { 
            $savedImgPreview = $savedImgPreview->store('themes/img_preview');
        }

        // Upload PDF
        $savedPdf = $request->file('pdf');
        if($savedPdf) {
            $savedPdf = $savedPdf->store('themes/pdf/');
        }

        
        $data['img_preview'] = $savedImgPreview;
        $data['pdf'] = $savedPdf;
        if($this->theme->create($data))
            //return redirect()->route('themes.show', $theme->id)->with('success', __('You have successfully create theme!'));
            return response('FOI',200);
        //return redirect()->back()->with('error', __('We were unable to create the theme, please try again!'))->withInput();
        return response('ij',404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $theme = $this->theme->findOrFail($id);
        $data = $request->all();

        $oldImgPreview = $theme->img_preview;
        $imgPreview = $request->file('img_preview');
        if($imgPreview) { 
            $data['img_preview'] = $imgPreview->store('themes/img_preview');
        }
        

        // Upload PDF
        $oldPdf = $theme->pdf;
        $pdf = $request->file('pdf');
        if($pdf) {
            $data['pdf'] = $pdf->store('themes/pdf/');
        }

        
        if(($theme->update($data))) {

            // Deleting Old Files
            if($imgPreview)
                Storage::disk()->delete($oldImgPreview);

            if($pdf)
                Storage::disk()->delete($oldPdf);

            return response('Foi', 200);    
            //return redirect()->route('themes.configurations', $theme->id)->with('success', __('You have successfully update theme!'));
        }

        return response('Falha', 401);
        //return redirect()->back()->with('error', __('We were unable to update the theme, please try again!'))->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $theme =$this->theme->findOrfail($id);
        $img_preview = $theme->img_preview;
        $pdf = $theme->pdf;

        if($theme->delete()) {
            if($img_preview)
                Storage::disk()->delete($img_preview);

            if($pdf)
                Storage::disk()->delete($pdf);

            //return redirect()->route('themes.index')->with('success', __('You have successfully deleted theme!'));
            return response('Foi',200);
        }

        return response('Falha',404);
    }
}
