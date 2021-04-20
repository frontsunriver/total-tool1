<?php

 function shopCategories(){
  $categories = shopRecursivecategories();
  if($categories){
  $parent_id = 0;
  $option = '';
   // dd($categories);
    foreach($categories as $parents){

     $parent_slug  = $parents->slug;
     

     if(isset($parents->childs)){
        $hasChild = "href=#".$parents->slug."  data-toggle='collapse' role='button' aria-expanded='false' aria-controls='men-cloth'"; 
      }else {
        $hasChild = "href=".url('shop?category=').$parents->slug;;
      }

      $option .= '
       <a class=" main-manu"'. $hasChild .'> <img class="img-fuild" src="'.asset($parents->path).'"> '.$parents->categories_name.'</a>';

        if(isset($parents->childs)){
          $total = '';
          $i = 1;
          $option.=' <div class="sub-manu collapse multi-collapse" id="'.$parent_slug.'">
                       <ul class="unorder-list">';
          $option .= shopChildcat($parents->childs, $i, $parent_id);
           $option.=' </div>
                       </ul> ';
        }

    }

  echo $option;
}
}
 function shopChildcat($childs, $i, $parent_id){

  $contents = '';
  foreach($childs as $key => $child){
    $dash = '';
    for($j=1; $j<=$i; $j++){
        $dash .=  '&nbsp;&nbsp;';
    }

    $contents.= '<li class="list-item">
        <a class="list-link" href='.url('shop?category=').$child->slug.' > '.$dash.'
            <i class="fas fa-angle-right"></i>'.$child->categories_name.'
        </a>
      </li>';

    if(isset($child->childs)){
      $k = $i+1;
      $contents.= shopChildcat($child->childs,$k,$parent_id);
    }
    elseif($i>0){
      $i=1;
     
    }

  }
  return $contents;
}


 function shopRecursivecategories(){
  $items = DB::table('categories')
      ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
      ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
      ->select('categories.categories_id', 'categories.categories_slug as slug', 'image_categories.path as path', 'categories_description.categories_name', 'categories.parent_id', 'categories.categories_status')
      ->where('categories_description.language_id','=', Session::get('language_id'))
      ->where('categories.categories_status','=', 1)
      ->groupBy('categories.categories_id')
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
