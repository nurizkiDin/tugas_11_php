<?php

namespace App\Http\Controllers;
use App\tbl_pekerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pekerja extends Controller
{
    public function baca(){
        $data = DB::table('tbl_pekerja')->get();
        return response($data);
    }
    public function baru(Request $request){
        $this->validate($request, [
            'foto' => 'required|max:2048'
        ]);
        $foto = $request->file('foto');
        $namaFoto = time()."_".$foto->getClientOriginalName();
        $folderFoto = 'album_foto';
        $foto->move($folderFoto, $namaFoto);
        $data = tbl_pekerja::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'foto' => $namaFoto
        ]);
        $res['message'] = 'Success!';
        $res['values'] = $data;
        return response($res);
    }
    public function hapus($id){
        $data = DB::table('tbl_pekerja')->where('id',$id)->get();
        if(count($data)!=null&&count($data)>0){
            DB::table('tbl_pekerja')->where('id',$id)->delete();
            foreach($data as $pekerja){
                if(file_exists(public_path('album_foto/'.$pekerja->foto))){
                    @unlink(public_path('album_foto/'.$pekerja->foto));
                }
            }
            $res['message'] = 'Success!';
            return response($res);
        }else{
            $res['message'] = 'Data not found!';
            return response($res);
        }
    }
    public function ubah(Request $request, $id){
        $data = DB::table('tbl_pekerja')->where('id',$id)->get();
        foreach($data as $pekerja){
            if(file_exists(public_path('album_foto/'.$pekerja->foto))){
                @unlink(public_path('album_foto/'.$pekerja->foto));
            }
        }
        if(count($data)!=null&&count($data)>0){
            $this->validate($request, [
                'foto' => 'required|max:2048'
            ]);
            $foto = $request->file('foto');
            $namaFoto = time()."_".$foto->getClientOriginalName();
            $folderFoto = 'album_foto';
            $foto->move($folderFoto, $namaFoto);
            DB::table('tbl_pekerja')->where('id',$id)->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'foto' => $namaFoto
            ]);
            $res['message'] = 'Success Update!';
            return response($res);
        }else{
            $res['message'] = 'Data not found!';
            return response($res);
        }
    }
}
