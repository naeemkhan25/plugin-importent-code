
<?php$termsOption='';
    $_terms=get_terms(array(
        'taxonomy'=>'category'
    ));
   foreach ($_terms as $term){
       $termsOption.=sprintf('<option value="%s">%s</option>',$term->term_id,$term->name);
   }