/*jslint browser: true*/
/*global $, jQuery, alert*/

var baseUrl = $("#BaseUri").data('url');
$(document).ready(function () {

    "use strict";

    var body = $("body");

    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });
	
	$("#form-menu").submit(function(event){
   		event.preventDefault();
        var baseUrl = $("#BaseUri").data('url');
			$.ajax({
				url: baseUrl + "settings/menu",
				type:'POST',
				data: new FormData(this), 
				contentType: false,     
				cache: false,            
				processData:false, 
				beforeSend: function() {
					$(".preloader").css('display','block');
				},
				success:function(res)
				{
					if(res == 'true')
					{
						$(".preloader").css('display','none');
						$.toast({
							heading: 'Menu',
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
    /* ===== Open-Close Right Sidebar ===== */

    $(".right-side-toggle").on("click", function () {
        $(".right-sidebar").slideDown(50).toggleClass("shw-rside");
        $(".fxhdr").on("click", function () {
			$('#form-menu').submit();
			body.toggleClass("fix-header");
        });
        $(".fxsdr").on("click", function () {
			$('#form-menu').submit();
			body.toggleClass("fix-sidebar"); 
        });

        /* ===== Service Panel JS ===== */
		/*
        var fxhdr = $('.fxhdr');
        if (body.hasClass("fix-header")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
        if (body.hasClass("fix-sidebar")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
		*/
    });

    /* ===========================================================
        Loads the correct sidebar on window load.
        collapses the sidebar on window resize.
        Sets the min-height of #page-wrapper to window size.
    =========================================================== */

    $(function () {
        var set = function () {
                var topOffset = 60,
                    width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                    height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                if (width < 768) {
                    $('div.navbar-collapse').addClass('collapse');
                    topOffset = 100; /* 2-row-menu */
                } else {
                    $('div.navbar-collapse').removeClass('collapse');
                }
                /* ===== This is for resizing window ===== */
                var wrapper = body.attr('class');
                if(wrapper != 'content-wrapper')
                {
                    $(".open-close i").removeClass('icon-arrow-left-circle');
                    $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                    //$(".logo span").hide(); 
                }
                else
                {
                    if (width < 1170) {
                        body.addClass('content-wrapper');
                        $(".open-close i").removeClass('icon-arrow-left-circle');
                        $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                        $(".logo span").hide(); 
                        $(".logo b").show();
                    } else {
                        body.removeClass('content-wrapper');
                        $(".open-close i").addClass('icon-arrow-left-circle');
                        $(".logo span").show(); 
                        $(".logo b").show();
                    } 
                }
                height = height - topOffset;
                if (height < 1) {
                    height = 1;
                }
                if (height > topOffset) {
                    $("#page-wrapper").css("min-height", (height) + "px");
                }
            },
            url = window.location,
            element = $('ul.nav a').filter(function () {
                return this.href === url || url.href.indexOf(this.href) === 0;
            }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
        $(window).ready(set);
        $(window).on("resize", set);
    });

    /* ===================================================
        This is for click on open close button
        Sidebar open close
    =================================================== */

    $(".open-close").on('click', function () {
		$('#form-menu').submit();
		if ($("body").hasClass("content-wrapper")) {
			$("body").trigger("resize");
			$(".sidebar-nav, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
			$("body").removeClass("content-wrapper");
			$(".open-close i").addClass("icon-arrow-left-circle");
			$(".logo span").show();
		} else {
			$("body").trigger("resize");
			$(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
			$("body").addClass("content-wrapper");
			$(".open-close i").removeClass("icon-arrow-left-circle");
			$(".logo span").hide();
		}
    });

    /* ===== Collapsible Panels JS ===== */

    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]',
            panelRemover = '[data-perform="panel-dismiss"]';
        $(panelSelector).each(function () {
            var collapseOpts = {
                    toggle: false
                },
                parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper'),
                child = $(this).children('i');
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                child.removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function () {
                child.removeClass('ti-plus').addClass('ti-minus');
            });
        });

        /* ===== Collapse Panels ===== */

        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });

        /* ===== Remove Panels ===== */

        $(document).on('click', panelRemover, function (e) {
            e.preventDefault();
            var removeParent = $(this).closest('.panel');

            function removeElement() {
                var col = removeParent.parent();
                removeParent.remove();
                col.filter(function () {
                    return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
                }).remove();
            }
            removeElement();
        });
    }(jQuery, window, document));

    /* ===== Tooltip Initialization ===== */

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /* ===== Popover Initialization ===== */

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /* ===== Task Initialization ===== */

    $(".list-task li label").on("click", function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").on("click", function () {
        $("ul.theme_color").toggleClass("theme_block");
    });

    /* ===== Collepsible Toggle ===== */

    $(".collapseble").on("click", function () {
        $(".collapseblebox").fadeToggle(350);
    });

    /* ===== Sidebar ===== */

    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $('.slimscrollsidebar').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        railVisible: true,
        color: '#dcdcdc'
    });
    $('.chat-list').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    
    /* ===== Resize all elements ===== */

    body.trigger("resize");

    /* ===== Visited ul li ===== */

    $('.visited li a').on("click", function (e) {
        $('.visited li').removeClass('active');
        var $parent = $(this).parent();
        if (!$parent.hasClass('active')) {
            $parent.addClass('active');
        }
        e.preventDefault();
    });

    /* ===== Login and Recover Password ===== */

    $('#to-recover').on("click", function () {
		$("#results").html('');
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
	$('#to-login').on("click", function () {
		$("#results").html('');
        $("#loginform").fadeIn();
        $("#recoverform").slideUp();
    });

    /* ================================================================= 
        Update 1.5
        this is for close icon when navigation open in mobile view
    ================================================================= */

    $(".navbar-toggle").on("click", function () {
        $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
    });
});
$(document).ready(function (){
	var baseUrl = $("#BaseUri").data('url');
	$("#permission_form").submit(function(event){
		event.preventDefault();
		$.ajax({
			url: $(this).attr("action"),
			type:'POST',
			data: new FormData(this), 
			contentType: false,     
			cache: false,            
			processData:false, 
		    beforeSend: function() {
				$("#unlock_save").attr('disabled','disabled');
				$("#unlock_save").html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success:function(data)
			{
				if(data == true)
				{
					window.location.reload();
				}
				else
				{
					$("#unlock_save").removeAttr('disabled');
					$("#unlock_save").html('Save');
					$.toast({
						heading: 'Error',
						text: data,
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
	$("#recoverform").submit(function(event){
		event.preventDefault();
		$.ajax({
			url: $(this).attr("action"),
			type:'POST',
			data: new FormData(this), 
			dataType : "json",
			contentType: false,       
			cache: false,             
			processData:false, 
			beforeSend: function() {
				$("#reset").attr('disabled','disabled');
				$("#reset").html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success:function(res)
			{
				$("#reset").removeAttr('disabled');
				$("#reset").html('Reset');
				if(res.type == 'success')
					$("#email").val('');
				$("#results").html(res.text);
			},
			error: function(e,s) {
				alert(e.responseText);         
			}
		}); 
	});
	$("#lostpassword").submit(function(event){
		event.preventDefault();
		$.ajax({
			url: $(this).attr("action"),
			type:'POST',
			data: new FormData(this), 
			dataType : "json",
			contentType: false,       
			cache: false,             
			processData:false, 
			beforeSend: function() {
				$("#lost_submit").attr('disabled','disabled');
				$("#lost_submit").html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success:function(res)
			{
				$("#lost_submit").removeAttr('disabled');
				$("#lost_submit").html('Submit');
				if(res.type == 'success')
				{
					$("#new_pass").val('');
					$("#conf_pass").val('');
				}
				$("#results").html(res.text);
			},
			error: function(e,s) {
				console.log(e.responseText);         
			}
		}); 
	});
	$('.delete-alert').click(function(){
        var checkstr =  confirm('Are you sure you want to delete this?');
        if(checkstr == true){
          return true;
        }else{
            return false;
        }
    });
	$('.change_type').click(function(){
        var colname = $(this).data('colname');
		var tableid = $(this).data('tableid');
		$.ajax({
            url: baseUrl + "create/previousdata",
            type:'POST',
			data: { 'colname':colname, '8i5PtJZ5g8':csrf, 'tableid':tableid},
			dataType : "json",      
			cache: false,
			beforeSend: function() {
				$(".preloader").css('display','block');
			},
			success:function(data)
			{
				$(".modal-body #colname").val(colname);
				if(data.name != 'false')
				{
					//console.log(data);
					$("#ct_manage").val(data.type);
					$("#ct_manage").trigger("click");
					if(data.type == 'image')
					{
						setTimeout(function(){
							$("#gpsImage").val(data.crop).change();
							$("input[name=ct_width]").val(data.width);
							$("input[name=ct_height]").val(data.height);
						}, 100);
					}
					if(data.type == 'thumbs')
					{
						setTimeout(function(){
							$("input[name=small]").val(data.small);
							$("input[name=middle]").val(data.middle);
							$("input[name=big]").val(data.big);
						}, 100);
					}
					if(data.type == 'remote_image')
					{
						setTimeout(function(){
							$("input[name=links]").val(data.links);
						}, 100);
					}
					if(data.type == 'file')
					{
						setTimeout(function(){
							$('#gpsFile').val(data.frename).change();
						}, 100);
					}
					if(data.type == 'password')
					{
						setTimeout(function(){
							$('select[name="pencrypt"]').val(data.pencrypt).change();
						}, 100);
					}
					if(data.type == 'select')
					{
						setTimeout(function(){
							$('select[name="stype"]').val(data.stype).change();
							$("input[name=s_selected]").val(data.s_selected);
							$("input[name=s_options]").val(data.s_options);
						}, 100);
					}
					if(data.type == 'datetime')
					{
						setTimeout(function(){
							$('select[name="dtype"]').val(data.dtype).change();
						}, 100);
					}
					if(data.type == 'datetime')
					{
						setTimeout(function(){
							$('select[name="dtype"]').val(data.dtype).change();
						}, 100);
					}
					if(data.type == 'relation')
					{
						setTimeout(function(){
							$('select[name="tablename"]').val(data.tablename).change();
							$('select[name="tablename"]').trigger("click");
							setTimeout(function(){
								$('#valuename').val(data.valuename).change();
								$('#valuename').trigger("click");
								$('select[name="displayname"]').val(data.displayname).change();
								$('select[name="displayname"]').trigger("click");
								$('select[name="typename"]').val(data.typename).change();
								$("input[name=typevalue]").val(data.typevalue);
							}, 100);
						}, 100);
					}
					if(data.type == 'relation_depend')
					{
						setTimeout(function(){
							$('select[name="tablename"]').val(data.tablename).change();
							$('select[name="tablename"]').trigger("click");
							setTimeout(function(){
								$('#valuename').val(data.valuename).change();
								$('#valuename').trigger("click");
								$('select[name="displayname"]').val(data.displayname).change();
								$('select[name="displayname"]').trigger("click");
								$('select[name="typename"]').val(data.typename).change();
								$("input[name=typevalue]").val(data.typevalue);
								$('select[name="dependvaluename"]').val(data.dependvaluename).change();
								$('select[name="dependcolname"]').val(data.dependcolname).change();
							}, 100);
						}, 100);
					}
					if(data.type == 'join')
					{
						setTimeout(function(){
							$('select[name="tablename"]').val(data.tablename).change();
							$('select[name="tablename"]').trigger("click");
							setTimeout(function(){
								$('#valuename').val(data.valuename).change();
								$('#valuename').trigger("click");
							}, 100);
						}, 100);
					}
					if(data.type == 'highlight')
					{
						setTimeout(function(){
							$("input[name=condition]").val(data.condition);
							$("input[name=valuename]").val(data.valuename);
							$("input[name=colorcode]").val(data.color);
						}, 100);
					}
					if(data.type == 'highlight_row')
					{
						setTimeout(function(){
							$("input[name=condition]").val(data.condition);
							$("input[name=valuename]").val(data.valuename);
							$("input[name=colorcode]").val(data.color);
						}, 100);
					}
				}
				else
				{
					$("#ct_manage").val('');
					$("#ct_manage").trigger("click");
				}
				$(".preloader").css('display','none');
			},
			 error: function(e,s) {
				console.log(e.responseText);         
			}
        }); 
    });
	$('.defaults').change(function(){
        var value = $(this).val();
		if(value == 'USER_DEFINED')
			$(".default").show();
		else
			$(".default").css("display","none");
    });
	var csrf = $('input[name="8i5PtJZ5g8"]').val();
	$(".ct_manage").click(function(){
		$.ajax({
			type: "POST",
			url: baseUrl +"manage",
			cache: false,
			data:{ ct_type:$(".ct_manage").val(),'8i5PtJZ5g8':csrf }
		}).done(function(result){
		if($(".ct_manage").val()!='')
			{	
				$(".item_list").css("display","block");
				$(".from_div").css("display","flex");
				if($(".ct_manage").val() == 'relation')
					{
						$(".relsyntax").css("display","block");
						$(".reldepsyntax").css("display","none");
					}
				else if($(".ct_manage").val() == 'relation_depend')
					{
						$(".reldepsyntax").css("display","block");
						$(".relsyntax").css("display","none");
					}
				else
					{
						$(".reldepsyntax").css("display","none");
						$(".relsyntax").css("display","none");
					}
				$(".from_div").html(result);
			}
			else
			{
				$(".from_div").css("display","none");
				$(".relsyntax").css("display","none");
				$(".reldepsyntax").css("display","none");
			}
		})
	});
	$("#ct_form").submit(function(event){
   		event.preventDefault();
        $.ajax({
            url: baseUrl + "manage/submit",
            type:'POST',
			data: new FormData(this),
			contentType: false,    
			cache: false,             
			processData:false,
			beforeSend: function() {
            $("#change_type_save").attr('disabled','disabled');
            $('#change_type_save').html('<i class="fa fa-spinner fa-spin"></i>');
        },
		success:function(data)
        {
            $("#change_type_save").removeAttr('disabled');
            $('#change_type_save').html('Save');
			$.toast({
				heading: 'Field Type',
				text: data,
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 3500,
				stack: 6
			})
           
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
        }); 
    });
	$("#menu_form1").submit(function(event){
   		event.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type:'POST',
			data: new FormData(this),
			contentType: false,    
			cache: false,             
			processData:false,
			beforeSend: function() {
            $("#addparent").attr('disabled','disabled');
            $('#addparent').html('<i class="fa fa-spinner fa-spin"></i>');
        },
		success:function(data)
        {
            $("#addparent").removeAttr('disabled');
            $('#addparent').html('Add Parent');
			if(data != 'false')
			{
				$("#error").html('');
				$("#treeMenu").html(data);
			}
			else
				$("#error").html('<div class="alert alert-danger"> Already Existed </div>');
           
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
        }); 
    });
	//$("ul.nav-tree:nth-child(2)").addClass("nav-second-level");
	//$("ul.nav-tree:nth-child(3)").addClass("nav-third-level");
	//$('.nav-second-level').parent('li').find('.arrow').first().css('display','block');
	//$('.nav-third-level').parent('li').find('.arrow').first().css('display','block');
});
$(document).on("click", ".tablename", function(event) {
	event.preventDefault();
	var baseUrl = $("#BaseUri").data('url');
	var depend = $("#tablename").data('depend');
	var ptname = $("#hidetablename").data('ptname');
	var csrf = $('input[name="8i5PtJZ5g8"]').val();
	$.ajax({
	    type: "POST",
	    url: baseUrl +"manage/gettablecolums",
	    cache: false,
	    data:{ 'tablename':$(".tablename").val(),'8i5PtJZ5g8':csrf, 'depend':depend, 'ptname':ptname }
	}).done(function(result){
		if($(".tablename").val()!='')
		{	
			$(".table_div").css("display","flex");
			$(".table_div").html(result);
		}
		else
		{
			$(".table_div").css("display","none");
			$(".relsyntax").css("display","none");
			$(".reldepsyntax").css("display","none");
		}
	});
});
$(document).on("click", ".location", function(event) {
	event.preventDefault();
	$(".data").css("display","none");
	var baseUrl = $("#BaseUri").data('url');
    var ip = $(this).data('ip');
    $(".modal-header #ip").html( ip );
        $.ajax({
            url: baseUrl + "Location",
            type:'GET',
			data: { ip: ip },
			beforeSend: function() {
            $(".loading").show();
            $('.loading').html('<i class="fa fa-spinner fa-spin"></i>');
        },
	success:function(data)
        {
            $(".loading").css("display","none");
			$(".data").css("display","block");
			$(".data").html(data);
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
    }); 
});
$(document).ready(function (){
	$("#unclockbutton").trigger("click");
});
$(document).on("click", ".renamecolumn", function () {
     var rename = $(this).data('name');
	 var type = $(this).data('type');
	 var lenght = $(this).data('lenght');
	 var defaults = $(this).data('default');
     $(".modal-header #rename").html( rename );
     $(".modal-body #columnname").val( rename );
	 $(".modal-body #type").val( type );
	 $(".modal-body #lenght").val( lenght );
	 $(".modal-body #default").val( defaults );
});
$(document).on("click", ".editcolumn", function () {
     var rename = $(this).data('name');
	 var tname = $(this).data('tname');
	 var id = $(this).data('id');
     $(".modal-header #rename").html( rename );
     $(".modal-body #columnname").val( rename );
	 $.ajax({
            url: baseUrl + "tables/edit_column/" + tname,
            type:'GET',
			data: { id: id },
			beforeSend: function() {
            $(".loading").show();
            $('.loading').fadeIn(400).html('<img src="'+baseUrl+'img/loading.gif" /> <b>Please Wait...</b>').fadeIn("slow");
        },
   success:function(data)
        {
            $(".loading").css("display","none");
			$(".data").css("display","block");
			$(".data").html(data);
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
        }); 
});

$(document).ready(function(){
	var baseUrl = $("#BaseUri").data('url');
    $("#edit_columns").submit(function(event){
   	event.preventDefault();
	var tablename = $(".tablename").val();
	$.ajax({
	    type: "POST",
	    url: baseUrl +"tables/edit_column_submit/" + tablename,
		data: new FormData(this),
		contentType: false,    
		cache: false,             
		processData:false,
	beforeSend: function() {
            $(".loading").show();
            $('.loading').fadeIn(600).html('<img src="'+baseUrl+'img/loading.gif" /> <b>Please Wait...</b>').fadeIn("slow");
        },
   success:function(res)
        {
            $(".loading").css("display","none");
			$(".manage_eff").css("display","block");
			if(res == true)
			{
				$(".manage_eff").html("<div class='alert alert-success'>Successfully Updated.</div>").delay(1200).fadeOut();
				window.setTimeout(window.location.reload() ,900);
			}
			else
				$(".manage_eff").html(res).delay(1200).fadeOut();
				
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
		});
});
})
$(document).ready(function(){
	var baseUrl = $("#BaseUri").data('url');
    $("#rename_form").submit(function(event){
   	event.preventDefault();
	var tablename = $(".tablename").val();
	$.ajax({
	    type: "POST",
	    url: baseUrl +"tables/rename",
		data: new FormData(this),
		contentType: false,    
		cache: false,             
		processData:false,
	beforeSend: function() {
			$(".columnRename").attr('disabled','disabled');
			$(".columnRename").html('<i class="fa fa-spinner fa-spin"></i>');
        },
   success:function(data)
        {
            $(".columnRename").removeAttr('disabled');
            $('.columnRename').html('Save');
			if(data == true)
			{
				window.location.href = baseUrl + "tables/manage/" + tablename;
			}
			else
			{
				$.toast({
					heading: 'Error',
					text: data,
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
})
$(document).ready(function(){
	var baseUrl = $("#BaseUri").data('url');
    $("#add_columns").submit(function(event){
   	event.preventDefault();
	var tablename = $(".tablename").val();
	$.ajax({
	    type: "POST",
	    url: baseUrl +"tables/columns/" + tablename,
		data: new FormData(this),
		contentType: false,    
		cache: false,             
		processData:false,
	beforeSend: function() {
            $(".loading").show();
            $('.loading').fadeIn(600).html('<img src="'+baseUrl+'img/loading.gif" /> <b>Please Wait...</b>').fadeIn("slow");
        },
   success:function(res)
        {
            $(".loading").css("display","none");
			$(".manage_eff").css("display","block");
			if(res != true)
			{
				$(".manage_eff").html("<div class='alert alert-success'>Successfully Added.</div>").delay(1200).fadeOut();
				window.setTimeout(window.location.reload() ,900);
			}
			else
				$(".manage_eff").html(res).delay(1200).fadeOut();
				
        },
         error: function(e,s) {
            alert(e.responseText);         
        }
		});
});
});
$(document).ready(function(){
	var segments = window.location.pathname.split( '/' );
	var reloadPages = segments[2];
	if(reloadPages == 'create' || reloadPages == 'settings' || reloadPages == 'tables')
	{
		setTimeout(function(){
		   window.location.reload();
		}, 15 * 60 * 1000);
	}
});

