<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?=base_url().'../uploads/'.$site[0]->favicon;?>" />
        <title><?=$title;?> | <?=$site[0]->title;?> </title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="<?=base_url('css/maintenance.css');?>" rel="stylesheet">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="error-template">
                        <h1>
                            :) Oops!</h1>
                        <h2>
                            Temporarily down for maintenance</h2>
                        <h1>
                            We’ll be back soon!</h1>
                        <div>
                            <p>
                                Sorry for the inconvenience but we’re performing some maintenance at the moment.
                                we’ll be back online shortly!</p>
                            <p>
                                — <?=$site[0]->title;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <svg class="svg-box" width="380px" height="500px" viewbox="0 0 837 1045">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z" id="Polygon-1" stroke="#3bafda" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#7266ba" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#f76397" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#00b19d" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#ffaa00" stroke-width="6" sketch:type="MSShapeGroup"></path>
                            </g>
                        </svg>
                </div>
            </div>
        </div>
    </body>
</html>