<?php if($ct != false) { $arrayCategories = array(); foreach($ct as $list) {  $arrayCategories[$list->parent_id] = array("parent_id" => $list->child_id, "name" =>                       
$list->cttitle, "tableid" => $list->parent_id, "order" => $list->menu_order, "tablename" => $list->table_name, "icon" => $list->icon); } } ?>
<?php
function createTreeView($array, $currentParent, $editmenu, $currLevel = 0, $prevLevel = -1 ) { 
	$no = 0;
	foreach ($array as $categoryId => $category) {
		if ($currentParent == $category['parent_id']) {                       
			if ($currLevel > $prevLevel) echo " <ul id='tree'> "; 
			if ($currLevel == $prevLevel) echo " </li> ";
			if($editmenu[0]->child_id == $category['tableid'])
				$checked = 'checked';
			else
				$checked = '';
			if($editmenu[0]->parent_id != $category['tableid'])
				$radiobutton = '<input type="radio" id="'.$category['name'].'" name="child_id" value="'.$category['tableid'].'" '.$checked.'  />';
			else
				$radiobutton = '';
			if($category['icon'] != '')
				$icon = '<i class="'.$category['icon'].'"> '.$category['name'].'</i>';
			else
				$icon = $category['name'];
			echo '<li><a href="'.base_url().'menu/edit/'.$category['tableid'].'">'.$category['order'].'. '.$radiobutton.' <label for="'.$category['name'].'"> '.$icon.'</label></a>';
			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
			$currLevel++; 
			createTreeView ($array, $categoryId, $editmenu, $currLevel, $prevLevel);
			$currLevel--;               
		}  
	$no++;
	}
	if ($currLevel == $prevLevel) echo " </li>  </ul> ";
} 
?>
	<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?=$title;?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>">Home</a></li>
                            <li><a href="<?=base_url().'menu';?>">Menu</a></li>
                            <li class="active"><?=$title;?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
						<?php if($editmenu != false) { ?>
							<form method="post" class="form-material form-horizontal" id="menu_form" action="<?=base_url();?>menu/edit/<?=$this->uri->segment(3);?>">
								<div class="gps-view">
									<div class="form-horizontal">
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<?php if($editmenu[0]->table_name == '#') { ?>
														<div class="col-md-10" id="alert"><?=$alert;?></div>
														<div class="col-md-10"><input class="form-control" id="parent" name="parent" value="<?=(set_value('parent')) ? set_value('parent') : $editmenu[0]->name;?>" placeholder="Parent Name" required type="text"></div>
													<?php } else { ?>
														<input type="hidden" id="parent" name="parent" value="<?=$editmenu[0]->name;?>" />
													<?php } ?>
													<div class="col-md-10"><input class="form-control" min="0" id="position" name="position" value="<?=(set_value('position')) ? set_value('position') : $editmenu[0]->menu_order;?>" placeholder="Position" required type="number"></div>
													<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
												</div>
												<div class="col-md-6">
													<div id="treeMenu">
														<div id="treeview" class="treeview">
															<ul class="tree">
																<li><input type="radio" id="parentid" name="child_id" value="0"> Parent</li>
															</ul>
															<?php
																if($ct != false) {
																	createTreeView($arrayCategories, 0, $editmenu);
																}
															?>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-offset-3 col-md-6 m-t-20">
													<a class="btn btn-default pull-right" href="<?=base_url();?>menu">Back</a>
													<button class="btn <?=$site[0]->theme;?> pull-right m-r-20" id="addparent" type="submit">Update</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						<?php } ?>
                        </div>
                    </div>
                </div>
                <!--row -->
            </div>
<script>
	$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
		/*
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
		*/
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

$('#tree').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
$(document).ready(function (){
	$(".branch").trigger("click");
});
</script>
