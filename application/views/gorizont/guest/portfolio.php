<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=link_tag('assets/css/animate.css');?>
    <?=link_tag('assets/css/main.css');?>
    <title>Портфолио</title>
</head>

<body class="page-portfolio">
    <header class="header">
        <div class="wrapper">
            <nav class="navigation flex flex--between">
                <a href="<?=base_url();?>"><img src="<?=base_url('assets/img/svg/logo.svg');?>" alt="LOGO" class="header__logo wow fadeIn" data-wow-duration="2s"></a>
                <a href="<?=base_url();?>" class="header__back wow fadeIn" data-wow-duration="2s"><img src="<?=base_url('assets/img/svg/arrow-left.svg');?>" alt="Назад"></a>
            </nav>
        </div>
    </header>
    <main class="main wrapper">
        <section class="portfolio">
            <div class="portfolio__title wow fadeIn" data-wow-duration="2s">Портфолио</div>
            <ul class="portfolio__filter flex flex--between wow fadeIn" data-wow-duration="2s">
                <li class="portfolio__filter-item">BTL</li>
                <li class="portfolio__filter-item">Event</li>
                <li class="portfolio__filter-item">Production</li>
            </ul>
        </section>

        <section class="case">
            <div class="case__box flex flex--wrap">
                <?php
                    foreach ($portfolios as $key=>$portfolio)
                    {
                ?>
                    <a href="<?=base_url('case/'.$portfolio['id']);?>" class="case__item wow fadeIn" data-wow-duration="2s">
                        <img src="<?=base_url('assets/img/cases/'.$portfolio['id'].'/'.$portfolio['img']);?>" alt="Зенит" class="case__img">
                        <span class="case__info">
                            <h3 class="case__info-title"><?=$portfolio['header'];?></h3>
                            <p class="case__subtitle" style="white-space: pre-wrap!important;"><?=$portfolio['description'];?></p>
                            <div class="case__link">Подробнее</div>
                        </span>
                    </a>
                <?php
                    }
                ?>
            </div>
        </section>

        <a href="<?=base_url();?>" class="back flex flex--center">Вернуться назад</a>
    </main>
    <script src="<?=base_url('assets/js/libs.min.js');?>"></script>
    <script src="<?=base_url('assets/js/common.js');?>"></script>
</body>

</html>