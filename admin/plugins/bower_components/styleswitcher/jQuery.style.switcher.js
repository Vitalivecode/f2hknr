// Theme color settings
$(document).ready(function(){
function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }
 $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
		var baseUrl = $("#BaseUri").data('url');
		var csrf = $('input[name="8i5PtJZ5g8"]').val();
		$.ajax({
			url: baseUrl + "settings/theme",
			type:'POST',
			data: { 'theme':currentStyle,'8i5PtJZ5g8':csrf }, 
			beforeSend: function() {
				$(".preloader").css('display','block');
			},
			success:function(res)
			{
				if(res == 'true')
				{
					store('theme', currentStyle);
					$('#theme').attr({href: 'css/colors/'+currentStyle+'.css'});
					$(".preloader").css('display','none');
					$.toast({
						heading: 'Theme',
						text: 'Successfully Changed',
						position: 'top-right',
						loaderBg: '#ff6849',
						icon: 'success',
						hideAfter: 3500,
						stack: 6
					})

				}
				else
				{
					$(".preloader").css('display','none');
					$.toast({
						heading: 'Error',
						text: 'Please Refresh the page',
						position: 'top-right',
						loaderBg: '#ff6849',
						icon: 'error',
						hideAfter: 3500,
						stack: 6
					})
				}
			},
			error: function(e,s) {
				alert(e.responseText);         
			}
		}); 
    });

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'});
    }
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });

});
 function get(name) {
  }

$(document).ready(function(){
    $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
		store('theme', currentStyle);
		$('#theme').attr({href: 'css/colors/'+currentStyle+'.css'});
    });
    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'});
    }
    // color selector
$('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });
});
