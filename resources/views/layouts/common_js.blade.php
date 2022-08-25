<script type="text/javascript">

 function confirmationDelete(anchor) {
       let title=anchor.attr("id");
       let url=anchor.attr("href");
        swal({
            title: title,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location = anchor.attr("href");

            }
        });
    }

 function showArchived(e) {


 	   var id= e.target.id;
 	   switch(id) {
		    case 'customCheck1':
		    var route="{{ route('archiveCategory') }}"
		    break;

		    case 'customCheck11':
		    var route="{{ route('archiveBeneficaiary') }}"
		    break;

		    case 'customCheck123':
		    var route="{{ route('archiveBank') }}"
		    break;

		    case 'customCheck1234':
		    var route="{{ route('archiveExpense') }}"
		    break;

		   default:
		    var route="Not Found"
		  }

 	if(e.target.checked){
     $.post(route, { _token:"{{ csrf_token() }}"},
           function(data){
            console.log("sucess",data);
            if(data.success==true)
            {

                $('#abc').html(data.html);
                oSettings= $('#dataTable').DataTable({
                   language: {
                    paginate: {
                      next: '<i class="fas fa-angle-right"></i>',
                      previous: '<i class="fas fa-angle-left"></i>'
                    }

                  },
                   "pageLength": 20

                });
                // oSettings.columns.adjust().draw();

            }

          }).fail(function(data){
             console.log("error",data);
          });
    }
  else{
       /* $.get("{{ route('categories') }}", { _token:"{{ csrf_token() }}"},
           function(data){
            console.log("sucess",data);
            if(data.success==true)
            {

                //data.data.forEach(myFunction);

                $('#abc').html(data.html);
                $('#dataTable').DataTable({
                   language: {
                    paginate: {
                      next: '<i class="fas fa-angle-right"></i>',
                      previous: '<i class="fas fa-angle-left"></i>'
                    },
                    "pageLength": 50

                  }
                });
            }

          }).fail(function(data){
             console.log("error",data);
          });*/
          location.reload();
    }

}//end show archive



</script>
