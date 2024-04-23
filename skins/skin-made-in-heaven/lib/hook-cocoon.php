<?php
if (!defined('ABSPATH')) exit;


//******************************************************************************
//  タブ一覧表示件数変更
//******************************************************************************
add_filter('list_category_tab_args', function($args, $cat_id) {
  $args['posts_per_page'] = 12;
 
  return $args;
}, 10, 2);


//******************************************************************************
//  検索件数表示
//******************************************************************************
add_filter('get_archive_chapter_title', function($chapter_title) {
  global $wp_query;

  $chapter_title = preg_replace('/.*<\/span>/', '', $chapter_title);
  if (is_search()) {
    $count = 0;
    $chapter_title = str_replace('"', '', $chapter_title);
    if (have_posts()) {
      $count =  $wp_query->found_posts;
    }
    $chapter_title = $chapter_title . ' : ' .$count . '件ヒット';
  }
  $chapter_title = '<span class="list-title-in"><span>' . $chapter_title . '</span></span>';

  return $chapter_title;
});


//******************************************************************************
//  「もっと見る」「次のページ」「パンくず」テキスト変更
//******************************************************************************
add_filter('more_button_caption', function($caption) {
  return get_theme_mod('hvn_button_more_setting', 'もっと見る');
});


add_filter('pagination_next_link_caption', function($caption) {
  return get_theme_mod('hvn_button_next_setting', '次のページ');
});


add_filter('breadcrumbs_single_root_text', 'breadcrumbs_root_text_custom');
add_filter('breadcrumbs_page_root_text', 'breadcrumbs_root_text_custom');

if (!function_exists('breadcrumbs_root_text_custom')):
function breadcrumbs_root_text_custom(){
  return get_theme_mod('hvn_breadcrumbs_setting', 'ホーム');
}
endif;

//******************************************************************************
//  bodyクラス追加
//******************************************************************************
add_filter('body_class_additional', function($classes) {
  $classes[] = 'hvn';
  if (get_theme_mod('hvn_toc_setting')) {
    $classes[] = 'hvn-scroll-toc';
  }

  return $classes;
}, 999);


//******************************************************************************
//  SNSシェアボタン変更
//******************************************************************************
add_filter('get_additional_sns_share_button_classes', function($classes) {
  $classes = str_replace('bc-brand-color ', 'bc-brand-color-white ', $classes);

  return $classes;
});


//******************************************************************************
//  SNSフォローボタン変更
//******************************************************************************
add_filter('get_additional_sns_follow_button_classes', function($classes) {
  $classes = str_replace('bc-brand-color ', 'bc-brand-color-white ', $classes);

  return $classes;
});


//******************************************************************************
//  サイト開設経過日数
//******************************************************************************
add_filter('the_author_box_description', function($description, $user_id) {
  $date = get_theme_mod('hvn_site_date_setting');
  if ($date  && get_theme_mod('hvn_site_date_onoff_setting')) {
    $day = number_format(ceil(date_i18n('U') - strtotime($date)) / (24 * 60 * 60));
    $description .= "<p class=hvn_site_date>{$date}開設から{$day}日目です。</p>";
  }

  return $description;
}, 10, 2);


//******************************************************************************
//  エントリーカードいいねボタン
//******************************************************************************
add_action('entry_card_snippet_after', function($post_ID) {
  if (get_theme_mod('hvn_like_setting')) {
    echo hvn_like_tag($post_ID);
  }
});


add_filter('cocoon_part__tmp/date-tags', function($content) {
  if (is_single()  && get_theme_mod('hvn_like_setting')) {
    $post_ID = get_the_ID();
    $html = hvn_like_tag($post_ID);

    $content = str_replace('</div>', '</div></div>', $content);
    $content = str_replace('<div class="date-tags">', '<div class="date-tags">' . $html . '<div class="e-card-info">', $content);
  }

  return $content;
});


add_action('widget_entry_card_date_before', function($prefix, $post_ID) {
  if (get_theme_mod('hvn_like_setting')) {
    if ($prefix == WIDGET_NEW_ENTRY_CARD_PREFIX) {
      $post_ID = get_the_ID();
    }
    echo hvn_like_tag($post_ID);
  }
}, 10, 2);


//******************************************************************************
//  PV数表示変更
//******************************************************************************
add_filter('code_minify_call_back', function($html) {
  $html = preg_replace('/widget-entry-card-pv">([0-9]+) views?/', 'widget-entry-card-pv">$1', $html);

  return $html;
});


//******************************************************************************
//  メインビジュアル追加
//******************************************************************************
add_action('cocoon_part_before__tmp/appeal', function() {
  if ((get_theme_mod('hvn_header_setting', 'none') != 'none') && is_front_top_page() && !is_singular_page_type_content_only()) {
    $html = hvn_add_header();
    echo "<div class=hvn-header>{$html}</div>";
  }
});


//******************************************************************************
//  CocoonカスタムCSS変更
//******************************************************************************
add_filter('cocoon_part__tmp/css-custom', function($content) {
  $h = get_entry_content_margin_hight();
  $content = str_replace("margin-bottom: {$h}em", 'margin-bottom:' . HVN_GAP . 'px', $content);
  $content = str_replace('67.4%', 'calc(70% - var(--gap30))', $content);

  return $content;
});


//******************************************************************************
//  Swiper変更
//******************************************************************************
add_filter('cocoon_part__tmp/footer-javascript', function($content) {
  $content = str_replace('spaceBetween: 4', 'spaceBetween: ' . HVN_GAP , $content);

  return $content;
});


