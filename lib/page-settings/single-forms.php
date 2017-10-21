<div class="metabox-holder">

<!-- 関連記事 -->
<div id="single-page" class="postbox">
  <h2 class="hndle"><?php _e( '関連記事設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( '関連記事の表示に関する設定です。', THEME_NAME ) ?></p>

    <table class="form-table">
      <tbody>
        <!-- プレビュー画面 -->
        <tr>
          <th scope="row">
            <label><?php _e( 'プレビュー', THEME_NAME ) ?></label>
          </th>
          <td>
            <div class="demo" style="height: 300px;overflow: auto;">
              <?php get_template_part('tmp/related-entries') ?>
            </div>
            <?php genelate_tips_tag(__( 'デモの関連記事はランダムです。', THEME_NAME )); ?>
          </td>
        </tr>

        <!-- 表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_ENTRIES_VISIBLE, __('表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_checkbox_tag(OP_RELATED_ENTRIES_VISIBLE , is_related_entries_visible(), __( '関連記事を表示する', THEME_NAME ));
            genelate_tips_tag(__( '投稿ページの関連記事を表示するか。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 関連記事見出し -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_ENTRY_HEADING, __('関連記事見出し', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_textbox_tag(OP_RELATED_ENTRY_HEADING, get_related_entry_heading(), __( '見出し', THEME_NAME ));
            genelate_tips_tag(__( '関連記事の見出しを入力してください。', THEME_NAME ));
            genelate_textbox_tag(OP_RELATED_ENTRY_SUB_HEADING, get_related_entry_sub_heading(), __( 'サブ見出し', THEME_NAME ));
            genelate_tips_tag(__( '関連記事の補助となる見出しを入力してください。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 表示タイプ -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_ENTRY_TYPE, __('表示タイプ', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'entry_card' => __( 'エントリーカード（デフォルト）', THEME_NAME ),
              'mini_card' => __( 'ミニカード（推奨表示数：偶数）', THEME_NAME ),
              'vartical_card_3' => __( '縦型カード3列（推奨表示数：6, 12, 18...）', THEME_NAME ),
              'vartical_card_4' => __( '縦型カード4列（推奨表示数：4, 8, 12...）', THEME_NAME ),
            );
            genelate_radiobox_tag(OP_RELATED_ENTRY_TYPE, $options, get_related_entry_type());
            genelate_tips_tag(__( '関連記事の表示タイプを選択します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 表示数 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_ENTRY_COUNT, __('表示数', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_number_tag(OP_RELATED_ENTRY_COUNT,  get_related_entry_count(), 2, 30);
            genelate_tips_tag(__( '関連記事で表示する投稿数の設定です。（最小：2、最大：30）', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 枠線の表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_ENTRY_BORDER_VISIBLE, __('枠線の表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_checkbox_tag(OP_RELATED_ENTRY_BORDER_VISIBLE , is_related_entry_border_visible(), __( 'カードの枠線を表示する', THEME_NAME ));
            genelate_tips_tag(__( '投稿エントリーカードの枠となる罫線を表示するか。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 最大抜粋文字数 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_RELATED_EXCERPT_MAX_LENGTH, __('最大抜粋文字数', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_number_tag(OP_RELATED_EXCERPT_MAX_LENGTH,  get_related_excerpt_max_length(), 30, 500);
            genelate_tips_tag(__( '「エントリーカード」で、抜粋文を表示する場合の最大文字数を
              設定します。（最小：30、最大：500）', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>

<!-- ページ送りナビ -->
<div id="single-page" class="postbox">
  <h2 class="hndle"><?php _e( 'ページ送りナビ設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( '[前ページ][次ページ]へと送るナビゲーションの設定です。', THEME_NAME ) ?></p>

    <table class="form-table">
      <tbody>
        <!-- プレビュー画面 -->
        <tr>
          <th scope="row">
            <label><?php _e( 'プレビュー', THEME_NAME ) ?></label>
          </th>
          <td>
            <div class="demo">
              <?php get_template_part('tmp/pager-post-navi') ?>
            </div>
            <?php genelate_tips_tag(__( 'デモはランダム表示です。', THEME_NAME )); ?>
          </td>
        </tr>

        <!-- 表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_POST_NAVI_VISIBLE, __('表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_checkbox_tag(OP_POST_NAVI_VISIBLE , is_post_navi_visible(), __( 'ページ送りナビを表示する', THEME_NAME ));
            genelate_tips_tag(__( '[前ページ][次ページ]ナビを表示するか。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 表示タイプ -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_POST_NAVI_TYPE, __('表示タイプ', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'default' => __( 'デフォルト', THEME_NAME ),
              'square' => __( 'サムネイル正方形', THEME_NAME ),
            );
            genelate_radiobox_tag(OP_POST_NAVI_TYPE, $options, get_post_navi_type());
            genelate_tips_tag(__( 'ページ送りナビの見た目を変更します。', THEME_NAME ));
            ?>
          </td>
        </tr>

        <!-- 枠線表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_POST_NAVI_BORDER_VISIBLE, __('枠線表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_checkbox_tag(OP_POST_NAVI_BORDER_VISIBLE , is_post_navi_border_visible(), __( 'ページ送りナビの枠線を表示する', THEME_NAME ));
            genelate_tips_tag(__( 'ページ送りナビを囲む枠線を表示するか。', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>

<!-- コメント -->
<div id="single-page" class="postbox">
  <h2 class="hndle"><?php _e( 'コメント設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( '投稿のコメント表示設定です。', THEME_NAME ) ?></p>

    <table class="form-table">
      <tbody>
        <!-- 表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_SINGLE_COMMENT_VISIBLE, __('表示', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            genelate_checkbox_tag(OP_SINGLE_COMMENT_VISIBLE , is_single_comment_visible(), __( 'コメントを表示する', THEME_NAME ));
            genelate_tips_tag(__( '投稿ページにコメントを表示するか。', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>

<!-- パンくずリスト -->
<div id="single-page" class="postbox">
  <h2 class="hndle"><?php _e( 'パンくずリスト設定', THEME_NAME ) ?></h2>
  <div class="inside">

    <p><?php _e( '投稿のパンくずリスト設定です。', THEME_NAME ) ?></p>

    <table class="form-table">
      <tbody>
        <!-- 表示 -->
        <tr>
          <th scope="row">
            <?php genelate_label_tag(OP_SINGLE_BREADCRUMBS_POSITION, __('パンくずリストの配置', THEME_NAME) ); ?>
          </th>
          <td>
            <?php
            $options = array(
              'none' => __( '表示しない', THEME_NAME ),
              'main_before' => __( 'メインカラム手前', THEME_NAME ),
              'main_top' => __( 'メインカラムトップ', THEME_NAME ),
              'main_bottom' => __( 'メインカラムボトム（デフォルト）', THEME_NAME ),
              'footer_before' => __( 'フッター手前', THEME_NAME ),
            );
            genelate_radiobox_tag(OP_SINGLE_BREADCRUMBS_POSITION, $options, get_single_breadcrumbs_position());
            genelate_tips_tag(__( '投稿のパンくずリスト表示位置を設定します。', THEME_NAME ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>

  </div>
</div>

</div><!-- /.metabox-holder -->