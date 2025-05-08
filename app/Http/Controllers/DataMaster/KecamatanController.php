<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;


class KecamatanController extends Controller
{
    public function index(Request $request){
        $data['title'] = 'Data Kecamatan';
        if ($request->ajax()) {
            $data = Kecamatan::orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" onclick="editForm(\'' . $row->kode_kecamatan . '\')" style="margin-right: 5px;" class="btn btn-warning "><i class="fa fa-edit me-0"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteForm(\'' . $row->kode_kecamatan . '\')" style="margin-right: 5px;" class="btn btn-danger "><i class="fa fa-trash me-0"></i></a>';
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('data-master.kecamatan.main', $data);
    }
    public function create(Request $request){ 
        try {
            $data['data'] = (!empty($request->id)) ? Kecamatan::find($request->id) : "";
            $content = view('data-master.kecamatan.form', $data)->render();
            return ['status' => 'success', 'content' => $content,'data' => $data];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'success', 'content' => '', 'errMsg' => $e];
        }
    }
    
    public function store(Request $request){
        try {
            $request->validate([
                'kode_kecamatan' => 'required',
                'nama_kecamatan' => 'required',
            ]);
            $data = [
                'kode_kecamatan' => $request->kode_kecamatan,
                'nama_kecamatan' => $request->nama_kecamatan,
                'is_active' => $request->is_active,
            ];
            if (!empty($request->id)) {
                Kecamatan::where('kode_kecamatan', $request->id)->update($data);
            } else {
                Kecamatan::create($data);
            }
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }

    public function delete(Request $request){
        try {
            Kecamatan::where('kode_kecamatan', $request->id)->delete();
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }
}
