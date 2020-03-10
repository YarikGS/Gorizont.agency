<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=link_tag('assets/css/animate.css');?>
    <?=link_tag('assets/css/carousel.css');?>
    <?=link_tag('assets/css/main.css');?>
    <title><?=$portfolio->header;?></title>
</head>
<body class="page-portfolio-info">
    <?php
        $image_background = array_diff(scandir(dirname(APPPATH).'/assets/img/cases/'.$portfolio->id.'/background'), array('..', '.', '.DS_Store'));
        $image_background_path = base_url( '/assets/img/cases/'.$portfolio->id.'/background/'.$image_background[2] );
    ?>
    <header class="header" style="background-image: url(<?=$image_background_path;?>);">
        <div class="wrapper">
            <nav class="navigation flex flex--between">
                <a href="<?=base_url();?>"><img src="<?=base_url('assets/img/svg/logo.svg');?>" alt="LOGO" class="header__logo wow fadeIn" data-wow-duration="2s"></a>
                <a href="<?=base_url();?>" class="header__back"><img src="<?=base_url('assets/img/svg/arrow-left.svg');?>" alt="Назад"></a>
            </nav>
        </div>
    </header>
    <main class="main wrapper">
    <?php
        if ( !empty( $elements ) ) {
            foreach ($elements as $element) {
                switch ( $element['name'] ) {
                    case 'header':
                        $content = '<h2 class="gallery__title wow fadeIn" data-wow-duration="2s" style="white-space: pre-wrap!important;">'.$element['value'].'</h2>';
                        $color = 'info';
                    break;
                    case 'text':
                        $content = '<p class="gallery__subtitle wow fadeIn" data-wow-duration="2s" style="white-space: pre-wrap!important;">'.$element['value'].'</p>';
                    break;
                    case 'image':
                        $image_name = get_filenames( dirname(APPPATH).'/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'] );
                        $image = base_url( '/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'].'/'.$image_name[0] );
                    break;
                    case 'slider':
                        $type = 4;
                    break;
                    default:
                        $type = 0;
                    break;
                }
                if ( $element['name'] == 'header' || $element['name'] == 'text' ) {
                    // $element['value']
                    echo '<div class="gallery">'.$content.'</div>';
                }elseif ( $element['name'] == 'image' ) {
                    echo '<div class="gallery">'.
                        '<div class="gallery__box wow fadeIn" data-wow-duration="2s">'.
                            '<img src="'.$image.'" alt="">'.
                        '</div>'.
                    '</div>';                                    
                }elseif ( $element['name'] == 'slider' ) {
                    $image_list = get_filenames( dirname(APPPATH).'/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'] );
                    if ( !empty($image_list) )
                    {
                        echo '<div class="wrapper slider"><ul class="owl-carousel">';
                        foreach ($image_list as $key=>$image)
                        {
                            $key++;
                            if ($key==1) {
                                $active = "active";
                            }else{
                                $active = '';
                            }
                            echo '<li class="ant-carousel-element '.$active.'"><img src="'.base_url( '/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'].'/'.$image ).'" alt="0"></li>';
                        }
                       
                        echo '</ul></div>'; 
                    }                       
                }
            }
        }
    ?>
        <div class="main__buttons flex flex--center">
            <a href="<?=base_url();?>" class="prev back">Вернуться назад</a>
            <?php
            if (!empty($next_case)) {
            ?>
               <a href="<?=base_url('case/'.$next_case);?>" class="next back">Следующая работа</a>
            <?php
            }
            ?>
            
        </div>
    </main>
    <script src="<?=base_url('assets/js/libs.min.js');?>"></script>
    <script src="<?=base_url('assets/js/common.js');?>"></script>
</body>

</html>