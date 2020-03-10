<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="utf-8">

    <title>Горизонт</title>
    <meta name="description" content="Горизонт - Агентство нестандартных решений">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Горизонт">
    <meta property="og:title" content="Горизонт">
    <meta property="og:description" content="Горизонт - Агентство нестандартных решений">
    <meta property="og:url" content="https://gorizont.agency/">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="https://gorizont.agency/ogimage.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Горизонт">
    <meta name="twitter:description" content="Горизонт - Агентство нестандартных решений">
    <meta name="twitter:image:src" content="https://gorizont.agency/ogimage.jpg">
    <meta name="twitter:url" content="https://gorizont.agency">
    <meta name="twitter:domain" content="gorizont.agency">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#000">

    <?=link_tag('assets/css/animate.css');?>
    <?=link_tag('assets/css/carousel.css');?>
    <?=link_tag('assets/css/main.css');?>

</head>

<body>
    <div class="preloader">
        <div class="logo">
            <div class="logo__line">
            </div>
        </div>
    </div>
    <header class="header">
        <div class="wrapper">
            <nav class="navigation flex flex--between flex--center">
                <div class="mobile-toggle-menu"></div>
                <a href="<?=base_url();?>"><img src="<?=base_url('assets/img/svg/logo.svg');?>" alt="LOGO" class="header__logo wow fadeIn" data-wow-duration="2s"></a>
                <menu class="navigation__list flex flex--between wow fadeIn" data-wow-duration="2s">
                    <a href="<?=base_url('portfolio');?>" class="navigation__item">Портфолио</a>
                    <a href="#contact" class="navigation__item">Контакты</a>
                    <a href="<?=$pdf_link;?>" class="navigation__item">Скачать pdf</a>
                </menu>
            </nav>
            <div class="header__box flex wow fadeIn" data-wow-duration="2s">
            	<h1 class="header__title" style="white-space: pre-wrap!important;"><?=( !empty($title) ) ? $title :'';?></h1>
                <div class="header__subtitles-box">
                	<p class="header__subtitle" style="white-space: pre-wrap!important;"><?=( !empty($text) ) ? $text :'';?></p>
                </div>
            </div>
        </div>
    </header>
    <main class="main wrapper">
        <section id="stat" class="statistic flex flex--between wow fadeIn" data-wow-duration="2s">
        	<?php
        		if(!empty($statistic_caption_1))
        		{
        	?>
        		<div class="statistic__item flex flex--between">
                	<div class="statistic__value"><?=$statistic_value_1;?></div>
                	<div class="statistic__text"><?=$statistic_caption_1;?></div>
            	</div>
        	<?php
        		}
        	?>

        	<?php
        		if(!empty($statistic_caption_2))
        		{
        	?>
        		<div class="statistic__item flex flex--between">
                	<div class="statistic__value"><?=$statistic_value_2;?></div>
                	<div class="statistic__text"><?=$statistic_caption_2;?></div>
            	</div>
        	<?php
        		}
        	?>

        	<?php
        		if(!empty($statistic_caption_3))
        		{
        	?>
        		<div class="statistic__item flex flex--between">
	                <div class="statistic__value"><?=$statistic_value_3;?></div>
	                <div class="statistic__text"><?=$statistic_caption_3;?></div>
	            </div>
        	<?php
        		}
        	?>
        </section>
        <section class="partners">
        	<?php
	            $image_list = get_filenames( dirname(APPPATH).'/assets/img/BigSlider/mobile' );
	            if ( !empty($image_list))
	            {
	            	if (!empty($_SESSION['viewport'])) {
	            		$viewport = $_SESSION['viewport'].'/';
	            	}else{
	            		$viewport = '';
	            	}
	        ?>
            		<h3 class="partners__title wow fadeIn" data-wow-duration="2s">Наши партнеры</h3>
            		<ul class="owl-carousel">
            			<?php
			            foreach ($image_list as $key=>$image)
			            {
			            	$key++;
			                if ($key==1) {
			                    $active = "active";
			                }else{
			                    $active = '';
			                }
			            ?>
			            	<li class="ant-carousel-element"><img src="<?=$image;?>" alt="0"></li>
			          <?php
			            }
			          ?>  
		            </ul>
            <?php
	            }
	        ?>
		</section>

		<?php 
			if (!empty($sections))
			{
		?>
		        <section class="services flex flex--wrap">
		     <?php
		     	foreach ($sections as $key=>$section)
		     	{
				?>
		            <div class="services__box wow fadeIn" data-wow-duration="2s">
		                <h3 class="services__title"><?=$section['value'];?></h3>
		                <div class="services__list flex flex--column">
		                    <?php
			                    if (!empty($section['section_items']))
			                    {
			                      foreach ($section['section_items'] as $section_item)
			                      {
			                  ?>  
			                        <a href="#" class="services__item"><?=$section_item['value'];?></a>                          
			                  <?php
			                      }
			                    }
			                  ?>
		                    
		                </div>
		            </div>
		            
		<?php   } ?>
		       	</section>
	<?php	}
		?>
        <?php if (!empty($portfolios)) { ?>
        <section class="case">
            <div class="case__title wow fadeIn" data-wow-duration="2s">Наши кейсы</div>
            <div class="case__box flex flex--wrap">
            	<?php
					foreach ($portfolios as $key=>$portfolio)
					{
				?>
					<a href="<?=base_url('case/'.$portfolio['id']);?>" class="case__item wow fadeIn" data-wow-duration="2s">
	                    <img src="<?=base_url('assets/img/cases/'.$portfolio['id'].'/'.$portfolio['img']);?>" alt="Зенит" class="case__img">
	                    <span class="case__info">
	                        <h3 class="case__info-title"><?=$portfolio['header'];?></h3>
	                        <p class="case__subtitle"><?=$portfolio['description'];?></p>
	                        <div class="case__link">Подробнее</div>
	                    </span>
                	</a>

				<?php
					}
				?>               
            </div>
        </section>
        <?php } ?>
    </main>

    <footer class="footer map" id="contact">
        <div id="map"></div>
        <div class="map__box" style="white-space: pre-wrap!important;">
            <h2 class="map__title">Ждем вас в гости!</h2>
            <p class="map__address">
            	<?php if (!empty($contacts)) {
            		$matches = array();
					preg_match_all('/\+\d{7,}|\+\d{1,}[\s\d{1,}]+/', $contacts, $matches);
					foreach ($matches[0] as $value) {
						$pattern = preg_quote($value, '/');
						$replacement = '<a href="tel:'.$value.'" class="map__address" style="text-decoration: none; color:#fff;">'.$value.'<a>';
						$contacts = preg_replace( "/" . preg_quote($value) . "/", $replacement, $contacts);
					}
            		echo $contacts;
            	} ?>
            </p>
            <div class="map__social-icons">
                <a href="#">horizon.chel</a>
                <a href="https://vk.com/gorizont.agency"><img src="<?=base_url('assets/img/svg/vk.svg');?>" alt="VK"></a>
                <a href="https://instagram.com/gorizont.agency?igshid=pg4gamw47u86"><img src="<?=base_url('assets/img/svg/inst.svg');?>" alt="Instagram"></a>
            </div>
        </div>
    </footer>

    <script src="<?=base_url('assets/js/libs.min.js');?>"></script>
    <script src="<?=base_url('assets/js/common.js');?>"></script>
    <script>
    	let base_url = '<?=base_url();?>', viewport;        

        document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){
		 	function get_viewport()
		 	{
	    		let viewport, img_list = document.querySelectorAll(".ant-carousel-element > img");
	    		if(window.screen.width <= 768){
				    viewport = 'mobile/';
				} else {
				    viewport = 'desctop/';
				}
				console.log(viewport);
				Array.prototype.forEach.call(img_list, function(el, ind) {
				   let current_name = el['src'].slice( el['src'].lastIndexOf('/')+1 ), new_name;
				   new_name = base_url+'assets/img/BigSlider/'+viewport+current_name;
					document.querySelector('[src="'+current_name+'"]').setAttribute('src', new_name);
				});
    		}
    		get_viewport();	  
		});
