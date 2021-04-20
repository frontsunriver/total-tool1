<?php

 function productCategories(){
  $categories = recursivecategories();
  if($categories){
  $parent_id = 0;
  $option = '';

    foreach($categories as $parents){
      if($parents->slug==app('request')->input('category')){
        $selected = "selected";
      }else {
        $selected = "";
      }

      $option .= '<a class="dropdown-item categories-list '.$selected.'" value="'.$parents->categories_name.'" slug="'.$parents->slug.'" '.$selected.'>'.$parents->categories_name.'</a>';

        if(isset($parents->childs)){
          $i = 1;
          $option .= childcat($parents->childs, $i, $parent_id);
        }

    }

  echo $option;
}
}
 function childcat($childs, $i, $parent_id){
  $contents = '';
  foreach($childs as $key => $child){
    $dash = '';
    for($j=1; $j<=$i; $j++){
        $dash .=  '&nbsp;&nbsp;';
    }

    if($child->slug==app('request')->input('category')){
      $selected = "selected";
    }else {
      $selected = "";
    }

    $contents.='<a class="dropdown-item categories-list '.$selected.'"  value="'.$child->categories_name.'" slug="'.$child->slug.'" '.$selected.'>'.$dash.$child->categories_name.'</a>';
    if(isset($child->childs)){

      $k = $i+1;
      $contents.= childcat($child->childs,$k,$parent_id);
    }
    elseif($i>0){
      $i=1;
    }

  }
  return $contents;
}


 function recursivecategories(){
  $items = DB::table('categories')
      ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
      ->select('categories.categories_id', 'categories.categories_slug as slug','categories_description.categories_name', 'categories.parent_id')
      ->where('categories_description.language_id','=', Session::get('language_id'))
      ->where('categories.categories_status','=', 1)
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
