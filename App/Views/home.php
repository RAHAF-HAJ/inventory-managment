<section class="content-header">
    <span class="content-title"><i class="fa fa-home"></i> Home</span>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-container">
                    <a class="item" href="<?= App::$path ?>inventory/index">
                        <div class="count"><h2><?=$inventories?></h2></div>
                        <h2>Inventories</h2>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-container">
                    <a class="item" href="<?= App::$path ?>sale/index">
                        <div class="count"><h2><?=$sales?></h2></div>
                        <h2>Saless</h2>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-container">
                    <a  class="item" href="<?= App::$path ?>purchase/index">
                        <div class="count"><h2><?=$purchases?></h2></div>
                        <h2>Purchases</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding-top: 30px">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-container">
                    <h2>Top sales</h2>
                    <table class="table">
                        <thead>
                            <th>Product name</th>
                            <th>Sale quantity</th>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($top_articles)) {
                                    foreach ($top_articles as $article) {
                                        echo '<tr>';
                                        echo '<td> <a href="'. App::$path .'article/show/'. $article->article_id .'">' . $article->desig . '</a></td>';
                                        echo '<td>'. $article->qty .'</td>';
                                        echo '<tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</section>
