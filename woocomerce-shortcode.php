<?php
/**
 * Plugin Name: woocommerce short code
 * Plugin URI: efe.com.vn
 * Description: woocommerce short code
 * Version: 1
 * Author: sang
 * Author UR:efe.com.vn
 * License: GPLv2
 */
	add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );
    function my_theme_scripts(){
        wp_enqueue_style( 'bootstrap-min', plugins_url('/css/bootstrap.min.css', __FILE__));
    }

	add_action('admin_enqueue_scripts','add_style');
	function add_style(){
		wp_enqueue_style( 'wp-analytify-style', plugins_url( 'css/bootstrap-theme.css',__FILE__));
		wp_enqueue_style( 'wp-analytify-style', plugins_url( 'css/bootstrap.min.css',__FILE__));
	}
	add_action('admin_menu','woo_shortcode');
	function woo_shortcode(){
		add_menu_page( 'id_shortcode', 'Woo Short Code','2','woo Short code','callBack_woo');
	}
	function callBack_woo(){ 
		$get_categories = array('taxonomy'=>'product_cat');
		$category_value = get_categories($get_categories);
		//print_r($category_value); ?>
		<br/>
		<select class="form-control" id="select" style="margin-top: 10px;">
			<option value="">All Category</option>
			<?php foreach ($category_value as $key) { ?>
			<option value="<?php echo $key->slug ?>"><?php echo $key->cat_name ?></option>
			<?php	} ?>
		</select><br/>
		<br/>
		<select class="form-control" id="sort" style="margin-bottom: 10px;">
			<option value="ASC">ASC</option>
			<option value="DESC">DESC</option>
		</select>
		<select class="form-control" id="show">
			<option value="list" selected>List</option>
			<option value="grid">Grid</option>
			<option value="Carousel">Carousel</option>
		</select><br/>
		<select class="form-control" id="featured" style="margin-bottom: 10px">
			<option value="on" selected>Featured</option>
			<option value="">No Featured</option>
		</select>
			<input id="shortcode" type="submit" class="btn btn-success" value="ShortCode">
			<br/>
			<input id="short" type="text" class="form-control" style="margin-top: 10px;">
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#shortcode").click(function(){
					var select = $("#select").val();
					var show =$("#show").val();
					var sort = $("#sort").val();
					var f = $("#featured").val();
					$("#short").val('[Get category= "'+select+'" method="'+show+'" featured="'+f+'" order="'+sort+'"]');
					});
				});
		</script>
		<?php 
		}
		add_shortcode('Get', 'display_content' );
		function display_content($data)
		{
			if($data['method'] == 'grid')
			{
				global $post;
				$args = array(
					'post_per_page' => '5',
					'post_type' => 'product',
					'product_cat' => $data['category'],
					'orderby' => 'id',
					'meta_key' => 'featured_posts',
					'order'  => $data['order'],
					'meta_value' => $data['featured']
				);
				$get_post = get_posts( $args );
				// echo "<prev>";
				// print_r($get_post);
				// echo "</prev>";
				?>
				<div class="content" style="margin-top: 10px">
					<div class="row">
						<?php foreach($get_post as $post): setup_postdata( $post ); ?>
						<div class="col-md-6">
							<div class="item">
								<div class="thumbnail">
							    	<div style="background-image: url('<?php echo get_the_post_thumbnail_url($post->id); ?>');height: 132px; width: 275px; background-size: cover; background-position: center;">
							   		</div>
							    </div>
							    <div class="info">
							        <p style="color:#e47c11">Tên sản phẩm: <?php  echo the_title(); ?>
							        </p>
							        <h3>Price:<?php echo get_post_meta( get_the_ID(), '_regular_price', true); ?>$</h3>

							    </div>
							</div>
						</div>
				<?php endforeach; ?>
					</div>
				</div>
		<?php
		wp_reset_postdata();	
		}elseif ($data['method'] == 'list') {
			show_code_list($data);
		}else{

		}
	}
	function show_code_list($data)
	{
		global $post;
		$args = array(
			'post_per_page' => '5',
			'post_type' => 'product',
			'product_cat' => $data['category'],
			'orderby' => 'id',
			'meta_key' => 'featured_posts',
			'order'  => $data['order'],
			'meta_value' => $data['featured']
		);
		$get_post = get_posts( $args );
		// echo "<prev>";
		// print_r($get_post);
		// echo "</prev>";
		?>
		<div class="content" style="margin-top: 10px">
			<div class="row">
				<?php foreach($get_post as $post): setup_postdata( $post ); ?>
				<div class="col-md-12">
					<div class="item">
						<div class="thumbnail">
					    	<div style="background-image: url('<?php echo get_the_post_thumbnail_url($post->id); ?>');height: 132px; width: 275px; background-size: cover; background-position: center; display: block;margin-left: auto;margin-right: auto;">
					   		</div>
					    </div>
					    <div class="info">
					        <p style="color:#e47c11">Tên sản phẩm: <?php  echo the_title(); ?></p>
					    </div>
					</div>
				</div>
		<?php endforeach; ?>
			</div>
		</div>
<?php	}
		function show_code_slide($data)
		{
			global $post;
			$args = array(
				'post_per_page' => '5',
				'post_type' => 'product',
				'product_cat' => $data['category'],
				'orderby' => 'id',
				'meta_key' => 'featured_posts',
				'order'  => $data['order'],
				'meta_value' =>+
				  $data['featured']
			);
			$get_post = get_posts( $args );
			// echo "<prev>";
			// print_r($get_post);
			// echo "</prev>";
			?>
			<div class="content" style="margin-top: 10px">
				<div class="row">
					<?php foreach($get_post as $post): setup_postdata( $post ); ?>
					<div class="slide">
						<div class="col-md-3">
							<div class="item">
								<div class="thumbnail">
							    	<div style="background-image: url('<?php echo get_the_post_thumbnail_url($post->id); ?>');height: 132px; width: 275px; background-size: cover; background-position: center;">
							   		</div>
							    </div>
							    <div class="info">
							        <p style="color:#e47c11">Tên sản phẩm: <?php  echo the_title(); ?></p>
							    </div>
							</div>
						</div>
					</div>
			<?php endforeach; ?>
				</div>
			</div>
<?php		}
 ?>