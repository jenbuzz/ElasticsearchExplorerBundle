$('#search-select-index').on('change', function() {
  if ($(this).val()!=-1) {
    document.location+= $(this).val();
  }
});

$('#search-select-type').on('change', function() {
  if ($(this).val()!=-1) {
    document.location+= $(this).val();
  }
});
