<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
          <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Главная</h1>
<!--             <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
<div class="col-12 mt-1">
  <div class="card mx-auto border-left-success shadow mb-2">
    <div class="card-header py-2 d-flex flex-row align-items-center justify-content-center">
      <div>
        <a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить колонку" onclick="elementsModalHandler( 'add', 'NULL', 'Заголовок колонки', 1)" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>
        Секция: "Чем мы занимаемся".
      </div>
      
      <div class="dropdown no-arrow ml-auto">
        <a class="dropdown-toggle " href="#" role="button" id="dropdownMenuContent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#services_dropdown').toggle();">
          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
      </div> 
    </div>
    <div class="dropdown-menu w-100 border-left-success shadow animated--fade-in " id="services_dropdown" aria-labelledby="dropdownMenuContent" x-placement="bottom-end" >
      <div class="card-body py-1 d-flex flex-row align-items-center justify-content-center">
        <div class="row" id="services_message_container"></div>
        <div class="row" id="services_container">
          <?php
            if (!empty($sections))
            {
              foreach ($sections as $section) {
            ?>
              <div class="card mx-1" style="width: 18rem;" id="service_<?=$section['id'];?>">
                <div class="card-header">
                  <span id="service_caption_<?=$section['id'];?>"><?=$section['value'];?></span>
                  <a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить услугу" onclick="elementsModalHandler( 'add', <?=$section['id'];?>, 'Услугу', 2)" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>
                  <a role="button" onclick="elementsModalHandler( 'edit', <?=$section['id'];?>, '<?=$section['value'];?>', 1 )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>
                  <a role="button" onclick="elementsModalHandler( 'delete', <?=$section['id'];?>, '<?=$section['value'];?>', 1 )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                  <?php
                    if (!empty($section['section_items']))
                    {
                      foreach ($section['section_items'] as $section_item)
                      {
                  ?>    <li class="list-group-item" id="service_item_<?=$section_item['id'];?>">
                          <span id="service_item_caption_<?=$section_item['id'];?>"><?=$section_item['value'];?></span>
                          <a role="button" onclick="elementsModalHandler( 'edit', <?=$section_item['id'];?>, '<?=$section_item['value'];?>', 2 )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>
                          <a role="button" onclick="elementsModalHandler( 'delete', <?=$section_item['id'];?>, '<?=$section_item['value'];?>', 2 )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>
                        </li>                           
                  <?php
                      }
                    }
                  ?>
                </ul>
              </div>
            <?php
              }
            }
          ?>
        </div>
    </div>
  </div>
</div>

