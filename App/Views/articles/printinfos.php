<link href="<?= ROOT ?>/public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
    require_once ROOT.'/App/Views/pdf/pdf-header-footer.php';
    ?>

<h1 style="text-align: center; margin-bottom: 2mm"><?= $article->desig ?></h1>
    <table class="table-article-infos">
        <tr>
            <td class="article-infos">
                <table class="pdf-table table-article-infos" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="td-label">Code</td>
                        <td class="td-info"><?= $article->ref ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Name</td>
                        <td class="td-info"><?= $article->desig ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Unit</td>
                        <td class="td-info"><?= $article->unit ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Category</td>
                        <td class="td-info"><?= $article->category ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">TVA</td>
                        <td class="td-info"><?= $article->tva ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Supplier</td>
                        <td class="td-info"><?= $article->name ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Color</td>
                        <td class="td-info"><?= $article->color ?></td>
                    </tr>
                </table>
            </td>
            <td class="article-img">
                <img src="img/thumbs/articles/<?= $article->thumb ?>" style="width: 300px; height: 260px">
            </td>
        </tr>
    </table>





</page>