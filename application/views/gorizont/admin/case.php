<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <?=$portfolio->header?>
        <a role="button" onclick="elementsModalHandler( 'add' )" class="btn btn-success"><i class="fa fa-plus text-white"></i></a>
    </h1>
<!--     <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    	<i class="fas fa-download fa-sm text-white-50"></i>
    	Generate Report
    </a>   -->
</div>
<?php
?>
<div class="row">
    <div class="col mt-1">
        <div class="card border-left-success shadow mb-4">
          <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary mx-auto">
                  <i class="fas fa-expand fa-2x text-gray-300"></i>Фон
                </h6>

                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle " href="#" role="button" id="dropdownMenuContent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#background-dropdown').toggle();">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                </div>   
            </div>
            <div class="dropdown-menu w-100 shadow animated--fade-in " id="background-dropdown" aria-labelledby="dropdownMenuContent" x-placement="bottom-end" >
              <!-- Card Body -->
                <div class="col-12 mt-1">
                    <div id="element_background" class="card mx-auto border-left-success shadow mb-2">
                        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                            <span id="element_body_background" class="m-0 mx-auto">
                                <?php
                                    $image_background = array_diff(scandir(dirname(APPPATH).'/assets/img/cases/'.$portfolio->id.'/background'), array('..', '.', '.DS_Store'));
                                    $image_background_path = base_url( '/assets/img/cases/'.$portfolio->id.'/background/'.$image_background[2] );
                                    // print_r($image_background);
                                ?>
                                <img src="<?=$image_background_path;?>" class="img-fluid">
                            </span> 
                        </div>
                        <div class="card-body py-1 d-flex flex-row align-items-center justify-content-between">
                            <form id="backgroundForm" name="backgroundForm">
                                <div class="form-group">
                                    <label>Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб)</label>
                                    <input type="file" name="img" class="form-control">
                                </div>
                                <div class="form-group">
                                    <a role="button" class="btn btn-info text-white" onclick="updatebackground(<?=$portfolio->id;?>, 4)">Изменить фон</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Row -->
