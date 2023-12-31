<?php

namespace App\Http\Controllers\AdminUi;

use App\Http\Controllers\Controller;
use App\Services\currency\CurrencyServiceQueryImpl;
use App\Services\document_type\Document_typeServiceQueryImpl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\course\CourseServiceImpl;
use App\Services\course\CourseServiceQueryImpl;
use App\Services\course_category\Course_categoryServiceQueryImpl;
use App\Services\user\UserServiceQueryImpl;
use Flores\WebApi;
use Illuminate\Http\Request;
use stdClass;

class CourseController extends Controller
{
    private $courseService;
    private $courseServiceQuery;
    function __construct()
    {
        $this->courseService = new CourseServiceImpl();
        $this->courseServiceQuery = new CourseServiceQueryImpl();
    }
    public function add(Request $request)
    {
        $data = new stdClass();
        foreach ($request->all() as $key => $value) {
            $data->{$key} = $value;
        }
        $data->code = code(null, __METHOD__);
        try {
            $this->courseService->add($data);



            if (is_countable($request->get("document_type_id"))) {
                $course = $this->courseServiceQuery->findByCode($data->code);
                foreach ($data->document_type_id as $i => $value) {
                    $code = code(null, __METHOD__ . $i);
                    DB::table("course_needed_doc")->insert([
                        'code' => $code,
                        'course_id' => $course->id,
                        'document_type_id' => $value,
                    ]);
                }
            }









            return (new WebApi())->setSuccess()->notify(__("Operación realizada con éxito"))->resync()->close_modal()->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function update(Request $request)
    {
        $data = new stdClass();
        $contacts = [];
        foreach ($request->all() as $key => $value) {
            $data->{$key} = $value;
        }
        try {
            $course = $this->courseServiceQuery->deleted(false)->orderDesc()->findById($request->get('id'));
            DB::table("course_needed_doc")->where("course_id", $course->id)->delete();

            if (is_countable($request->get("document_type_id"))) {
                foreach ($data->document_type_id as $i => $value) {
                    $code = code(null, __METHOD__ . $i);
                    DB::table("course_needed_doc")->insert([
                        'code' => $code,
                        'course_id' => $course->id,
                        'document_type_id' => $value,
                    ]);
                }
            }


            $this->courseService->update($data);
            return (new WebApi())->setSuccess()->notify(__("Actualización realizada con éxito"))->resync()->close_modal()->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function remove(Request $request)
    {
        try {
            $this->courseService->delete($request->get('id'));
            return (new WebApi())->setSuccess()->notify("Eliminación realizada con éxito")->resync()->close_modal()->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    #indexes
    public function index(Request $request)
    {
        try {

            $view = view('admin.fragments.course.listForm', [
                'course' => (new CourseServiceQueryImpl())->deleted(false)->orderDesc()->findAll()
            ])->render();
            return (new WebApi())->setSuccess()->print($view)->save()->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function addIndex(Request $request)
    {
        try {
            $view = view('admin.fragments.course.addForm', [
                'currency' => (new CurrencyServiceQueryImpl())->deleted(false)->orderDesc()->findAll(),
                'course_category' => (new Course_categoryServiceQueryImpl)->deleted(false)->orderDesc()->findAll(),
                'document_type' => (new Document_typeServiceQueryImpl())->deleted(false)->orderDesc()->findAll(),
            ])->render();
            return (new WebApi())->setSuccess()->print($view, 'modal')->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function updateIndex(Request $request)
    {
        try {
            $course = $this->courseServiceQuery->deleted(false)->orderDesc()->findById($request->get('id'));

            $view = view('admin.fragments.course.editForm', [
                'course' => $course,
                'currency' => (new CurrencyServiceQueryImpl())->deleted(false)->orderDesc()->findAll(),
                'course_category' => (new Course_categoryServiceQueryImpl)->deleted(false)->orderDesc()->findAll(),
                'document_type' => (new Document_typeServiceQueryImpl())->deleted(false)->orderDesc()->findAll(),
            ])->render();
            return (new WebApi())->setSuccess()->print($view, 'modal')->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function detailIndex(Request $request)
    {
        try {
            $course = $this->courseServiceQuery->deleted(false)->orderDesc()->findById($request->get('id'));
            $view = view('admin.fragments.course.detailForm', [
                'course' => $course
            ])->render();
            return (new WebApi())->setSuccess()->print($view, 'modal')->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
    public function settingsIndex(Request $request)
    {
        try {
            $view = view('admin.fragments.course.settingsForm', [])->render();
            return (new WebApi())->setSuccess()->print($view)->get();
        } catch (\Exception $e) {
            return (new WebApi())->setStatusCode($e->getCode())->alert($e->getMessage())->get();
        }
    }
}
