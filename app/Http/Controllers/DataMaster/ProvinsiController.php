<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;


class ProvinsiController extends Controller
{
    public function index(Request $request){
        $data['title'] = 'Data Provinsi';
        if ($request->ajax()) {
            $data = Provinsi::orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" onclick="editForm(\'' . $row->kode_provinsi . '\')" style="margin-right: 5px;" class="btn btn-warning "><i class="fa fa-edit me-0"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteForm(\'' . $row->kode_provinsi . '\')" style="margin-right: 5px;" class="btn btn-danger "><i class="fa fa-trash me-0"></i></a>';
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('data-master.provinsi.main', $data);
    }
    public function create(Request $request){ 
        try {
            $data['data'] = (!empty($request->id)) ? Provinsi::find($request->id) : "";
            $content = view('data-master.provinsi.form', $data)->render();
            return ['status' => 'success', 'content' => $content,'data' => $data];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'success', 'content' => '', 'errMsg' => $e];
        }
    }
    
    public function store(Request $request){
        try {
            $request->validate([
                'kode_provinsi' => 'required',
                'nama_provinsi' => 'required',
            ]);
            $data = [
                'kode_provinsi' => $request->kode_provinsi,
                'nama_provinsi' => $request->nama_provinsi,
                'is_active' => $request->is_active,
            ];
            if (!empty($request->id)) {
                Provinsi::where('kode_provinsi', $request->id)->update($data);
            } else {
                Provinsi::create($data);
            }
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }

    public function delete(Request $request){
        try {
            Provinsi::where('kode_provinsi', $request->id)->delete();
            return ['status' => 'success', 'content' => '', 'errMsg' => ''];
        } catch (\Exception $e) {
            throw ($e);
            return ['status' => 'error', 'content' => '', 'errMsg' => $e];
        }
    }
}
