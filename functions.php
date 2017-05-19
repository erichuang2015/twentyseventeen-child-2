<?php
/**
 * twenty seventeenのCSS読み込み
 * @Date 2017/1/1
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


/**
 * Google Tag Manager導入
 */

// </body>直前
function hook_javascript_footer() {
    /**
    * アナリティクスにデータレイヤー変数で公開日を渡す
    *
    * @date 20160205
    */
    if ( is_singular() ) {
    ?>
    <script>
      dataLayer = [{
        'release_date': '<?php echo esc_html(get_post_time('Y年n月j日')); ?>'
      }];
    </script>
    <?php
    }
}
add_action('wp_footer', 'hook_javascript_footer');


/**
 * AMPにGoogle タグマネージャーをインストール
 * AMPにGoogle AdSense導入
 * @Date 2016/11/03
 */
add_action( 'amp_post_template_head', 'xyz_amp_add_tag_analytics' );

function xyz_amp_add_tag_analytics() {
?>
<!-- AMP Analytics -->
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<!-- AMP Ad -->
<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
<!-- amp-social-share -->
<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
<?php
}

add_action( 'amp_post_template_footer', 'xyz_amp_add_tag_manager' );

function xyz_amp_add_tag_manager() {
?>
<!-- Google Adsense -->
<amp-ad layout="responsive" width=300 height=250 type="adsense" data-ad-client="ca-pub-1528327588378459" data-ad-slot="1990600923">
</amp-ad>
<!-- Google Tag Manager -->
<amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-M373TN" data-credentials="include"></amp-analytics>
<?php
}


/**
 * AMPにamp-social-share追加
 * @Date 2016/11/24
 */
function xyz_amp_add_comment_count_meta( $meta_parts ) {
	$meta_parts[] = 'xyz-meta-comment-count';
	return $meta_parts;
}
add_filter( 'amp_post_article_footer_meta', 'xyz_amp_add_comment_count_meta' );

function xyz_amp_set_comment_count_meta_path( $file, $type, $post ) {
	if ( 'xyz-meta-comment-count' === $type ) {
		$file = dirname( __FILE__ ) . '/templates/xyz-meta-comment-count.php';
	}
	return $file;
}
add_filter( 'amp_post_template_file', 'xyz_amp_set_comment_count_meta_path', 10, 3 );


/**
 * AMPに独自CSS追加
 * @Date 2016/11/24
 */
function xyz_amp_my_additional_css_styles( $amp_template ) {
	echo '.outer-amp-social-share {margin: 0 16px;}';
}
add_action( 'amp_post_template_css', 'xyz_amp_my_additional_css_styles' );