<?php
add_image_size( 'xs', 576 );
add_image_size( 'sm', 768 );
add_image_size( 'md', 992 );
add_image_size( 'lg', 1200 );
add_image_size( 'xl', 1400 );

function theme_js()
{
    wp_enqueue_style('app.css',
        get_template_directory_uri() . '/app.css',
        array());

    wp_enqueue_style('chunk-vendors.css',
        get_template_directory_uri() . '/chunk-vendors.css',
        array());

    wp_enqueue_script('chunk-vendors.js',
        get_template_directory_uri() . '/chunk-vendors.js',
        array());

    wp_enqueue_script('app.js',
        get_template_directory_uri() . '/app.js',
        array());
}

add_action('wp_footer', 'theme_js');

function get_paragraph($content)
{
    $start = strpos($content, "<!-- wp:paragraph -->") + 22;
    $end = strpos($content, "<!-- /wp:paragraph -->");

    return substr($content, $start, $end - $start);
}

function get_title($content)
{
    $start = strpos($content, "<!-- wp:heading -->") + 20;
    $end = strpos($content, "<!-- /wp:heading -->");

    return substr($content, $start, $end - $start);
}

function get_image($content)
{
    $start = strpos($content, "<figure");
    $end = strpos($content, "/figure>") + 8;

    return get_img_tag(substr($content, $start, $end - $start));
}

function get_image_without_lazy_loading($content) {
    $start = strpos($content, "<figure");
    $end = strpos($content, "/figure>") + 8;
    $image = substr($content, $start, $end - $start);
    return $image;
}

function get_zig_zag($content): array
{
    $zig_zag = [];

    $titles = get_titles($content);
    $paragraphs = get_paragraphs($content);
    $images = get_images($content);

    $number_paragraphs = count($paragraphs);

    for ($i = 0; $i < $number_paragraphs; $i++) {
        array_push($zig_zag, [$titles[$i], $images[$i], $paragraphs[$i]]);
    }

    return $zig_zag;
}

function get_paragraphs($content): array
{
    $numbers_paragraphs = substr_count($content, '<!-- wp:paragraph -->');
    $paragraphs = [];

    for ($i = 0; $i < $numbers_paragraphs; $i++) {
        $paragraph = get_paragraph($content);
        $paragraphs[] = $paragraph;
        $content = str_replace($paragraph, "", $content);
        $content = preg_replace('/<!-- wp:paragraph -->/', '', $content, 1);
        $content = preg_replace('/<!-- \/wp:paragraph -->/', '', $content, 1);
    }

    return $paragraphs;
}

function get_titles($content): array
{
    $numbers_titles = substr_count($content, '<!-- wp:heading -->');
    $titles = [];

    for ($i = 0; $i < $numbers_titles; $i++) {
        $title = get_title($content);
        $titles[] = $title;
        $content = str_replace($title, "", $content);
        $content = preg_replace('/<!-- wp:heading -->/', '', $content, 1);
        $content = preg_replace('/<!-- \/wp:heading -->/', '', $content, 1);
    }

    return $titles;
}

function get_images($content): array
{

    $numbers_images = substr_count($content, '<figure');
    $images = [];

    for ($i = 0; $i < $numbers_images; $i++) {
        $image = get_image_without_lazy_loading($content);
        $images[] = $image;
        $content = str_replace($image, "", $content);
    }

    return $images;
}

function get_home_page(): ?array
{
    $page = get_page_by_path('accueil');

    $home_page["id"] = $page->ID;
    $home_page["title"] = $page->post_title;
    $home_page["content"] = get_paragraph($page->post_content);
    $home_page["image"] = get_image($page->post_content);

    if (empty($page)) {
        return null;
    }

    return $home_page;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/accueil', array(
        'methods' => 'GET',
        'callback' => 'get_home_page',
    ));
});

