<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


        public function index(Request $request)
    {
        $records = Client::where(function($query) use($request){
            if ($request->input('district_id')) {
              $query->where('district_id',$request->district_id);
            }
            if ($request->input('search_by_name')) {
              $query->where(function($query) use($request){
                $query->where('name','like','%'.$request->search_by_name.'%');
              });
            }
          })->paginate(20);

        return view('admin.clients.index', compact('records'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = Client::findOrFail($id);
      $record->delete();
      flash('تم الحذف')->error();
      return back();
    }
    public function active($id)
    {
      $record = Client::findOrFail($id);
      $record->activation ='active';
      $record->save();
      flash('تم التنشيط')->success();
      return redirect(route('client.index'));
     }
     public function deactive($id)
     {
       $record = Client::findOrFail($id);
       $record->activation ='deactive';
       $record->save();
       flash('تم الغاء التنشيط')->error();
       return redirect(route('client.index'));
      }
}
