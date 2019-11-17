<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Models\Cms\Headline;
use App\Models\Cms\Post;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class EventController extends Controller
{
    public function index(Request $request){
        $post=Post::with(
            [
                'category',
                'subcategory',
                'penulis'
            ]
        )->where('post_type','event')
        ->select('id','title','slug','description','updated_at','author','post_type','di_lihat',
        'post_status','lokasi','jam_mulai','jam_selesai','tanggal');

        if($request->has('q')){
            $post=$post->where('title','like','%'.$request->input('q').'%');
        }

        $post=$post->paginate(10);

        return $post;
    }

    public function store(Request $request){
        $rules=[
            'title'=>'required',
            'teaser'=>'required',
            'jam_mulai'=>'required',
            'jam_selesai'=>'required',
            'lokasi'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $post=new Post;
            $post->title=$request->input('title');
            $post->description=$request->input('desc');
            $post->comment=$request->input('comment');
            $post->teaser=$request->input('teaser');
            $post->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
            $post->jam_mulai=date('H:i:s',strtotime($request->input('jam_mulai')));
            $post->jam_selesai=date('H:i:s',strtotime($request->input('jam_selesai')));
            $post->lokasi=$request->input('lokasi');
            $post->lat=$request->input('lat');
            $post->lng=$request->input('lng');
            $post->post_type='event';


            if($request->has('youtube')){
                $post->featured_youtube=$request->input('youtube');
            }

            if($request->has('facebook')){
                $post->featured_facebook=$request->input('facebook');
            }
            
            $post->post_status=$request->input('status');
            $post->author=\Auth::user()->id;

            if($request->has('file') && $request->input('file')!=""){
                if(!is_dir('uploads/event/')){
                    mkdir('uploads/event/', 0777, TRUE);
                }

                $imageData = $request->input('file');
                $filename = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->input('file'))->save(public_path('uploads/event/').$filename);
                $post->featured_image=$filename;
            }

            $simpan=$post->save();

            if($simpan){

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function update(Request $request,$id){
        $rules=[
            'title'=>'required',
            'teaser'=>'required',
            'jam_mulai'=>'required',
            'jam_selesai'=>'required',
            'lokasi'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'errors'=>$validasi->errors()->all()
            );
        }else{
            $post=Post::find($id);
            $post->title=$request->input('title');
            $post->description=$request->input('desc');
            $post->comment=$request->input('comment');
            $post->teaser=$request->input('teaser');
            $post->tanggal=date('Y-m-d',strtotime($request->input('tanggal')));
            $post->jam_mulai=date('H:i:s',strtotime($request->input('jam_mulai')));
            $post->jam_selesai=date('H:i:s',strtotime($request->input('jam_selesai')));
            $post->lokasi=$request->input('lokasi');
            $post->lat=$request->input('lat');
            $post->lng=$request->input('lng');
            $post->post_type='event';


            if($request->has('youtube')){
                $post->featured_youtube=$request->input('youtube');
            }

            if($request->has('facebook')){
                $post->featured_facebook=$request->input('facebook');
            }
            
            $post->post_status=$request->input('status');
            $post->author=\Auth::user()->id;

            if($request->has('file') && $request->input('file')!=""){
                if(!is_dir('uploads/event/')){
                    mkdir('uploads/event/', 0777, TRUE);
                }

                $imageData = $request->input('file');
                $filename = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->input('file'))->save(public_path('uploads/event/').$filename);
                $post->featured_image=$filename;
            }

            $simpan=$post->save();

            if($simpan){

                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }
}