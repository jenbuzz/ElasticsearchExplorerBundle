$('#search-select-index').on('change', function() {
  var arrUrl = $(location).attr('href').split('/');
  if ($(this).val()!=-1 && $(this).val()!=arrUrl[arrUrl.length-2]) {
    document.location+= $(this).val();
  }
});

$('#search-select-type').on('change', function() {
  var arrUrl = $(location).attr('href').split('/');
  if ($(this).val()!=-1 && $(this).val()!=arrUrl[arrUrl.length-2]) {
    document.location+= $(this).val();
  }
});
