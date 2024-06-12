$(document).on('click','input[name="master-options"]',function (){ 
    var dis =$(this).closest("tr");
    // var status = $('.master-options').get(0).checked;
    if($(this).prop("checked") == true){
        dis.find('td .mcheck').removeAttr('disabled');
    }
    else if($(this).prop("checked") == false){
        dis.find('td .mcheck').prop("checked",false);
        dis.find('td .mcheck').attr('disabled','disabled');
    }
});   
$(document).on('click','#selectalloptions',function (){ 
    if(this.checked) {
    // Iterate each checkbox
        $(':checkbox').each(function() {
            $('.mcheck').removeAttr('disabled');
            this.checked = true;      
        });
    } else {
        $(':checkbox').each(function() {
            $('.mcheck').attr('disabled','disabled');
            this.checked = false;                       
        });
    }
});
//apiKey: "AIzaSyAzfHe-pCjhXNZkUV3g2sl6StKNypihThY"
$(document).ready(function() {
    var config = {
            apiKey: "AIzaSyATKICKkAPfoB-3c7EdHaGBAToAfuFICLQ",
            authDomain: "notifications-1bdfc.firebaseapp.com",
            databaseURL: "https://notifications-1bdfc.firebaseio.com",
            storageBucket: "notifications-1bdfc.appspot.com",
            messagingSenderId: "35118039506",
        };
    firebase.initializeApp(config);
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function () {
            console.log("Notification permission granted.");
            return messaging.getToken()
        })
        .then(function(token) {
            var encodedToken = encodeURIComponent(token);
            $('#token').val(encodedToken);
        })
        .catch(function (err) {
            console.log("Unable to get permission to notify.", err);
        });
        messaging.onMessage(function(payload) {
            var notification = new Notification(payload.notification.title, payload.notification);
            var url = payload.notification.click_action;
            var action = url.replace("'","");
            notification.onclick = function () {
                window.open(action.replace("'",""));
            };
            setTimeout(notification.close.bind(notification), 10000);
        });
    $(".placepicker").placepicker();
        $("#advanced-placepicker").each(function() {
        var target = this;
        var $collapse = $(this).parents('.form-group').next('.collapse');
        var $map = $collapse.find('.another-map-class');
        var placepicker = $(this).placepicker({
        map: $map.get(0),
        placeChanged: function(place) {
            console.log("place changed: ", place.formatted_address, this.getLocation());
        }
      }).data('placepicker');
    });
});
$(document).on("click", ".print", function() {
    var mode = 'iframe'; // popup
	var close = mode == "popup";
	var options = { mode : mode, popClose : close};
	$("#printarea").printArea( options );
});
$(document).on("click", "#datetimepicker", function() {
    var dis = $(this);
    dis.closest('.modal-body').find('.bootstrap-select').each(function() { $(this).remove() });
    dis.closest('.modal-body').find('.team').each(function() { $(this).html('Add');$(this).css('display','inline-block');$(this).removeAttr('disabled'); });
});
$(document).on("change", "#maintenance", function() {
    var maintenance = $(this).val();
    if(maintenance == '1')
    { 
        $(".ipaddress").show();
        $(".ipaddress").removeClass('hidden');
        $("#ipaddress").show();
        $("#ipaddress").removeClass('hidden');
        $("#ipaddress").attr('required','required');
    }
    else
    {
        $(".ipaddress").addClass('hidden');   
        $(".ipaddress").hide();
        $("#ipaddress").addClass('hidden'); 
        $("#ipaddress").hide();
        $("#ipaddress").removeAttr('required');
    }
});
$(document).on('change','#cttype',function (){ 
    var type = $(this).val();
    if(type == 'custom')
    {
        $('.iscustom').hide();
    }
    else if(type == 'cms')
    {
        $('.iscustom').show();
    }
});
$(document).ready(function() {
    var type = $('#cttype').val(); 
    if(type == 'custom')
    {
        $('.iscustom').hide();
    }
    else if(type == 'cms')
    {
        $('.iscustom').show();
    }
});
$(document).on('submit','#loginform',function(e){
    e.preventDefault();
    var baseUrl = $("#BaseUri").data('url');
    var action = $(this).data('action');
    var formData = $(this).serialize();
    $.ajax({
        type:'POST',
        url: action,  
        data:formData,
        beforeSend: function() {
            $("#login-submit").attr('disabled','disabled');
            $("#login-submit").html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(res){
            if(res == '1')  
                window.location.href = baseUrl + "home";
            else
                $('.log-error').html(res);
            $('#login-submit').removeAttr('disabled');
            $('#login-submit').html('Log In');
        },
        error: function(error,s) {
            console.log(error.responseText);
            $('#login-submit').removeAttr('disabled');
            $('#login-submit').html('Log In');        
        }
    });
});
$(document).ready(function() {
    $(".select2").select2();
});
$(document).on('click','#store',function(e){
    e.preventDefault();
    var baseUrl = $("#BaseUri").data('url');
	var Status = $(this).val();
	var This = $(this);
    $.ajax({
		url: baseUrl+'home/store/' + Status,
		type: 'GET',
		async: false,
		success: function (data) {
			if(data == '1'){
				This.val(data);
				This.html('<i class="fas fa-door-open"></i>');
				This.attr('class','btn btn-secondary btn-circle btn-lg m-t-5 btn-success');
				This.attr('title','Opened');
				This.attr('data-original-title','Opened');
			}
			else if(data == '2')
			{
				This.val(data);
				This.html('<i class="fas fa-door-closed"></i>');
				This.attr('class','btn btn-secondary btn-circle btn-lg m-t-5 btn-danger');
				This.attr('title','Closed');
				This.attr('data-original-title','Closed');
			}
			else
			{
				$.toast({
					heading: 'something went wrong!',
					text: 'Please try again',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 3500,
					stack: 6
				})
			}
		},
		error:function(e,s){
			console.log(e);
		}
	});
});
$(document).ready(function(){
	var baseUrl = $("#BaseUri").data('url');
	setInterval(function(){ 
        $.ajax({
            url: baseUrl+'home/notifications',
            success: function(data){
                if(data != 0)
                {
                    $("#notifications").html(data);
                    $(".notify").css('display','block');
                }
                else
                {
                    $("#notifications").html('<li  class="text-center" style="padding:6px 0 12px 0">No new orders</li>');
                    $(".notify").css('display','none'); 
                }
            }
        });
    }, 1000);
});
$(document).on('click','#export',function(){
    var r = confirm("Update only Details,Price,Discount,Today Special and Status.");
    if (r == true) {
        return true;
    } else {
        return false;
    }
});