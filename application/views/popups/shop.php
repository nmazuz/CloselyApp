<?php $this->load->helper('url'); ?>	
<!doctype html>
<html class="no-js">	
	<head>
		<?php $this->load->view('head/meta'); ?>
		<?php $this->load->view('head/css'); ?>
		<script src="<?php echo base_url();?>asset/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=he&libraries=places"></script>
		<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.jscrollpane.min.js"></script>
		<link rel="stylesheet" media="all" href="<?php echo base_url();?>asset/css/jquery.thumbnailScroller.css"/>
		<?php $this->load->view('head/storelocation',$location); ?>
	</head>	
	<body onload="initialize()">
	<div class="popup">
		<div class="header header_orange" >
		<div class="buttons_collection">
			<div class="userbutton"><img src="<?php echo base_url();?>asset/img/likestore.png" /></div>
			<div class="userbutton"><a href="/shop/page/<?php echo $shop->shop_id ?>"><img src="<?php echo base_url();?>asset/img/shoppage.png" /></a></div>
			<div class="userbutton"><a href="/user/page/<?php echo $shop->user_id ?>/shops"><img src="<?php echo base_url();?>asset/img/mypage.png" /></a></div>
		</div>
		<div class="fav"></div>
		<div class="title"><?php echo $shop->shop_title;?></div>
		<div class="triangle"></div>
		</div>
		<div class="content">
			<div class="shop">
				<div class="picture">
				<img src="<?php echo base_url();?>asset/img/shops/<?php echo $shop->shop_image;?>"  />
				<?php if (!empty($shop->shop_price)) : ?>
					<div class="price_tag"><?php echo $shop->shop_price . ' ₪ ' ?></div>
				<?php endif ?>
				</div>
				<div class="info">
					<div class="headerblock">פרטי הקנייה</div>
					<div class="triangle"></div>
					<div class="contentblock">
					<ul class="info_list">
						<li class="info_row">
							<div class="tag">:שם הקנייה</div>
							<div class="detial"><?php echo $shop->shop_title;?></div>
						</li>
						<li class="info_row">
							<div class="tag">:קנייה</div>
							<div class="detial"><?php echo $shop->shop_time;?></div>
						</li>
						<li class="info_row">
							<div class="tag">:עסק</div>
							<div class="detial"><?php echo $location['info']->store_name ?></div>
						</li>
						<li class="info_row">
							<div class="tag">:קטגוריה</div>
							<div class="detial"><?php echo $category[0]->category_name ?></div>
						</li>
						<li class="info_row">
							<div class="tag">:תיאור</div>
							<div class="detial"><?php echo $shop->shop_description; ?></div>
						</li>
					</ul>

					</div>
				</div>
					<?php $this->load->view('blocks/comments_template',$comments); ?>
				<div class="mycoupon">
					<?php $this->load->view('blocks/singlebanner',$coupon); ?>
				</div>
				<div id="locationField">
					 <input id="autocomplete" type="text" /> 
				</div>
				<div id="map_canvas"></div>
				<div id="listing"><table id="results"></table></div>
			</div>
		</div>	
	</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8">
		$(function(){$('#commentsList').jScrollPane();});
</script>