<div class="col-12 mt-1">
  <div class="card mx-auto border-left-danger shadow mb-2">
    <div class="card-header py-2 d-flex flex-row align-items-center justify-content-center">
      <div>
        <a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить слайд" onclick="elementsModalHandler( 'add', 'NULL', 'Слайд', 3)" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>
        <i class="fas fa-expand fa-2x text-gray-300"></i> Большой слайдер
        <a role="button" data-toggle="tooltip" data-placement="auto" title="Удалить текущий слайд" onclick="elementsModalHandler( 'delete', 0, 'Слайд', 3 )" class="btn btn-warning"><i class="fa fa-trash-alt text-white"></i></a>
      </div>
      
      <div class="dropdown no-arrow ml-auto">
        <a class="dropdown-toggle " href="#" role="button" id="dropdownMenuContent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#big_slider_dropdown').toggle();">
          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
      </div> 
    </div>
    <div class="dropdown-menu w-100 border-left-danger shadow animated--fade-in " id="big_slider_dropdown" aria-labelledby="dropdownMenuContent" x-placement="bottom-end" >
      <div class="card-body py-1 d-flex flex-row align-items-center justify-content-between">
        <div class="row" id="big_slider_message_container"></div>
          <?php
            $image_list = get_filenames( dirname(APPPATH).'/assets/img/BigSlider/mobile' );
            $i=0;
            echo '<div id="carousel_big_slider" class="bg-secondary carousel slide" data-ride="carousel">'.
              '<div class="carousel-inner" id="big_slider_container">';
            if ( !empty($image_list))
            {
              foreach ($image_list as $image)
              {
                ++$i;
                if ($i==1) {
                    $active = "active";
                }else{
                    $active = '';
                }
            ?>
                <div class="carousel-item <?=$active;?>">
                  <img src="<?=base_url( '/assets/img/BigSlider/desctop/'.$image );?>" class="d-block w-100" alt="slide <?=$image;?>">
                </div>
          <?php
              }
          ?>          
          <?php
            }
          ?>
            </div>
            <a class="carousel-control-prev" href="#carousel_big_slider" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel_big_slider" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="col-12 mt-1">
  <div class="card mx-auto border-left-info shadow mb-2">
    <div class="card-header py-2 d-flex flex-row align-items-center justify-content-center">
      <div>
        Статические записи
      </div>
      
      <div class="dropdown no-arrow ml-auto">
        <a class="dropdown-toggle " href="#" role="button" id="dropdownMenuContent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#captions_dropdown').toggle();">
          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
      </div> 
    </div>
    <div class="dropdown-menu w-100 border-left-info shadow animated--fade-in " id="captions_dropdown" aria-labelledby="dropdownMenuContent" x-placement="bottom-end" >
      <div class="card-body py-1 d-flex flex-row align-items-center justify-content-center">
        <div class="row" id="captions_container">
          <?php
            foreach ($captions as $caption)
            {
              //3 pdf link, 4- main title, 5-main text, 6 - contacts 7,8,9 - statistic
              switch ($caption['type']) {
                case 'pdf_link':
                  $caption_header = 'Ссылка "Скачать PDF"';
                  $type = 3;
                break;
                case 'title':
                  $caption_header = 'Заголовок на главной';
                  $type = 4;
                break;
                case 'text':
                  $caption_header = 'Текст на главной';
                  $type = 5;
                break;
                case 'contact':
                  $caption_header = 'Контакты';
                  $type = 6;
                break;
                case 'statistic_1':
                  $caption_header = 'Статистика 1';
                  $type = 7;
                break;
                case 'statistic_2':
                  $caption_header = 'Статистика 2';
                  $type = 8;
                break;
                case 'statistic_3':
                  $caption_header = 'Статистика 3';
                  $type = 9;
                break;
                
                default:
                  $caption_header = 'fatal error';
                  $type = 0;
                break;
              }
              if ($type <= 6 ) {
                if (empty($caption['value'])) {
                  $caption_text = 'Пусто';
                }else{
                  $caption_text = $caption['value'];
                }
              }else if($type > 6 ){
                if (empty($caption['value'])) {
                  $caption_val = 'Пусто';
                }else{
                  $caption_val = $caption['value'];
                }

                if (empty($caption['comments'])) {
                  $text = 'Пусто';
                }else{
                  $text = $caption['comments'];
                }

                $caption_text = $text.': '.$caption_val;
              }
              
          ?>
              <div class="card mx-1" style="width: 18rem;">
                <div class="card-header">
                  <span><?=$caption_header;?></span>
                  <a role="button" onclick="elementsModalHandler( 'edit', <?=$caption['id'];?>, '<?=$caption_header;?>', <?=$type;?> )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item" id="element_main_<?=$caption['id'];?>_<?=$type;?>"><?=$caption_text;?></li>
                </ul>
              </div>
          <?php
            }
          ?>
        </div>
    </div>
  </div>
</div>
    

