<link href="<?= ROOT ?>/public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
    require_once ROOT.'/App/Views/pdf/pdf-header-footer.php';
    ?>


    <table class="pdf-table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="ref">Code</th>
            <th class="desig">Name</th>
            <th class="unit">Unit</th>
            <th class="category">Category</th>
            <th class="tva">TVA</th>
            <th class="supplier">Supplier</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($articles as $art): ?>
            <tr>
                <td><?= $art->ref ?></td>
                <td><?= $art->desig ?></td>
                <td><?= $art->unit ?></td>
                <td><?= $art->category ?></td>
                <td><?= $art->tva ?></td>
                <td><?= $art->supplier_name ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





</page>