function get_historic(): ?array
{
    $page = get_page_by_path('historique');

    $historic["title"] = $page->post_title;
    $historic["content"] = get_paragraph($page->post_content);
    $historic["image"] = get_image($page->post_content);

    if (empty($page)) {
        return null;
    }

    return $historic;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/historique', array(
        'methods' => 'GET',
        'callback' => 'get_historic',
    ));
});

function get_vineyard_management(): ?array
{
    $page = get_page_by_path('conduite-du-vignoble');
    $vineyard_management["title"] = $page->post_title;
    $vineyard_management["zigzag"] = get_zig_zag($page->post_content);

    if (empty($page)) {
        return null;
    }

    return $vineyard_management;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/conduite-du-vignoble', array(
        'methods' => 'GET',
        'callback' => 'get_vineyard_management',
    ));
});

function get_parking(): ?array
{
    $page = get_page_by_path('parking-camping-car');

    $parking["title"] = $page->post_title;
    $parking["content"] = get_paragraph($page->post_content);
    $parking["image"] = get_image($page->post_content);

    if (empty($page)) {
        return null;
    }

    return $parking;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/parking-camping-car', array(
        'methods' => 'GET',
        'callback' => 'get_parking',
    ));
});

function get_catalog()
{
    $parent_page_id = get_page_by_path('catalogue')->ID;
    $pages = get_pages(array(
        'sort_column' => 'menu_order',
        'parent' => $parent_page_id,
    ));

    $catalog = [];

    for ($i = 0; $i < count($pages); $i++) {
        array_push($catalog, (object)[
            'categoryTitle' => $pages[$i]->post_title,
            'categoryName' => $pages[$i]->post_name,
            'selected' => $i === 0
        ]);
    }

    if (empty($pages)) {
        return null;
    }

    return $catalog;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/catalogue', array(
        'methods' => 'GET',
        'callback' => 'get_catalog',
    ));
});

function get_products_by_category($data)
{
    $parent_page_id = get_page_by_path('catalogue/' . $data['name'])->ID;
    $children_pages = get_pages(array(
        'sort_column' => 'menu_order',
        'parent' => $parent_page_id,
    ));

    if (empty($children_pages)) {
        return null;
    }

    return $children_pages;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/catalogue/(?P<name>\S+)', array(
        'methods' => 'GET',
        'callback' => 'get_products_by_category',
    ));
});

function get_product($data): ?array
{
    $page = get_page_by_path('catalogue/' . $data['category'] . '/' . $data['product']);

    $product["id"] = $page->ID;
    $product["title"] = $page->post_title;
//     $product["image"] = get_image($page->post_content);
    $product["image"] = create_responsive_image($page->post_content, $page);

    // Les ACF sont récupérés directement dans le composant, à voir si on peut retourner proprement ici

    if (empty($page)) {
        return null;
    }

    return $product;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/produit/(?P<category>\S+)/(?P<product>\S+)', array(
        'methods' => 'GET',
        'callback' => 'get_product',
    ));
});

function get_photo()
{
    $page = get_page_by_path('catalogue');

    if (empty($page)) {
        return null;
    }

    return $page;
}

add_action('rest_api_init', function () {// Utile?
    register_rest_route('wp/v2', '/photo/(?P<pageId>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_photo',
    ));
});

function get_gallery(): ?array
{
    $page = get_page_by_path('galerie');

    $gallery["title"] = $page->post_title;
    $gallery["content"] = $page->post_content;

    if (empty($page)) {
        return null;
    }

    return $gallery;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/galerie', array(
        'methods' => 'GET',
        'callback' => 'get_gallery',
    ));
});

function get_order(): ?array
{
    $page = get_page_by_path('commander');

    $order["title"] = $page->post_title;
    $order["content"] = $page->post_content;

    if (empty($page)) {
        return null;
    }

    return $order;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/commander', array(
        'methods' => 'GET',
        'callback' => 'get_order',
    ));
});

