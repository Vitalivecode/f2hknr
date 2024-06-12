		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-md-4 col-xs-12">
                        <h4 class="page-title"><?=$title;?></h4> </div>
                    <div class="col-lg-9 col-md-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>">Home</a></li>
                            <li class="active"><?=$title;?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				  <div class="row">
					<div class="col-lg-12">
						<section id="wrapper" class="error-page">
							<div class="error-box" style="position: relative;">
								<div class="error-body text-center">
									<h1>404</h1>
									<h3 class="text-uppercase">Page Not Found !</h3>
									<p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
									<a href="<?=base_url();?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> 
								</div>
							</div>
						</section>
					</div>
				  </div>
            </div>
