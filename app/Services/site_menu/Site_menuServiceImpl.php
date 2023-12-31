<?php

namespace App\Services\site_menu;

use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;

use stdClass;
use Flores;


/** @author Nelson Flores | nelson.flores@live.com */

class Site_menuServiceImpl implements ISite_menuService
{
    private $insertFillables = [
        'name',
        'session_name',
        'code',
        'parent_menu_id',
        'route',
        'uri',
        'prefer',
        'icon_class',
        'order_index',
        'target',
    ];
    private $updateFillables = [
        'name',
        'session_name',
        'code',
        'parent_menu_id',
        'route',
        'uri',
        'prefer',
        'order_index',
        'icon_class',
        'target',
    ];
    private $table =  'site_menu';

    public function add($data)
    {

        if (empty($data->name)) {
            throw new \Exception(__('Nome invalido'), 400);
        }


        $payload = new stdClass();
        $data->code = code(empty($data->code) ? null : $data->code, __method__);

        foreach ($data as $i => $value) {
            if (in_array($i, $this->insertFillables)) {
            $payload->{$i} = $data->{$i};
            }
        }


        $site_menu = DB::table($this->table)->where('name', $data->name)->first();

        if (!empty($site_menu->id)) {
            throw new \Exception(__('Nome invalido'), 400);
        }



        $site_menu = DB::table($this->table)->where('code', $data->code)->first();

        if (!empty($site_menu->id)) {
            throw new \Exception(__('Codigo invalido'), 400);
        }

        $arr = json_decode(json_encode($payload), true);


        DB::table($this->table)->insert($arr);
    }

    public function update($data)
    {
        if (empty($data->id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }


        $payload = new stdClass();

        foreach ($data as $i => $value) {
            if (in_array($i, $this->updateFillables)) {
            $payload->{$i} = $data->{$i};
            }
        }

        $site_menu = DB::table($this->table)->where('id', $data->id)->first();
        if (empty($site_menu->id)) {
            throw new \Exception(__('Conteudo nao encontrado'), 404);
        }

        $arr = json_decode(json_encode($payload), true);



        $arr['updated_at'] = DB::raw('now()');

        DB::table($this->table)->where('id', $data->id)->update($arr);
    }
    public function trash($id)
    {
        if (empty($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        if (!is_numeric($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        DB::table($this->table)->where('id', $id)->update(['deleted_at' => DB::raw('now()')]);
    }
    public function restore($id)
    {
        if (empty($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        if (!is_numeric($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        DB::table($this->table)->where('id', $id)->update(['deleted_at' => null]);
    }
    public function delete($id)
    {
        if (empty($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        if (!is_numeric($id)) {
            throw new \Exception(__('Entrada Invalida'), 400);
        }

        DB::table($this->table)->where('id', $id)->delete();
    }
}
