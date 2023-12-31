<?php

namespace App\Services\currency;

use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



use stdClass;
use Flores;




class CurrencyServiceQueryImpl implements ICurrencyServiceQuery
{

    private $table =  'currency';
    private $query;

    public function __construct()
    {
        $this->query = DB::table($this->table);
    }
    
    


    public function active($bool = true)
    {
            $this->query->where($this->table . '.active',$bool);
        return $this;
    }   
     

    public function deleted($bool = true)
    {
        if ($bool===true) {
            $this->query->where($this->table . '.deleted_at','!=',null);
        }else {
            $this->query->where($this->table . '.deleted_at',null);
        }
        return $this;
    }  

    public function orderDesc()
    {
        $this->query->orderByDesc($this->table . '.created_at');
        return $this;
    }
 
    public function findAll()
    {
        return $this->query->get();
    }

    public function findById($id)
    {
        return $this->query->where($this->table . '.id', $id)->first();
    }
    public function findByCode($id)
    {
        return $this->query->where($this->table . '.code', $id)->first();
    } 
}
