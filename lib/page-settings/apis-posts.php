<?php //その他設定をデータベースに保存
/**
 * Cocoon WordPress Theme
 * @author: yhira
 * @link: https://wp-cocoon.com/
 * @license: http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */

//AmazonアクセスキーID
update_theme_option(OP_AMAZON_API_ACCESS_KEY_ID);

//Amazonシークレットキー
update_theme_option(OP_AMAZON_API_SECRET_KEY);

//AmazonトラッキングID
update_theme_option(OP_AMAZON_ASSOCIATE_TRACKING_ID);

//Amazon検索ボタンを表示する
update_theme_option(OP_AMAZON_SEARCH_BUTTON_VISIBLE);

//楽天アフィリエイトID
update_theme_option(OP_RAKUTEN_AFFILIATE_ID);

//楽天検索ボタンを表示する
update_theme_option(OP_RAKUTEN_SEARCH_BUTTON_VISIBLE);

//Yahoo!バリューコマースSID
update_theme_option(OP_YAHOO_VALUECOMMERCE_SID);

//Yahoo!バリューコマースPID
update_theme_option(OP_YAHOO_VALUECOMMERCE_PID);

//Yahoo!検索ボタンを表示する
update_theme_option(OP_YAHOO_SEARCH_BUTTON_VISIBLE);

//APIキャッシュの保存期間
update_theme_option(OP_API_CACHE_RETENTION_PERIOD);