function get_shop_presentation(): ?array
{
    $page = get_page_by_path('vente');

    $shopPresentation["title"] = $page->post_title;
    $shopPresentation["content"] = get_paragraph($page->post_content);
    $shopPresentation["image"] = get_image($page->post_content);

    if (empty($page)) {
        return null;
    }

    return $shopPresentation;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/presentation-magasin', array(
        'methods' => 'GET',
        'callback' => 'get_shop_presentation',
    ));
});

function get_contact(): ?array
{
    $page = get_page_by_path('contact');

    $contact["title"] = $page->post_title;
    $contact["content"] = $page->post_content;

    if (empty($page)) {
        return null;
    }

    return $contact;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/contact', array(
        'methods' => 'GET',
        'callback' => 'get_contact',
    ));
});

function get_wp_datas(): array
{
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

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/wp-datas', array(
        'methods' => 'GET',
        'callback' => 'get_wp_datas',
    ));
});

function get_img_tag($content)
{
    $position = strpos($content, "<img") + 5;

    return add_lazy_loading($content, 'loading="lazy" ', $position);
}

function add_lazy_loading($str,$insertstr,$pos)
{
    $count_str=strlen($str);
    for ($i=0; $i<$pos; $i++) {
        $new_str .= $str[$i];
    }

    $new_str .="$insertstr";

    for ($i=$pos; $i<$count_str; $i++) {
        $new_str .= $str[$i];
    }

    return $new_str;
}

function test_create_responsive_image($data): ?array
{
    $page = get_page_by_path('catalogue/' . $data['category'] . '/' . $data['product']);

    $product["id"] = $page->ID;
    $product["title"] = $page->post_title;
    $product["image"] = create_responsive_image($page->post_content, $page);
    // Les ACF sont récupérés directement dans le composant, à voir si on peut retourner proprement ici

    if (empty($page)) {
        return null;
    }

    return $product;
}

function get_image_id($content)
{
    $start = strpos($content, "<!-- wp:image {\"id\":") + 20;
    $end = strpos($content, ",");

    return substr($content, $start, $end - $start);
}

function create_responsive_image($image, $page) {
    $image_src = get_image_src($image);
    $image_id = get_image_id($page->post_content);
    $img_xs = wp_get_attachment_image_src($image_id, 'xs')[0];
    $img_sm = wp_get_attachment_image_src($image_id, 'sm')[0];
    $img_md = wp_get_attachment_image_src($image_id, 'md')[0];
    $img_lg = wp_get_attachment_image_src($image_id, 'lg')[0];
    $img_xl = wp_get_attachment_image_src($image_id, 'xl')[0];

    return '<picture class="wp-block-image size-full">
<source media="(max-width: 575px)" srcset="'. $img_xs .'"/>
<source media="(min-width: 576px) and (max-width: 767px)" srcset="'. $img_sm .'"/>
<source media="(min-width: 768px) and (max-width: 991px)" srcset="'. $img_md .'"/>
<source media="(min-width: 992px) and (max-width: 1199px)" srcset="'. $img_lg .'"/>
<source media="(min-width: 1200px)" srcset="'. $img_xl .'"/>
<img loading="lazy" alt="" src="'. $image_src .'"/>
</picture>';
}

function get_image_src($image) {
    $regex_result = array();
    preg_match( '/<img src="([^"]*)"/i', $image, $regex_result);

    return $regex_result[1];
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/test/(?P<category>\S+)/(?P<product>\S+)', array(
        'methods' => 'GET',
        'callback' => 'test_create_responsive_image',
    ));
});

// function get_image_url($image_src, $image_name) {
//     $image_url = str_replace($image_name, "", $image_src);
//     return $image_url;
// }
//
// function get_image_name($image_src) {
//     $regex_result = array();
//     preg_match( '/([\w\d_-]*)\.?[^\\\\\/]*$/i', $image_src, $regex_result);
//     return $regex_result[0];
// }
//
// function get_image_extension($image_src) {
//     $regex_result = array();
//     preg_match( '/([\w\d_-]*)\.?$/i', $image_src, $regex_result);
//     return $regex_result[0];
// }
