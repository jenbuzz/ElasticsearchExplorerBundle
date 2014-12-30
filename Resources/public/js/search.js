$('#search-select-index').on('change', function() {
  document.location+= $(this).val();
});

$('#search-select-type').on('change', function() {
  document.location+= $(this).val();
});