</script>
<script>
document.body.onload = () => {
    setTimeout(() => {
        let pr = document.querySelector('.preloader');
        if (!pr.classList.contains('done')) {
            pr.classList.add('done');
        }
        new WOW().init();
    }, 1000);
};

let toggleMenu = (() => {
    const nav = document.querySelector('.navigation');
    const navItem = document.querySelectorAll('.navigation__item');
    const menuIcon = document.querySelector('.mobile-toggle-menu');
    menuIcon.addEventListener('click', () => {
        nav.classList.toggle('navigation--active');
    });
    navItem.forEach(item => {
        item.addEventListener('click', ()=>{
            nav.classList.remove('navigation--active');
        })
    });
})();

$(document).ready(function () {
	$('.map__box > a').remove();
	$('.map__social-icons > a:not([href])').remove();
var show = true;
var countbox = ".statistic";
$(window).on("scroll load resize", function () {
    if (!show) return false; // Отменяем показ анимации, если она уже была выполнена
    var w_top = $(window).scrollTop(); // Количество пикселей на которое была прокручена страница
    var e_top = $(countbox).offset().top; // Расстояние от блока со счетчиками до верха всего документа
    var w_height = $(window).height(); // Высота окна браузера
    var d_height = $(document).height(); // Высота всего документа
    var e_height = $(countbox).outerHeight(); // Полная высота блока со счетчиками
    if (w_top + 500 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height) {
        $('.statistic__value').css('opacity', '1');
        $('.statistic__value').spincrement({
            thousandSeparator: "",
            duration: 2000,
            from: 0
        });

        show = false;
    }
});

});

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGzKTAsC_rrSJ2autoFIDmX1Aelqb_JHc&callback=initMap">
	</script>
    <style>
.gm-style-pbc{
    display: none;
}
</style>
</body>

</html>