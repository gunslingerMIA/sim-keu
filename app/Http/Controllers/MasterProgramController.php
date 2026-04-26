<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Activity;
use App\Models\SubActivity;

class MasterProgramController extends Controller
{
    public function index()
    {
        // Narik Program beserta Kegiatan dan Sub-Kegiatannya (Eager Loading)
        $programs = Program::with('activities.subActivities')->where('tahun', session('tahun_anggaran', date('Y')))->get();
        
        return view('master.programs', compact('programs'));
    }

    public function storeProgram(Request $request)
    {
        $request->merge(['tahun' => session('tahun_anggaran', date('Y'))]);
        $request->validate([
            'nama_program' => 'required', 
            'kode_program' => [
                'required',
                Rule::unique('programs')->where(function ($query) {
                    return $query->where('tahun', session('tahun_anggaran'));
                }) // Tambahkan ignore($id) jika di fungsi Update
            ], 
            [
            'kode_program.unique' => 'Kode Program sudah ada, gunakan kode lain!'
            ]
        ]);
        Program::create($request->all());
        return back()->with('success', 'Program berhasil ditambah');
    }

    public function updateProgram(Request $request, $id)
    {
        
        $request->validate([
            'nama_program' => 'required', 
            'kode_program' => [
                'required',
                Rule::unique('programs')->where(function ($query) {
                    return $query->where('tahun', session('tahun_anggaran'));
                })->ignore($id) // Tambahkan ignore($id) jika di fungsi Update
            ], 
            [
            'kode_program.unique' => 'Kode Program sudah ada, gunakan kode lain!'
            ]
        ]);    
        $request->merge(['tahun' => session('tahun_anggaran', date('Y'))]);     

        $program = \App\Models\Program::findOrFail($id);
        $program->update($request->all());

        return back()->with('success', 'Program berhasil diperbarui!');
    }

    public function deleteProgram($id)
    {
        // cari program beserta jumlah kegiatannya
        $program = \App\Models\Program::withCount('activities')->findOrFail($id);

        //cek apakah masih ada kegiatan
        if($program->activities_count > 0){
            return back()->with('error', 'Program masih memiliki kegiatan, hapus kegiatan terlebih dahulu!');
        }
        $program->delete(); 
        return back()->with('success', 'Program berhasil dihapus');
    }

    public function storeKegiatan(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'kode_kegiatan' => [
                'required',
                Rule::unique('activities')->where(function ($query) {
                    return $query->where('tahun', session('tahun_anggaran'));
                })
            ],
            'nama_kegiatan' => 'required'
        ], [
            'kode_kegiatan.unique' => 'Kode Kegiatan Sudah Terdaftar',
            'nama_kegiatan.required' => 'Isikan Nama Kegiatan'
        ]);


        Activity::create([
            'program_id' => $request->program_id,
            'kode_kegiatan' => $request->kode_kegiatan,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tahun' => session('tahun_anggaran', date('Y'))
        ]);
        return back()->with('success', 'Kegiatan berhasil ditambah');


    }

    public function updateKegiatan(Request $request, $id)
    {
        $request->validate([
            'kode_kegiatan' => [
                'required',
                Rule::unique('activities')->where(function ($query) {
                    return $query->where('tahun', session('tahun_anggaran'));
                })->ignore($id) // Tambahkan ignore($id) untuk update
            ],
            'nama_kegiatan' => 'required'
        ]);
        $kegiatan = Activity::findOrFail($id);
        $kegiatan->update($request->all());

        return back()->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function deleteActivity($id)
    {
        $activity = \App\Models\Activity::withCount('subActivities')->findOrFail($id);

        if($activity->sub_activities_count > 0){
            return back()->with('error', 'Kegiatan masih memiliki sub-kegiatan, hapus sub-kegiatan terlebih dahulu!');
        }
        $activity->delete(); 
        return back()->with('success', 'Kegiatan berhasil dihapus');
    }

    public function storeSubActivities(Request $request){

    // dd($request->all());
        $request->validate([
            'kode_sub_kegiatan' => [
                'required',
                Rule::unique('sub_activities')->where(function ($query) {
                    return $query->where('tahun', session('tahun_anggaran'));
                })
            ],
            'nama_sub_kegiatan' => 'required'
        ],
        [
            'kode_sub_kegiatan.unique' => 'Kode Sub Kegiatan sudah ada',
            'nama_sub_kegiatan.required' => 'Isikan Nama Sub Kegiatan'
        ]);
        $request->merge(['tahun' => session('tahun_anggaran', date('Y'))]);

        SubActivity::create($request->all());
        return back()->with('success', 'Sub Kegiatan Berhasil Ditambahkan');
        

    }

    public function updateSubActivities(Request $request, $id)
    {
        $request->validate([
            'kode_sub_kegiatan' => 'required|unique:sub_activities,kode_sub_kegiatan,'.$id,
            'nama_sub_kegiatan' => 'required'
        ],
        [
            'kode_sub_kegiatan.unique' => 'Kode Sub Kegiatan Sudah Ada'
        ]);

        $subKegiatan = subActivity::findOrFail($id);
        $subKegiatan->update($request->all());

        return back()->with('success', 'Sub Kegiatan Berhasil Diubah');
    }

    public function deleteSubActivity($id)
    {
        $subActivity = \App\Models\SubActivity::findOrFail($id);
        $subActivity->delete(); 
        return back()->with('success', 'Sub-Kegiatan berhasil dihapus');
    }
    // Nanti bisa ditambah fungsi storeActivity dan storeSubActivity di sini
}