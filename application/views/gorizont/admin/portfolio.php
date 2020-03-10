<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Портфолио
        <a role="button" onclick="portfolioModalHandler( 'add' )" class="btn btn-success"><i class="fa fa-plus text-white"></i></a>
    </h1>
<!--     <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    	<i class="fas fa-download fa-sm text-white-50"></i>
    	Generate Report
    </a>   -->
</div>

<!-- Content Row -->
<div class="row" id="portfolio-message-container"></div>
<div class="row" id="portfolios-container">
	<?php
		if ( isset($portfolios) )
		{
			foreach ($portfolios as $portfolio):
	?>
    		<div class="card mr-1 mt-1" style="width: 18rem;" id="portfolio_<?=$portfolio['id'];?>">
    			<img src="<?=base_url('assets/img/cases/'.$portfolio['id'].'/'.$portfolio['img']);?>" class="card-img-top" alt="portfolio pic">
    			<div class="card-body">
    		    	<h5 class="card-title"><?=$portfolio['header'];?></h5>
    		    	<p class="card-text"><?=$portfolio['description'];?></p>
    		    	<a href="<?=base_url('case/'.$portfolio['id']);?>" target="_blank" class="btn btn-primary">Просмотреть</a>
    		    	<a role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать кейс" onclick="portfolioModalHandler( 'edit', <?=$portfolio['id'];?>, '<?=$portfolio['header'];?>' )" class="btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>
    	            <a role="button" onclick="portfolioModalHandler( 'delete', <?=$portfolio['id'];?>, '<?=$portfolio['header'];?>' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>
                    <a href="<?=base_url('admin/case_handler/'.$portfolio['id']);?>" data-toggle="tooltip" data-placement="auto" title="Редактировать страницу кейса" class="btn btn-warning my-1"><i class="far fa-edit text-white"></i></a>
    			</div>
    		</div>
	<?php
			endforeach; 
		} 
	?>

