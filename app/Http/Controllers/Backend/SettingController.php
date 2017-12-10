<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Contracts\SettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * @var SettingRepository
     */
    protected $settingRepo;

    /**
     * SettingController constructor.
     * @param SettingRepository $settingRepo
     */
    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepo = $settingRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->settingRepo->paginate();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|unique:settings,key',
            'value' => 'required',
            'tag' => 'required',
        ]);

        $this->settingRepo->create($request->all());

        return redirect()->route('admin.settings.index')->withSuccess('Create setting successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = $this->settingRepo->find($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'key' => [
                'required',
                Rule::unique('settings')->ignore($id)
            ],
            'value' => 'required',
            'tag' => 'required',
        ]);

        $this->settingRepo->update($request->all(), $id);

        return redirect()->route('admin.settings.index')->withSuccess('Update setting successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->settingRepo->delete($id);

        return redirect()->route('admin.settings.index')->withSuccess('Delete setting successfully!');
    }
}
