<?php

 function productCategories2(){
  $categories = recursivecategories2();
  if($categories){
  $parent_id = 0;
  $option = '<option value="">'. Lang::get("website.Categories").'</option>';

    foreach($categories as $parents){
      if($parents->slug==app('request')->input('category')){
        $selected = "selected";
      }else {
        $selected = "";
      }

      $option .= '<option value="'.$parents->slug.'" '.$selected.'>'.$parents->categories_name.'</option>';

        if(isset($parents->childs)){
          $i = 1;
          $option .= childcat2($parents->childs, $i, $parent_id);
        }

    }

  echo $option;
}
}
 function childcat2($childs, $i, $parent_id){
  $contents = '';
  foreach($childs as $key => $child){
    $dash = '';
    for($j=1; $j<=$i; $j++){
        $dash .=  '-';
    }

    if($child->slug==app('request')->input('category')){
      $selected = "selected";
    }else {
      $selected = "";
    }

    $contents.='<option value="'.$child->slug.'" '.$selected.'>'.$dash.$child->categories_name.'</option>';
    if(isset($child->childs)){

      $k = $i+1;
      $contents.= childcat2($child->childs,$k,$parent_id);
    }
    elseif($i>0){
      $i=1;
    }

  }
  return $contents;
}


 function recursivecategories2(){
  $items = DB::table('categories')
      ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
      ->select('categories.categories_id', 'categories.categories_slug as slug','categories_description.categories_name', 'categories.parent_id')
      ->where('categories.categories_status','=', 1)
      ->where('categories_description.language_id','=', Session::get('language_id'))
      ->get();
   if($items->isNotEmpty()){
      $childs = array();
      foreach($items as $item)
          $childs[$item->parent_id][] = $item;

      foreach($items as $item) if (isset($childs[$item->categories_id]))
          $item->childs = $childs[$item->categories_id];

      $tree = $childs[0];
      return  $tree;
    }
}

 ?>