<script type="text/javascript">
    let timeout = 500;
  function elementsModalHandler(type, id, name, element_type)
  {
    $( '#mainModalForm' ).empty();
    switch (type)
    {
      case 'add':
          console.log('add elements modal called');
          $( '#mainModalLabel' ).text('Добавить '+name);
          getFormObject( '#mainModalForm', element_type, id );
          $('#mainModal').modal('show');                
      break;

      case 'edit':
          $( '#mainModalLabel' ).text('Редактировать елемент: '+name);
          getelementModal(id, element_type);
          $('#mainModal').modal('show');
      break;

      case 'delete':
          $( '#mainModalLabel' ).text("Удалить елемент: "+name+"?");
          $( '#mainModalForm' ).append(              
              '<a role="button" class="btn btn-danger text-white" onclick="deleteelement('+id+', '+element_type+')">Удалить елемент</a>'
          );
          $('#mainModal').modal('show');
      break;    
      default:
        alert( 'modal call error' );
    }
  }

    function getFormObject( target, form_type, id )
    {
        $( target ).empty();
        let form_object = '', input_object='', text_label='', text_submit='';
        if (form_type == 1){
          text_label='Заголовок колонки';
          text_submit='колонку';
        }else if( form_type == 2 ){
          input_object='<input type="hidden" name="section_id" value="'+id+'">';
          text_label='Название услуги';
          text_submit='услугу';
        }
        switch(form_type)
        {
          case 1:
          case 2:
              form_object = 
                  '<div class="form-group">'+
                      '<label for="inputName">'+text_label+'</label>'+
                      input_object+
                      '<input type="text" name="header" class="form-control" id="inputName" placeholder="'+text_label+'">'+
                  '</div>'+
                  '<div class="form-group">'+
                      '<a role="button" class="btn btn-success text-white" onclick="addelement('+form_type+')">Добавить '+text_submit+'</a>'+
                  '</div>';
          break;
          case 3:
              form_object = 
                  '<div class="form-group">'+
                      '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png, svg; 1920х1080, до 2мб ) для компьютера</label>'+
                      '<input type="file" name="img_desctop" id="inputLogo" class="form-control">'+
                  '</div>'+
                  '<div class="form-group">'+
                      '<label for="inputLogoMobile">Изображение(разрешенные форматы: jpeg, gif, png, svg; 1920х1080, до 2мб) для телефона(не больше чем 212х212 пикселей)</label>'+
                      '<input type="file" name="img_mobile" id="inputLogoMobile" class="form-control">'+
                  '</div>'+
                  '<div class="form-group">'+
                      '<a role="button" class="btn btn-success text-white" onclick="addelement('+form_type+')">Добавить изображение</a>'+
                  '</div>';
          break;
          // case '4':
          //     form_object = 
          //         '<div class="form-group">'+
          //             '<label for="inputDescription">Текст</label>'+
          //             '<textarea class="form-control" id="inputDescription" rows="3" name="text"></textarea>'+
          //         '</div>'+
          //         '<div class="form-group">'+
          //             '<a role="button" class="btn btn-success text-white" onclick="addelement('+type+')">Добавить текст</a>'+
          //         '</div>';
          // break;
          default:
          return alert('wrong element type');
        }
        
        $( target ).append( form_object );
    }

    function addelement(type)
    {
        console.log('new form data orig');
        console.log(new FormData(document.forms['mainModalForm']));
        let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('request', 'add_product'); from prev ver
        if ( type == 3 ) {
            form_data.append('img_desctop', $('#mainModalForm input[name="img_desctop"]').val() );
            form_data.append('img_mobile', $('#mainModalForm input[name="img_mobile"]').val() );
            if ( $('#big_slider_container').length == 0 ) {
              form_data.append('active', 'active' );
            }
        }
        $.ajax({
            url: base_url+"admin/add_element_main/"+type+'/',
            type:"post",
            data: form_data,
            processData:false,
            contentType:false,
            cache:false
            // async:false,
        })
        .done(function( result ) {
            // alert("Upload Image Successful.");
                console.log(result);

            if ( result.status == 1 )
            {
              if ( result.type == 1) {
                checkContentEmpty('elements', 'Нет колонок.', 'Добавить колонку.', 'services_container', 'services_message_container', '\'add\', \'NULL\', \'Заголовок колонки\', 1');  
              }else if ( result.type == 3) {
                checkContentEmpty('elements', 'Нет элементов слайдера.', 'Добавить элемент слайдера.', 'big_slider_container', 'big_slider_message_container', '\'add\', \'NULL\', \'Слайд\', 3');
              }
                
              $( '#'+result.target_block ).append(
                result.response
              );

            }else{ 
                timeout = 3000;
            }

            let message = '<div class="alert alert-'+(result.status==1 ? "success" : "danger")+'">';

            message += result.message;
            
            message += "</div>";

            $( "#mainModalMessage" ).append( message );

            modalMessageHandler(timeout, 0);
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
    }

    function getelementModal(id, element_type)
    {
        $.ajax({
            url: base_url+"admin/get_element_main/"+id+'/'+element_type,
            method: "POST",
            data: {}
            // dataType: "html"
        })
        .done(function( result ) {
            console.log('get product modal ajax');
            console.log(result);
            let modal_content;
            $( '#mainModalForm' ).empty();
            // alert(result.product.name);
            if ( result.status == 0 )
            {
                modal_content = 'Произошла ошибка: элемент не найден';               
            }else{
                modal_content = result.response;
            }

            $( '#mainModalForm' ).append(modal_content);
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
    }

    function editelement( id, element_type )
    {       
        let form_data = new FormData(document.forms['mainModalForm']);
        
        // let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        $.ajax({
            url: base_url+"admin/edit_element_main/"+id+'/'+element_type,
            type:"post",
            data: form_data,
            processData:false,
            contentType:false
            // cache:false,
            // async:false,
        })
        .done(function( result ) {
            // alert("Upload Image Successful.");
                console.log(result);

            if ( result.status == 1 )
            {
              if ( (element_type==1) || (element_type==2) )
              {
                $( '#'+result.target_block ).empty();
                $( '#'+result.target_block ).append(result.response);
              }else if( element_type > 2 )
              {
                $( '#element_main_'+id+'_'+element_type ).empty();
                $( '#element_main_'+id+'_'+element_type ).append(result.response);
              }
                
            }else{ 
                timeout = 3000;
            }

            let message = '<div class="alert alert-'+(result.status==1 ? "success" : "danger")+'">';

            message += result.message;
            
            message += "</div>";

            $( "#mainModalMessage" ).append( message );

            modalMessageHandler(timeout, result.status);
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
    }

    function deleteelement(id, element_type)
    {
        let form_data = new FormData();
        if ( element_type == 3 ) {
            var slide = $('#big_slider_container > .carousel-item.active > img').attr('src');
            form_data.append( 'slide_name', slide.slice( slide.lastIndexOf('/') ) );
            // console.log('path is  '+ './'+ );
        }
        $.ajax({
            data: form_data,
            url: base_url+"admin/delete_element_main/"+id+'/'+element_type,
            method: "POST",
            processData:false,
            contentType:false
            // dataType: "html"
        })
        .done(function( result ) {
            console.log('delete element psoted');
            console.log(result);
            
            if ( result.status == 1 )
            {
              if ( element_type == 1 ) {
                $( '#'+result.element ).remove();
                checkContentEmpty('elements', 'Нет колонок.', 'Добавить колонку.', 'services_container', 'services_message_container', '\'add\', \'NULL\', \'Заголовок колонки\', \'1\'');
              }else if ( element_type == 2 ) {
                $( '#'+result.element ).remove();
              }else if ( element_type == 3 ) {
                $('img[src="'+slide+'"]').parent().remove();
                checkContentEmpty('elements', 'Нет элементов слайдера.', 'Добавить элемент слайдера.', 'big_slider_container', 'big_slider_message_container', '\'add\', \'NULL\', \'Слайд\', 3');
              }else{
                
              }
            }else{ 
                timeout = 3000;
            }

            let message = '<div class="alert alert-'+(result.status==1 ? "success" : "danger")+'">';
        
            message += result.message;
            
            message += "</div>";

            $( "#mainModalMessage" ).append( message );

            modalMessageHandler(timeout, result.status);
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
        
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
      // getMaxPages('consultations');
      checkContentEmpty('elements', 'Нет колонок.', 'Добавить колонку.', 'services_container', 'services_message_container', '\'add\', \'NULL\', \'Заголовок колонки\', 1');

      checkContentEmpty('elements', 'Нет элементов слайдера.', 'Добавить элемент слайдера.', 'big_slider_container', 'big_slider_message_container', '\'add\', \'NULL\', \'Слайд\', 3');
      // checkContentEmpty('slider2', 'Нет элементов слайдера.', 'Добавить элемент слайдера.', 'slider2-container', 'slider2-message-container');
    });
</script>

