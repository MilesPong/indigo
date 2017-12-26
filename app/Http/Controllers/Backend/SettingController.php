<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Contracts\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends BackendController
{
    /**
     * @var SettingRepository
     */
    protected $settingRepository;

    /**
     * SettingController constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->settingRepository->paginate();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|unique:settings,key',
            'value' => 'required',
            'tag' => 'required',
        ]);

        $setting = $this->settingRepository->create($request->all());

        return $this->successCreated($setting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
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
        $setting = $this->settingRepository->find($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
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

        $setting = $this->settingRepository->update($request->all(), $id);

        return $this->successCreated($setting);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->settingRepository->delete($id);

        return $this->successDeleted();
    }
}
