<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>           
</div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Хотите покинуть админ-панель?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Нажмите "Выйти" чтобы завершить текущую сессию.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Отменить</button>
          <button type="button" class="btn btn-primary" onclick="logout()">Выйти</button>
        </div>
      </div>
    </div>
  </div>

  <!-- modals -->
  <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mainModalLabel">Заголовок</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <form id="mainModalForm" name="mainModalForm">
          </form>
          <div id="mainModalMessage"></div>
        </div>
      </div>
    </div>
  </div>

<!-- end modals -->

  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('assets/admin/sb_admin2/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?=base_url('assets/admin/sb_admin2/vendor/jquery-easing/jquery.easing.min.js');?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url('assets/admin/sb_admin2/js/sb-admin-2.min.js');?>"></script>

  <!-- TURN ON ONLY ON NEEDED PAGES -->
  <!-- Page level plugins -->
  <!-- <script src="<?//=base_url('assets/admin/sb_admin2/vendor/chart.js/Chart.min.js');?>"></script> -->

  <!-- Page level custom scripts -->
<!--   <script src="<?//=base_url('assets/admin/sb_admin2/js/demo/chart-area-demo.js');?>"></script>
  <script src="<?//=base_url('assets/admin/sb_admin2/js/demo/chart-pie-demo.js');?>"></script> -->

<script type="text/javascript">
  const base_url = '<?=base_url();?>';
  let page = 1, max_pages;
  $(window).on("load",function(){
      console.log('template footer loaded');
      $('[data-toggle="tooltip"]').tooltip();
      $('[data-toggle="popover"]').popover();           
  });

  function logout()
  {
    $.ajax({
        url: base_url+"admin_logout",
        method: "POST",
        data: {}
        // dataType: "html"
    })
    .done(function( result ) {

        if (result.status == 0)
        {
            let message = "<div class='alert alert-danger'>";
            message += result.message;
            message += "</div>";
            alert(message);
        }else{
            window.location.assign(result.new_location);
        }
        
    })
    .fail(function( jqXHR, text, Status ) {
        alert(jqXHR.responseText);
    }); 
  }
  
  function checkContentEmpty(type, caption1, caption2, target_block, message_block, arguments)
  {
    if ( $('#'+target_block).children().length == 0 )
    {
      console.log('block is empty');
      let args_list;
      if (arguments==undefined) {
        args_list = '\'add\'';
      }else{
        args_list = arguments;
      }
      $('#'+message_block).append(
        '<div class="alert alert-info text-center mx-auto" id="add_action">'+
          caption1+
          '<a onclick="'+type+'ModalHandler( '+args_list+' )" class="btn btn-success">'+caption2+'</a>'+
        '</div>'
        );
    }else{
      console.log('remover called');
      $( '#'+message_block+'> #add_action' ).remove();
    }
  }

  function getMaxPages(table)
  {
    console.log('max pages called '+ table);
    $.ajax({
      url: base_url+"get_tables_pages",
      method: "GET",
      data: {table:table}
      // dataType: "html"
    })
    .done(function( result ) {
      console.log(result);
      if ( result.new_consultations > 0 )
      {
        $('#new_consultations').text(result.new_consultations);
      }

      if ( result.status == 1 )
      {
        max_pages = result.pages;
        console.log('page is '+page+' max pages r '+max_pages);
        if (page >= max_pages) {
            $("#"+table+"-paginator > #load_more_items").remove();
            console.log("no more items");
        }else{
            if ( $('#'+table+'-paginator').children().length == 0 ){ 
                $('#'+table+'-paginator').append('<button id="load_more_items" class="btn btn-primary mx-auto text-center" onclick="getMoreItems(\''+table+'\')">Загрузить еще</button>');
            }
        }
      }
    })
    .fail(function( jqXHR, text, Status ) {
      alert('error '+Status);
    });
  }

  function modalMessageHandler(timeout, status, modal, modal_message)
  {
    if (modal_message == undefined)
    {
     modal_message = $('#mainModalMessage');
    }

    if (modal == undefined)
    {
     modal = $('#mainModal');
    }

    setTimeout(function() {
        modal_message.fadeOut( "slow", function() {
            modal_message.empty();
            if ( status == 1 )
            {
                modal.modal('hide');
                modal.on('hidden.bs.modal', function (e) {
                     
                    modal.modal('dispose');
                });
            }
            modal_message.removeAttr('style');   
        });
    }, timeout);
  }
</script>

<?php 
  if ( current_url() == base_url('admin/events') || current_url() == base_url('admin/articles')  )
  {
?>  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<?php  } ?>

</body>

</html>