//******************************************************************************
//  ナビカードオートプレイ
//******************************************************************************
add_filter('cocoon_part__tmp/body-top', function($content) {
  if (get_theme_mod('hvn_swiper_auto_setting')) {
    $content = preg_replace('/(<div class="swiper-button-prev">)/', '<div class="swiper-pagination"></div>$1', $content);

    $w = new WP_HTML_Tag_Processor($content);
    while ($w->next_tag(array('class_name' => 'navi-entry-cards',))) {
      $w->add_class('is-auto-horizontal');
      $w->remove_class('is-list-horizontal');
    }
    return $w->get_updated_html();
  }

  return $content;
});


//******************************************************************************
//  カスタムJS追加
//******************************************************************************
add_action('cocoon_part_after__tmp/footer-javascript', function() {
  global $_IS_SWIPER_ENABLE;
  global $_HVN_NOTICE;

  if ((!$_IS_SWIPER_ENABLE)
   && (($_HVN_NOTICE)
    || (hvn_image_count() > 1  && get_theme_mod('hvn_header_setting') == 'image' && is_front_top_page()))) {
    echo <<< EOF
    <link rel='stylesheet' id='swiper-style-css' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css' />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

EOF;
  }

  ob_start();
  cocoon_template_part(HVN_SKIN . 'tmp/js-custom');
  $js = ob_get_clean();
  echo '<script id="hvn-custom-js">' . $js . '</script>';
});


//******************************************************************************
//  オリジナルレイアウト変更
//******************************************************************************
add_filter('cocoon_part__tmp/list-category-columns', function($content) {
  if (get_theme_mod('hvn_card_expansion_setting')) {
    if (is_entry_card_type_vertical_card_2()
     || is_entry_card_type_vertical_card_3()) {
      ob_start();
      cocoon_template_part(HVN_SKIN . 'tmp/list-category-columns');
      $content = ob_get_clean();
    }
  }

  return $content;
});


//******************************************************************************
//  カテゴリーごと間波線追加
//******************************************************************************
add_filter('cocoon_part__tmp/list', function($content) {
  $cat_ids = get_index_list_category_ids();
  if (count($cat_ids)
   && get_theme_mod('hvn_category_color_setting')
   && get_theme_mod('hvn_header_wave_setting')
   && (!is_the_page_sidebar_visible())) {
    $html = hvn_wave("hvn-wave-category");
    $content = str_replace('<div id="list-columns"', $html . '<div id="list-columns"', $content);
  }
  return $content;
});


//******************************************************************************
//  カテゴリーごと(2、3カード)縦型カード
//******************************************************************************
add_filter('index_widget_entry_card_type', function($type, $cat_id) {
  if (get_theme_mod('hvn_categoties_card_setting')) {
    $type = 'large_thumb';
  }
  return $type;
}, 2, 10);


//******************************************************************************
//  プロフィールのSNSフォローを非表示
//******************************************************************************
add_filter('cocoon_part__tmp/sns-follow-buttons', function($content) {
  if (get_theme_mod('hvn_profile_follows_setting')) {
    if (get_query_var('option') == 'sf-profile') {
      $content = null;
    }
  }
  return $content;
});


//******************************************************************************
//  ダークモード
//******************************************************************************
add_filter('cocoon_part__tmp/footer-bottom', function($content) {
  $html = <<<EOF
<span class="hvn-dark-switch">
  <input type="checkbox" name="hvn-dark" id="hvn-dark">
  <label for="hvn-dark"></label>
</span>
EOF;
  $content =  preg_replace('/(class="source-org copyright">.*)<\/div>/', "$1$html</div>", $content);
  return $content; 
});


//******************************************************************************
//  タイトルとURLをコピー
//******************************************************************************
add_filter('cocoon_part__tmp/sns-share-buttons', function($content) {
  $before ='/data-clipboard-text=".*" title/';
  $after = 'data-clipboard-text="<a href=' . get_the_permalink() . '>' . get_share_page_title() . '</a>" title';
  $content = preg_replace($before, $after, $content);

  return $content;
});


//******************************************************************************
//  エントリーカードにリボンを追加
//******************************************************************************
add_action('entry_card_snippet_after',function($post_ID) {
  $memo = get_post_meta($post_ID, 'the_page_memo', true);
  preg_match('/ribbon-color-[1-5]/', $memo,$class);
  if ($class) {
    echo '<div class="ribbon ribbon-top-left ' . $class[0] . '"></div>';
  }
});


//******************************************************************************
//  カラーパレット追加
//******************************************************************************
add_filter('block_editor_color_palette_colors', function($colors) {
  $main_color = get_theme_mod('hvn_main_color_setting', HVN_MAIN_COLOR);
  $rgb = hvn_color_mix_rgb($main_color, 0.15);
  $hover_color = $rgb['hex'];

  $add_colors = array(
    array('name' => __('スキンカラー1' , THEME_NAME), 'slug' => 'hvn-main-color' , 'color' => $main_color),
    array('name' => __('スキンカラー2' , THEME_NAME), 'slug' => 'hvn-hover-color', 'color' => $hover_color),
  );
  $colors = array_merge($colors, $add_colors);

  return $colors;
});


//******************************************************************************
//  SNSシェアコメントボタン表示
//******************************************************************************
add_filter('is_comment_share_button_visible', function($res, $option) {
  if (!is_single_comment_visible()) {
    $res = false;
  }
  return $res;
}, 10, 2);
