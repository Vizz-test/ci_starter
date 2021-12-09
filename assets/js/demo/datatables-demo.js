// Call the dataTables jQuery plugin

$(document).ready(function() {
  let dataTableLength;
  if(localStorage.getItem('dataTableLength') !== null){
    dataTableLength = localStorage.getItem('dataTableLength');
  }else{
    dataTableLength = 10;
  }

  $('body').on('change', 'select[name=dataTable_length]', function(){
      localStorage.setItem('dataTableLength', $(this).val()); 
  })

  $('#dataTable').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": dataTableLength,
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
  });
});
