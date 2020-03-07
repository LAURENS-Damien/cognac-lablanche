<?php
function theme_js(){

wp_enqueue_style( 'app.css',
get_template_directory_uri() . '/app.css',
array() );

wp_enqueue_style( 'chunk-vendors.css',
get_template_directory_uri() . '/chunk-vendors.css',
array() );
 
wp_enqueue_script( 'chunk-vendors.js',
get_template_directory_uri() . '/chunk-vendors.js',
array() );

wp_enqueue_script( 'app.js',
get_template_directory_uri() . '/app.js',
array() );

// $starter_content = array(
	// 'attachments' => array(
		// 'image-logo'   => array(
			// 'post_title' => _x( 'Logo', 'Theme starter content', 'twentyseventeen' ),
			// 'file'       => 'img/logo.80f46b45.png',
		// ),
	// ),
// );
}
 
add_action( 'wp_footer', 'theme_js' );

function get_paragraph($content) {
	$start = strpos($content, "<!-- wp:paragraph -->") + 22;
	$end = strpos($content, "<!-- /wp:paragraph -->");
	$paragraph = substr($content, $start, $end - $start);
	return $paragraph;
	
}

function get_image($content) {
	$start = strpos($content, "<figure");
	$end = strpos($content, "/figure>") + 8;
	$image = substr($content, $start, $end - $start);
	return $image;
	
}

function get_home_page() {
	$page = get_page_by_path('accueil', OBJECT, 'page');

	$home_page["id"] = $page->ID;
	$home_page["title"] = $page->post_title;
	$home_page["content"] = get_paragraph($page->post_content);
	$home_page["image"] = get_image($page->post_content);

	if ( empty( $page ) ) {
		return null;
	}

	return $home_page;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/accueil', array(
	  'methods' => 'GET',
	  'callback' => 'get_home_page',
	) );
  } );
  
function get_historic() {
	$page = get_page_by_path('historique', OBJECT, 'page');

	$historic["id"] = $page->ID;
	$historic["title"] = $page->post_title;
	$historic["content"] = get_paragraph($page->post_content);
	$historic["image"] = get_image($page->post_content);

	if ( empty( $page ) ) {
		return null;
	}

return $historic;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/historique', array(
	  'methods' => 'GET',
	  'callback' => 'get_historic',
	) );
  } );
  
function get_vineyard_management() {
	$page = get_page_by_path('conduite-du-vignoble', OBJECT, 'page');

	$vineyard_management["id"] = $page->ID;
	$vineyard_management["title"] = $page->post_title;
	$vineyard_management["content"] = get_paragraph($page->post_content);
	$vineyard_management["image"] = get_image($page->post_content);

	if ( empty( $page ) ) {
		return null;
	}

return $vineyard_management;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/conduite-vignoble', array(
	  'methods' => 'GET',
	  'callback' => 'get_vineyard_management',
	) );
  } );  

function get_parking() {
	$page = get_page_by_path('parking-camping-car', OBJECT, 'page');

	$parking["id"] = $page->ID;
	$parking["title"] = $page->post_title;
	$parking["content"] = get_paragraph($page->post_content);
	$parking["image"] = get_image($page->post_content);

	if ( empty( $page ) ) {
		return null;
	}

return $parking;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/parking-camping-car', array(
	  'methods' => 'GET',
	  'callback' => 'get_parking',
	) );
  } );   
  
function get_catalog() {
	$parent_page_id = get_page_by_path('catalogue', OBJECT, 'page')->ID;
	$catalog = get_pages( array(
		'sort_column' => 'menu_order',
		'parent' => $parent_page_id,
	  ) );

	if ( empty( $catalog ) ) {
		return null;
	}
	   
	return $catalog;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/catalogue', array(
	  'methods' => 'GET',
	  'callback' => 'get_catalog',
	) );
  } );

function get_products_by_category( $data ) {
	 $parent_page_id = get_page_by_path('catalogue/'.$data['name'], OBJECT, 'page')->ID;
	 $children_pages = get_pages( array(
		'sort_column' => 'menu_order',
	 	'parent' => $parent_page_id,
	) );
		
	if ( empty( $children_pages ) ) {
		return null;
	}
		
	return $children_pages;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'wp/v2', '/catalogue/(?P<name>\S+)', array(
    'methods' => 'GET',
    'callback' => 'get_products_by_category',
  ) );
} );

function get_product( $data ) {
	$page = get_page_by_path('catalogue/'.$data['category'].'/'.$data['product'], OBJECT, 'page');
	
	$product["id"] = $page->ID;
	$product["title"] = $page->post_title;
	$product["image"] = get_image($page->post_content);
	// Les ACF sont récupérés directement dans le composant, à voir si on peut retourner proprement ici
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $product;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/produit/(?P<category>\S+)/(?P<product>\S+)', array(
   'methods' => 'GET',
   'callback' => 'get_product',
 ) );
} );

function get_photo() {
	$page =  get_page_by_path('catalogue', OBJECT, 'page');
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $page;
}

add_action( 'rest_api_init', function () {// Utile?
 register_rest_route( 'wp/v2', '/photo/(?P<pageId>\d+)', array(
   'methods' => 'GET',
   'callback' => 'get_photo',
 ) );
} );

function get_gallery() {
	$page =  get_page_by_path('galerie', OBJECT, 'page');

	$gallery["id"] = $page->ID;
	$gallery["title"] = $page->post_title;
	$gallery["content"] = $page->post_content;
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $gallery;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/galerie', array(
   'methods' => 'GET',
   'callback' => 'get_gallery',
 ) );
} );

function get_order() {
	$page =  get_page_by_path('commander', OBJECT, 'page');

	$order["id"] = $page->ID;
	$order["title"] = $page->post_title;
	$order["content"] = $page->post_content;
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $order;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/commander', array(
   'methods' => 'GET',
   'callback' => 'get_order',
 ) );
} );

function get_shop_presentation() {
	$page =  get_page_by_path('vente', OBJECT, 'page');

	$shopPresentation["id"] = $page->ID;
	$shopPresentation["title"] = $page->post_title;
	$shopPresentation["content"] = get_paragraph($page->post_content);
	$shopPresentation["image"] = get_image($page->post_content);
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $shopPresentation;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/presentation-magasin', array(
   'methods' => 'GET',
   'callback' => 'get_shop_presentation',
 ) );
} );

function get_contact() {
	$page =  get_page_by_path('contact', OBJECT, 'page');

	$contact["id"] = $page->ID;
	$contact["title"] = $page->post_title;
	$contact["content"] =$page->post_content;
	
    if ( empty( $page ) ) {
 	   return null;
    }
	   
   return $contact;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/contact', array(
   'methods' => 'GET',
   'callback' => 'get_contact',
 ) );
} );

function get_wp_datas() {
	$wpDatas["homePage"] = get_home_page();
	$wpDatas["historic"] = get_historic();
	$wpDatas["vineyardManagement"] = get_vineyard_management();
	$wpDatas["parking"] = get_parking();
	$wpDatas["catalog"] = get_catalog();
	$wpDatas["gallery"] = get_gallery();
	$wpDatas["order"] = get_order();
	$wpDatas["shopPresentation"] = get_shop_presentation();
	$wpDatas["contact"] = get_contact();

   return $wpDatas;
}

add_action( 'rest_api_init', function () {
 register_rest_route( 'wp/v2', '/wp-datas', array(
   'methods' => 'GET',
   'callback' => 'get_wp_datas',
 ) );
} );
