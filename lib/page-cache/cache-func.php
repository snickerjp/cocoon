<?php //バックアップ関係の関数
/**
 * Cocoon WordPress Theme
 * @author: yhira
 * @link: https://wp-cocoon.com/
 * @license: http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */

//SNSカウントキャシュの削除
if ( !function_exists( 'delete_sns_count_caches' ) ):
function delete_sns_count_caches(){
  if (is_user_administrator()) {
    return delete_db_cache_records(TRANSIENT_SHARE_PREFIX) && delete_db_cache_records(TRANSIENT_FOLLOW_PREFIX);
  }
}
endif;

//人気記事ウィジェットキャシュの削除
if ( !function_exists( 'delete_popular_entries_caches' ) ):
function delete_popular_entries_caches(){
  if (is_user_administrator()) {
    return delete_db_cache_records(TRANSIENT_POPULAR_PREFIX);
  }
}
endif;

//ブログカードキャシュの削除
if ( !function_exists( 'delete_blogcard_caches' ) ):
function delete_blogcard_caches(){
  if (is_user_administrator()) {
    return delete_db_cache_records(TRANSIENT_BLOGCARD_PREFIX);
  }
}
endif;

//AmazonAPIキャシュの削除
if ( !function_exists( 'delete_amazon_api_caches' ) ):
function delete_amazon_api_caches(){
  if (is_user_administrator()) {
    return delete_db_cache_records(TRANSIENT_AMAZON_API_PREFIX);
  }
}
endif;

//全てのキャッシュを削除
if ( !function_exists( 'delete_all_theme_caches' ) ):
function delete_all_theme_caches(){
  return delete_sns_count_caches() &&
         delete_popular_entries_caches() &&
         delete_blogcard_caches() &&
         delete_amazon_api_caches();
}
endif;

//Amazon個別キャシュの削除
if ( !function_exists( 'delete_amazon_asin_cache' ) ):
function delete_amazon_asin_cache($asin){
  if (is_user_administrator()) {
    return delete_db_cache_records(TRANSIENT_AMAZON_API_PREFIX.$asin) &&
           delete_db_cache_records(TRANSIENT_BACKUP_AMAZON_API_PREFIX.$asin);
  }
}
endif;

//テーマが保管している全てのキャッシュの保存処理
if ( !function_exists( 'delete_theme_storaged_caches' ) ):
function delete_theme_storaged_caches(){
  //管理者権限を持っているログインユーザーかどうか
  if (is_user_administrator()) {
    $delete_option = isset($_GET['cache']) ? $_GET['cache'] : null;
    switch ($delete_option) {
      case 'all_theme_caches':
        return delete_all_theme_caches();
        break;
      case 'sns_count_caches':
        return delete_sns_count_caches();
        break;
      case 'popular_entries_caches':
        return delete_popular_entries_caches();
        break;
      case 'blogcard_caches':
        return delete_blogcard_caches();
        break;
      case 'amazon_api_caches':
        return delete_amazon_api_caches();
        break;
      case 'amazon_asin_cache':
        $asin = isset($_GET['asin']) ? $_GET['asin'] : null;
        return delete_amazon_asin_cache($asin);
        break;
    }
  }
}
endif;