<?php

namespace App\Http\Controllers;

use App\ImgList;
use Illuminate\Http\Request;

class ImgListController extends Controller
{
    private $img_list;

    public function __construct(ImgList $imgList)
    {
        $this->img_list = $imgList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImgList $imgList)
    {
        $ret = $imgList->insert([
            'media_id' => $request->get('media_id'),
            'url' => $request->get('url'),
            'type' => (int)$request->get('type'),

        ]);
        if ($ret) {
            return response('插入成功');
        }

        return response('插入失败');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ImgList $imgList
     * @return \Illuminate\Http\Response
     */
    public function show(ImgList $imgList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ImgList $imgList
     * @return \Illuminate\Http\Response
     */
    public function edit(ImgList $imgList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ImgList $imgList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImgList $imgList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ImgList $imgList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImgList $imgList)
    {
        //
    }

    public function getImages()
    {
        $lists = $this->img_list->where('type', 4)->limit(100)->get();
        return response()->json($lists);
    }

    public function upload(Request $request, ImgList $imgList)
    {
        $path = $request->file('file')->store('images');

        $ret = $this->img_list->insert([
            'media_id' => '',
            'url' => $path,
            'type' => 5,
        ]);
        if ($ret) {
            return response('插入成功');
        }

        return response('插入失败');
    }
}
