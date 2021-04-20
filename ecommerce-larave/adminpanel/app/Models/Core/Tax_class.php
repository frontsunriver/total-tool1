<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Tax_class extends Model
{
    use Sortable;
    protected $table = 'tax_class';
    public $sortable = ['tax_class_id','tax_class_title','tax_class_description','created_at'];

    public function paginator(){
      $taxClass = Tax_class::sortable(['tax_class_id'=>'ASC'])->paginate(10);
      return $taxClass;
    }

    public function getter(){
      $taxClass = Tax_class::sortable(['tax_class_id'=>'ASC'])->get();
      return $taxClass;
    }

     public function insert($request){
       DB::table('tax_class')->insert([
           'tax_class_title'  		 =>   $request->tax_class_title,
           'tax_class_description'	 =>   $request->tax_class_description,
           'created_at'	 		 =>   date('Y-m-d H:i:s')
       ]);
     }

     public function edit($request){
        $taxClass = Tax_class::where('tax_class_id', $request->id)->first();
        return $taxClass;
     }

     public function updatetrecord($request){
         DB::table('tax_class')->where('tax_class_id', $request->tax_class_id)->update([
             'tax_class_title'  		 =>   $request->tax_class_title,
             'tax_class_description'	 =>   $request->tax_class_description,
             'updated_at'	 		 =>   date('Y-m-d H:i:s')
         ]);
     }

     public function deletetaxclass($request){
       DB::table('tax_class')->where('tax_class_id', $request->id)->delete();
     }

     public function filter($request){
       $name = $request->FilterBy;
       $param = $request->parameter;

       switch ( $name ) {
           case 'Title':
              $tax_class = Tax_class::sortable(['tax_class_id'=>'ASC'])->where('tax_class_title', 'LIKE', '%' . $param . '%')->paginate(40);
              break;

           case 'Description':
               $tax_class = Tax_class::sortable(['tax_class_id'=>'ASC'])->where('tax_class_description', 'LIKE', '%' . $param . '%')->paginate(40);
               break;
           default :
               $tax_class = $this->paginator();
               break;
       }

       return $tax_class;
     }

}
