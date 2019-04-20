<?php

namespace App\Admin\Controllers;

use App\Sport;
use App\Http\Controllers\Controller;
use App\Sporter;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SportController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Sport);

        $grid->filter(function ($filter) {
            $filter->equal('sporter_id')->select('/api/sporters');
            $filter->disableIdFilter();
        });

        $grid->id('Id');
        $grid->sporter_id('姓名')->display(function ($spoter_id) {
            return Sporter::find($spoter_id)->name ?? '未知';
        });
        $grid->date('日期');
        $grid->recommend('推荐');

        $grid->result('结果')->display(function ($result) {
            $map = [
                0 => "<span class='btn btn-danger'>红</span>",
                1 => "<span class='btn btn-success'>黑</span>",
                2 => "<span class='btn btn-info'>水</span>"
            ];
            return $map[$result];
        });

        // $grid->result('结果');

        // $grid->created_at('Created at');
        // $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Sport::findOrFail($id));

        $show->id('Id');
        $show->sporter_id('姓名');
        $show->date('日期');
        $show->recommend('推荐');
        $show->result('结果');
        // $show->created_at('Created at');
        // $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Sport);

        $form->select('sporter_id', '姓名')->options('/api/sporters');
        $form->date('date', '日期')->default(date('Y-m-d'));
        $form->text('recommend', '推荐');
        $states = [
            2 => '水',
            0 => '红',
            1 => '黑',
        ];

        $form->select('result', '结果')->options($states);
        // $form->switch('result', '结果')->default(2);

        return $form;
    }
}