<div class="row" id="element-message-container"></div>
<div class="row" id="elements-container">
    <div class="col-12 mt-1">    
    <?php
    
        if ( !empty( $elements ) ) {
            foreach ($elements as $element) {
                switch ( $element['name'] ) {
                    case 'header':
                        $type = 1;
                        $color = 'info';
                    break;
                    case 'text':
                        $type = 2;
                        $color = 'primary';
                    break;
                    case 'image':
                        $type = 3;
                        $color = 'warning';
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
                    echo '<div class="col-12 mt-1">'.
                            '<div id="element_'.$element['id'].'" class="card mx-auto border-left-'.$color.' shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    '<h6 id="element_body_'.$element['id'].'" class="m-0 font-weight-bold text-primary mx-auto">'.
                                        substr($element['value'], 0, 15).'...'.
                                    '</h6>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'edit\', '.$element['id'].', \' '.substr($element['value'], 0, 15).'... \', '.$type.' )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'delete\', '.$element['id'].', \' '.substr($element['value'], 0, 15).'... \', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                }elseif ( $element['name'] == 'image' ) {
                    echo '<div class="col-12 mt-1">'.
                            '<div id="element_'.$element['id'].'" class="card mx-auto border-left-'.$color.' shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    '<span id="element_body_'.$element['id'].'" class="m-0 mx-auto">'.
                                        '<img src="'.$image.'" class="img-fluid">'.
                                    '</span>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'edit\', '.$element['id'].', \''.$image_name[0].'\', '.$type.' )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'delete\', '.$element['id'].', \' '.$image_name[0].' \', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                }elseif ( $element['name'] == 'slider' ) {
                    $image_list = get_filenames( dirname(APPPATH).'/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'] );
                    $slide = $type+1;
                    echo '<div class="col-12 mt-1">'.
                            '<div id="element_'.$element['id'].'" class="card mx-auto border-left-danger shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить слайд" onclick="elementsModalHandler( \'add_slider_item\', '.$element['id'].', \'Слайд\', '.$element['position'].')" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Удалить текущий слайд" onclick="elementsModalHandler( \'delete\', '.$element['id'].', \'Слайд\', '.$slide.' )" class="btn btn-warning"><i class="fa fa-trash-alt text-white"></i></a>'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Удалить слайдер" onclick="elementsModalHandler( \'delete\', '.$element['id'].', \'Слайдер\', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                                '<div class="card-body py-1 d-flex flex-row align-items-center justify-content-between">'.
                                    '<div id="carousel_'.$element['id'].'" class="carousel slide" data-ride="carousel">'.
                                        '<div class="carousel-inner" id="carousel_container_'.$element['id'].'">';
                                        $i=0;
                                        if ( !empty($image_list)) {
                                            foreach ($image_list as $image) {
                                                ++$i;
                                                if ($i==1) {
                                                    $active = "active";
                                                }else{
                                                    $active = '';
                                                }
                                                echo '<div class="carousel-item '.$active.'">'.
                                                  '<img src="'.base_url( '/assets/img/cases/'.$element['portfolio_id'].'/'.$element['position'].'/'.$image ).'" class="d-block w-100" alt="slide '.$image.'">'.
                                                '</div>';
                                            }
                                        }
                                    echo '</div>'.
                                        '<a class="carousel-control-prev" href="#carousel_'.$element['id'].'" role="button" data-slide="prev">'.
                                            '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'.
                                            '<span class="sr-only">Previous</span>'.
                                        '</a>'.
                                        '<a class="carousel-control-next" href="#carousel_'.$element['id'].'" role="button" data-slide="next">'.
                                            '<span class="carousel-control-next-icon" aria-hidden="true"></span>'.
                                            '<span class="sr-only">Next</span>'.
                                        '</a>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            }
        }
    ?>

</div>
<div class="row mx-auto mt-2" id="elements-paginator"></div>
<script type="text/javascript">
    let timeout = 500;
	function elementsModalHandler(type, id, name, element_type)
    {
        $( '#mainModalForm' ).empty();
        switch (type) {
            case 'add':
                console.log('add elements modal called');
                $( '#mainModalLabel' ).text('Добавить элемент');         
                $( '#mainModalForm' ).append(
                    '<div class="form-check form-check-inline">'+
                      '<input class="form-check-input" type="radio" onclick="getFormObject( \'#elementsAddFormContainer\', $(\'input[name=elementRadioType]:checked\').val() );" name="elementRadioType" value="1">'+
                      '<label class="form-check-label">Заголовок</label>'+
                    '</div>'+
                    '<div class="form-check form-check-inline">'+
                      '<input class="form-check-input" type="radio" onclick="getFormObject( \'#elementsAddFormContainer\', $(\'input[name=elementRadioType]:checked\').val() );" name="elementRadioType" value="2">'+
                      '<label class="form-check-label">Текст</label>'+
                    '</div>'+
                    '<div class="form-check form-check-inline">'+
                      '<input class="form-check-input" type="radio" onclick="getFormObject( \'#elementsAddFormContainer\', $(\'input[name=elementRadioType]:checked\').val() );" name="elementRadioType" value="3">'+
                      '<label class="form-check-label">Картинка</label>'+
                    '</div>'+
                    '<div class="form-check form-check-inline">'+
                      '<input class="form-check-input" type="radio" onclick="getFormObject( \'#elementsAddFormContainer\', $(\'input[name=elementRadioType]:checked\').val() );" name="elementRadioType" value="4">'+
                      '<label class="form-check-label">Слайдер</label>'+
                    '</div>'+
                    '<div id="elementsAddFormContainer"></div>'
                );
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

            case 'add_slider_item':
                $( '#mainModalLabel' ).text("Добавить слайд?");
                $( '#mainModalForm' ).append(              
                    '<div class="form-group">'+
                        '<input type="hidden" name="slider_id" value="'+id+'">'+
                        '<input type="hidden" name="slider_position" value="'+element_type+'">'+
                        '<input class="d-none" type="radio" name="elementRadioType" checked value="5">'+
                        '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб )</label>'+
                        '<input type="file" name="img" id="inputLogo" class="form-control">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addelement()">Добавить слайд</a>'+
                    '</div>'
                );
                $('#mainModal').modal('show');
            break;
          
            default:
                alert( 'modal call error' );
        }
    }

    function getFormObject( target, form_type )
    {
        $( target ).empty();
        let form_object = '';
        switch(form_type)
        {
            case '1':
                form_object = 
                    '<div class="form-group">'+
                        '<label for="inputName">Текст заголовка</label>'+
                        '<input type="text" name="header" class="form-control" id="inputName" placeholder="Текст заголовка">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addelement()">Добавить заголовок</a>'+
                    '</div>';
            break;
            case '2':
                form_object = 
                    '<div class="form-group">'+
                        '<label for="inputDescription">Текст</label>'+
                        '<textarea class="form-control" id="inputDescription" rows="3" name="text"></textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addelement()">Добавить текст</a>'+
                    '</div>';
            break;
            case '3':
                form_object = 
                    '<div class="form-group">'+
                        '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб )</label>'+
                        '<input type="file" name="img" id="inputLogo" class="form-control">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addelement()">Добавить изображение</a>'+
                    '</div>';
            break;
            case '4':
                form_object = 
                    '<div class="form-group">'+
                    '<input type="hidden" name="slider" value="true">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addelement()">Добавить слайдер</a>'+
                    '</div>';
            break;
            default:
            return alert('wrong element type');

        }
        
        $( target ).append( form_object );
    }

    function addelement()
    {
        console.log('new form data orig');
        console.log(new FormData(document.forms['mainModalForm']));
        let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('request', 'add_product'); from prev ver
        if ( $('#mainModalForm input[name="img"]').val() != undefined ) {
            form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        }
        $.ajax({
            url: base_url+"admin/add_element/"+$('input[name=elementRadioType]:checked').val()+'/<?=$portfolio->id;?>',
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
                if ( result.slider == 1) {
                    $( '#carousel_container_'+result.slider_id ).append(
                        result.response
                    );
                }else{
                    $( '#elements-container' ).append(
                        result.response
                    );
                }
                
                checkContentEmpty('elements', 'Нет элементов.', 'Добавить элемент.', 'elements-container', 'element-message-container'); 
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
            url: base_url+"admin/get_element/"+id+'/'+element_type,
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
        if ( $('#mainModalForm input[name="img"]').val() != undefined ) {
            form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        }
        
        // let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        $.ajax({
            url: base_url+"admin/edit_element/"+id+'/'+element_type,
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
                $( '#element_body_'+id ).empty();
                $( '#element_body_'+id ).append(result.response);
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

    function updatebackground( id, element_type )
    {       
        let form_data = new FormData(document.forms['backgroundForm']);
        form_data.append('img', $('#backgroundForm input[name="img"]').val() );
        
        // let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        $.ajax({
            url: base_url+"admin/edit_element/"+id+'/'+element_type,
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
                $( '#element_body_'+result.target ).empty();
                $( '#element_body_'+result.target ).append(result.response);
            }else{ 
                timeout = 3000;
            }
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
    }

    function deleteelement(id, element_type)
    {
        let form_data = new FormData();
        if ( element_type == 5 ) {
            var slide = $('#carousel_container_'+id+' > .carousel-item.active > img').attr('src');
            form_data.append( 'slide_name', './'+slide.substr(base_url.length) );
            console.log('path is  '+ './'+slide.substr(base_url.length));
        }
        $.ajax({
            data: form_data,
            url: base_url+"admin/delete_element/"+id+'/'+element_type,
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
                if ( element_type == 5 ) {
                    $('img[src="'+slide+'"]').parent().remove();
                }else{
                    $( '#'+result.element ).remove();
                    checkContentEmpty('elements', 'Нет элементов.', 'Добавить элемент.', 'elements-container', 'element-message-container');
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
        checkContentEmpty('elements', 'Нет елементов.', 'Добавить елемент.', 'elements-container', 'element-message-container');
    });
</script>
