<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;


class KelurahanController extends Controller
{
    public function index(Request $request){
        $data['title'] = 'Data Kelurahan';
        $data['menu'] = 'kelurahan';
        if ($request->ajax()) {
            $data = Kelurahan::with('kecamatan')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" onclick="editForm(\'' . $row->kode_kelurahan . '\')" style="margin-right: 5px;" class="btn btn-warning "><i class="fa fa-edit me-0"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteForm(\'' . $row->kode_kelurahan . '\')" style="margin-right: 5px;" class="btn btn-danger "><i class="fa fa-trash me-0"></i></a>';
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('data-master.kelurahan.main', $data);
    }
    public function create(Request $request){ 
        try {
            $data['data'] = (!empty($request->id)) ? Kelurahan::find($request->id) : "";
            $data['kecamatan'] = Kecamatan::where('is_active', 'Y')->get();
            $content = view('data-master.kelurahan.form', $data)->render();
            return ['status' => 'success', 'content' => $content,'data' => $data];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'success', 'content' => '', 'errMsg' => $e];
        }
    }
    
    public function store(Request $request){
        // return $request->all();
        try {
            $request->validate([
                'kecamatan_id' => 'required',
                'kode_kelurahan' => 'required',
                'nama_kelurahan' => 'required',
            ]);
            $data = [
                'kecamatan_id' => $request->kecamatan_id,
                'kode_kelurahan' => $request->kode_kelurahan,
                'nama_kelurahan' => $request->nama_kelurahan,
                'is_active' => $request->is_active,
            ];
            if (!empty($request->id)) {
                Kelurahan::where('kode_kelurahan', $request->id)->update($data);

            } else {
                $newData = New Kelurahan;
                $newData->kode_kelurahan = $request->kode_kelurahan;
                $newData->nama_kelurahan = $request->nama_kelurahan;
                $newData->kecamatan_id = $request->kecamatan_id;
                $newData->is_active = $request->is_active;
                $newData->save();
            }
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }

    public function delete(Request $request){
        try {
            Kelurahan::where('kode_kelurahan', $request->id)->delete();
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }
}