</div>
<div class="row mx-auto mt-2" id="portfolios-paginator"></div>
<script type="text/javascript">
    let timeout = 500;
	function portfolioModalHandler(type, id, name)
    {
        $( '#mainModalForm' ).empty();
        switch (type) {
            case 'add':
                console.log('add portfolios modal called');
                $( '#mainModalLabel' ).text('Добавить кейс');         
                $( '#mainModalForm' ).append(
                    '<div class="form-group">'+
                        '<label for="inputName">Название кейса</label>'+
                        '<input type="text" name="header" class="form-control" id="inputName" placeholder="Название кейса">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label for="inputDescription">Описание кейса</label>'+
                        '<textarea class="form-control" id="inputDescription" rows="3" name="description"></textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб )</label>'+
                        '<input type="file" name="img" id="inputLogo" class="form-control">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-success text-white" onclick="addportfolio()" id="addportfolioModalFormSubmit">Добавить кейс</a>'+
                    '</div>'
                );
                $('#mainModal').modal('show');                
            break;

            case 'edit':
                $( '#mainModalLabel' ).text('Редактировать кейс: '+name);
                getportfolioModal(id);
                $('#mainModal').modal('show');
            break;

            case 'delete':
                $( '#mainModalLabel' ).text("Удалить кейс: "+name+"?");
                $( '#mainModalForm' ).append(              
                    '<a role="button" class="btn btn-danger text-white" onclick="deleteportfolio('+id+')">Удалить кейс</a>'
                );
                $('#mainModal').modal('show');
            break;
          
            default:
                alert( 'modal call error' );
        }
    }

    function addportfolio()
    {
        console.log('new form data orig');
        console.log(new FormData(document.forms['mainModalForm']));
        let form_data = new FormData(document.forms['mainModalForm']);
        // form_data.append('request', 'add_product'); from prev ver
        form_data.append('img', $('#inputLogo').val() );
        $.ajax({
            url: base_url+"admin/admin_add_portfolio",
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
                $( '#portfolios-container' ).append(
                    '<div class="card mr-1 mt-1" style="width: 18rem;" id="portfolio_'+result.id+'">'+
						'<img src="'+result.img+'" class="card-img-top" alt="portfolio pic">'+
						'<div class="card-body">'+
					    	'<h5 class="card-title">'+result.header+'</h5>'+
					    	'<p class="card-text">'+result.description+'</p>'+
					    	'<a href="'+base_url+'portfolio/'+result.id+'" target="_blank" class="btn btn-primary">Просмотреть</a>'+
					    	' <a role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать кейс" onclick="portfolioModalHandler( \'edit\', '+result.id+', \' '+result.header+' \' )" class="btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'+
            				' <a role="button" onclick="portfolioModalHandler( \'delete\', '+result.id+', \' '+result.header+' \' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'+
                            ' <a href="'+base_url+'admin/case_handler/'+result.id+'" role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать страницу кейса" class="btn btn-warning my-1"><i class="far fa-edit text-white"></i></a>'+
						'</div>'+
					'</div>'
                );
                checkContentEmpty('portfolios', 'Нет элементов.', 'Добавить элемент.', 'portfolios-container', 'portfolio-message-container'); 
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

    function getportfolioModal(id)
    {
        $.ajax({
            url: base_url+"admin/portfolio/"+id,
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
            if ( result.portfolio.status == 0 )
            {
                modal_content = 'Произошла ошибка: кейс не найден или не существует';               
            }else{
                modal_content = 
                    '<div class="form-group">'+
                        '<label for="inputName">Название кейса</label>'+
                        '<input type="text" name="header" class="form-control" id="inputName" placeholder="Название кейса" value="'+result.portfolio.header+'">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label for="inputDescription">Описание кейса</label>'+
                        '<textarea class="form-control" id="inputDescription" rows="3" name="description">'+result.portfolio.description+'</textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб )</label>'+
                        '<input type="file" name="img" id="inputLogo" class="form-control">'+
                    '</div>'+
                    '<input type="hidden" name="old_img" value="'+result.portfolio.img+'">'+
                    '<div class="form-group">'+
                        '<a role="button" class="btn btn-info text-white" onclick="editportfolio('+result.portfolio.id+')">Редактировать кейс</a>'+
                    '</div>';
                    $( '#mainModalForm' ).prepend(
                        '<img class="img-fluid" src="'+base_url+'assets/img/cases/'+result.portfolio.id+'/'+result.portfolio.img+'">'
                    ); 
            }

            $( '#mainModalForm' ).append(modal_content);
        })
        .fail(function( jqXHR, text, Status ) {
            alert(jqXHR.responseText);
        });
    }

    function editportfolio(id)
    {
        let form_data = new FormData(document.forms['mainModalForm']);
        form_data.append('img', $('#mainModalForm input[name="img"]').val() );
        $.ajax({
            url: base_url+"admin/admin_edit_portfolio/"+id,
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
                let modal_content;
                $( '#portfolio_'+id ).empty();
                modal_content =
                    '<img src="'+result.img+'" class="card-img-top" alt="portfolio pic">'+
						'<div class="card-body">'+
					    	'<h5 class="card-title">'+result.header+'</h5>'+
					    	'<p class="card-text">'+result.description+'</p>'+
					    	'<a href="'+base_url+'portfolio/'+result.id+'" target="_blank" class="btn btn-primary">Просмотреть</a>'+
					    	' <a role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать кейс" onclick="portfolioModalHandler( \'edit\', '+result.id+', \' '+result.header+' \' )" class="btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'+
            				' <a role="button" onclick="portfolioModalHandler( \'delete\', '+result.id+', \' '+result.header+' \' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'+
                            ' <a href="'+base_url+'admin/case_handler/'+result.id+'" role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать страницу кейса" class="btn btn-warning my-1"><i class="far fa-edit text-white"></i></a>'+
						'</div>';
                $('#portfolio_'+id).append(modal_content); 
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

    function deleteportfolio(id)
    {
        $.ajax({
            url: base_url+"admin/admin_delete_portfolio/"+id,
            method: "POST",
            // dataType: "html"
        })
        .done(function( result ) {
            console.log('delete portfolio psoted');
            console.log(result);
            
            if ( result.status == 1 )
            { 
                $( '#portfolio_'+id ).remove();
                checkContentEmpty('portfolios', 'Нет элементов.', 'Добавить элемент.', 'portfolios-container', 'portfolio-message-container'); 
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

    function getMoreItems(item)
    {
        if(page < max_pages){
            ++page;
            console.log("page: "+page+"; max page: "+max_pages);
            $.ajax({
                url: base_url+"admin/"+item,
                method: "POST",
                data: {page:page}
                // dataType: "html"
            })
            .done(function( result ) {
                console.log(result);
                if ( result.status == 1 )
                {
                    $.each(result.portfolios, function(index, value) {
                        $( "#portfolios-container" ).append(
                            '<div class="card mr-1 mt-1" style="width: 18rem;" id="portfolio_'+value.id+'">'+
                                '<img src="'+base_url+'assets/img/portfolios/'+value.id+'/'+value.img+'" class="card-img-top" alt="portfolio pic">'+
                                '<div class="card-body">'+
                                    '<h5 class="card-title">'+value.header+'</h5>'+
                                    '<p class="card-text">'+value.text+'</p>'+
                                    '<a href="'+base_url+'portfolio/'+value.id+'" target="_blank" class="btn btn-primary">Просмотреть</a>'+
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать кейс" onclick="portfolioModalHandler( \'edit\', '+value.id+', \' '+value.header+' \' )" class="btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'+
                                    ' <a role="button" onclick="portfolioModalHandler( \'delete\', '+value.id+', \' '+value.header+' \' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'+
                                    ' <a href="'+base_url+'admin/case_handler/'+result.id+'" role="button" data-toggle="tooltip" data-placement="auto" title="Редактировать страницу кейса" class="btn btn-warning my-1"><i class="far fa-edit text-white"></i></a>'+
                                '</div>'+
                            '</div>'
                        );
                    });
                    
                }else{
                    alert(result.message);
                }
                
            })
            .fail(function( jqXHR, text, Status ) {
                alert('error '+Status);
            });
        }
        if (page >= max_pages) {
            $("#load_more_items").remove();
            console.log("no more items");
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        checkContentEmpty('portfolio', 'Нет элементов.', 'Добавить элемент.', 'portfolios-container', 'portfolio-message-container');

        getMaxPages('portfolio');

        window.setInterval(function()
        {
            getMaxPages('portfolio');
        }, 300000);
    });
</script>
