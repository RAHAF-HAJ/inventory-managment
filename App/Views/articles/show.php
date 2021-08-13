<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Product info</span>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <h1><?= $article->desig ?></h1>
        </div>
        <div class="col-sm-4">
            <img src="<?= App::$path ?>img/thumbs/articles/<?= $article->thumb ?>" class="img-responsive">
        </div>
        <div class="col-sm-8">
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">Code</label>
                <p class="col-xs-12 col-sm-10"><?= $article->ref ?></p>
            </div>
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">Unit</label>
                <p class="col-xs-12 col-sm-10"><?= $article->unit ?></p>
            </div>
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">TVA</label>
                <p class="col-xs-12 col-sm-10"><?= $article->tva ?></p>
            </div>
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">Category</label>
                <p class="col-xs-12 col-sm-10"><?= $article->category ?></p>
            </div>
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">Supplier</label>
                <p class="col-xs-12 col-sm-10"><?= $article->name ?></p>
            </div>
            <div class="col-xs-12">
                <label class="col-xs-12 col-sm-2">Color</label>
                <p class="col-xs-12 col-sm-10"><?= $article->color ?></p>
            </div>

        </div>

    </div>
    <div class="row text-center">
        <hr>
        <a href="<?= App::$path ?>article/printinfos/<?= $article->id ?>" target="_blank" class="btn btn-primary">
            <i class="fa fa-print"></i>

            Print</a>
    </div>
</section>
